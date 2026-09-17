<?php
namespace App\Console\Commands;
use App\Services\AprioriEngine;
use Illuminate\Console\Command;
class CalculateApriori extends Command { protected $signature='apriori:calculate {--scheduled}'; protected $description='Generate valid cross-selling association rules'; public function handle(AprioriEngine $engine): int { $result=$engine->calculate($this->option('scheduled') ? 'scheduler' : 'manual'); $this->info("{$result['total_rules_generated']} aturan dibuat dari {$result['total_transactions']} transaksi ({$result['execution_time_ms']} ms)."); return self::SUCCESS; } }
