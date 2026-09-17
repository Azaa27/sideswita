<?php

namespace App\Services;

use App\Models\AprioriConfig;
use App\Models\AprioriLog;
use App\Models\AssociationRule;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AprioriEngine
{
    public function calculate(string $trigger = 'manual', ?int $userId = null): array
    {
        $started = hrtime(true); $config = AprioriConfig::firstOrFail();
        $baskets = Transaction::query()->where('status', 'completed')->with('items:id,transaction_id,product_id')->get()
            ->map(fn ($t) => $t->items->pluck('product_id')->unique()->sort()->values()->all())->filter()->values()->all();
        $total = count($baskets);
        if (!$total) return $this->log($trigger,$userId,0,0,0,$started,'no_data');
        $support = fn(array $set) => count(array_filter($baskets, fn($basket) => !array_diff($set,$basket))) / $total;
        $ids = array_values(array_unique(array_merge(...$baskets))); sort($ids); $frequent=[]; $single=[];
        foreach ($ids as $id) { $value=$support([$id]); if ($value >= $config->min_support) { $single[$id]=$value; $frequent[]=[[$id],$value]; } }
        $rules=[];
        foreach (array_keys($single) as $a) foreach (array_keys($single) as $b) if ($a !== $b) {
            $pair=$support([$a,$b]); $confidence=$pair/$single[$a]; $lift=$confidence/$single[$b];
            if ($pair >= $config->min_support && $confidence >= $config->min_confidence && $lift > 1) $rules[]=['antecedent_product_id'=>$a,'consequent_product_id'=>$b,'support'=>$pair,'confidence'=>$confidence,'lift_ratio'=>$lift,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()];
        }
        DB::transaction(function () use ($rules) { AssociationRule::query()->delete(); if ($rules) AssociationRule::insert($rules); });
        $config->update(['last_calculated_at'=>now(),'total_rules_last_run'=>count($rules)]);
        return $this->log($trigger,$userId,$total,count($frequent),count($rules),$started,'success');
    }
    private function log($trigger,$userId,$transactions,$itemsets,$rules,$started,$status): array { $result=['total_transactions'=>$transactions,'total_frequent_itemsets'=>$itemsets,'total_rules_generated'=>$rules,'execution_time_ms'=>(int)((hrtime(true)-$started)/1e6),'status'=>$status]; AprioriLog::create($result+['triggered_by'=>$trigger,'triggered_by_user_id'=>$userId]); return $result; }
}
