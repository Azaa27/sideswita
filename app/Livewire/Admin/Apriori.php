<?php

namespace App\Livewire\Admin;

use App\Models\AprioriConfig;
use App\Models\AprioriLog;
use App\Models\AssociationRule;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\AprioriEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.store')]
class Apriori extends Component
{
    public float $min_support = .10;
    public float $min_confidence = .60;
    public bool $schedule_enabled = true;
    public bool $showMatrix = false;

    public function mount(): void
    {
        $config = AprioriConfig::firstOrFail();
        $this->min_support = $config->min_support;
        $this->min_confidence = $config->min_confidence;
        $this->schedule_enabled = $config->schedule_enabled;
    }

    public function save(): void
    {
        AprioriConfig::firstOrFail()->update($this->validate([
            'min_support' => 'required|numeric|min:.01|max:1',
            'min_confidence' => 'required|numeric|min:.01|max:1',
            'schedule_enabled' => 'boolean',
        ]));

        $this->dispatch('toast', type: 'success', message: 'Parameter Apriori disimpan.');
    }

    public function calculate(AprioriEngine $engine): void
    {
        $result = $engine->calculate('manual', auth()->id());
        $this->dispatch('toast', type: 'success', message: "Kalkulasi selesai: {$result['total_rules_generated']} aturan valid dibuat.");
    }

    public function toggleMatrix(): void
    {
        $this->showMatrix = ! $this->showMatrix;
    }

    public function render()
    {
        $matrixProducts = collect();
        $matrixRows = collect();

        if ($this->showMatrix) {
            $matrixProducts = Product::query()
                ->orderBy('code')
                ->get(['id', 'code', 'name']);

            $matrixRows = Transaction::query()
                ->where('status', 'completed')
                ->with('items:id,transaction_id,product_id')
                ->latest('id')
                ->take(10)
                ->get()
                ->map(fn (Transaction $transaction) => [
                    'transaction_code' => $transaction->transaction_code,
                    'product_ids' => array_fill_keys($transaction->items->pluck('product_id')->unique()->all(), true),
                ]);
        }

        return view('livewire.admin.apriori', [
            'rules' => AssociationRule::with(['antecedent', 'consequent'])->orderByDesc('lift_ratio')->get(),
            'logs' => AprioriLog::latest()->take(10)->get(),
            'matrixProducts' => $matrixProducts,
            'matrixRows' => $matrixRows,
        ]);
    }
}
