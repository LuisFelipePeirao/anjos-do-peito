<?php

namespace App\Console\Commands;

use App\Services\RentalBillingService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateRentalPayments extends Command
{
    protected $signature = 'rentals:generate-payments {--date=}';

    protected $description = 'Gera parcelas recorrentes de aluguéis de bombas.';

    public function handle(RentalBillingService $billing): int
    {
        $count = $billing->process(Carbon::parse($this->option('date') ?: now())->startOfDay());
        $this->info("{$count} parcela(s) gerada(s).");

        return self::SUCCESS;
    }
}
