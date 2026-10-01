<?php

namespace App\Services;

use App\Models\CessaoBomba;
use App\Models\PagamentoAluguel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RentalBillingService
{
    public function process(Carbon $today): int
    {
        PagamentoAluguel::query()->where('situacao', 'pendente')->whereDate('data_vencimento', '<', $today->toDateString())->update(['situacao' => 'atrasado']);

        return CessaoBomba::query()->where('tipo', 'aluguel')->whereIn('situacao', ['ativa', 'atrasada'])->whereNull('data_devolucao')->whereDate('proxima_cobranca_em', '<=', $today->toDateString())->get()->sum(fn (CessaoBomba $loan) => $this->generate($loan, $today));
    }

    public function dueDate(Carbon $competence, int $day): Carbon
    {
        return $competence->copy()->startOfMonth()->day(min($day, $competence->daysInMonth));
    }

    private function generate(CessaoBomba $loan, Carbon $today): int
    {
        return DB::transaction(function () use ($loan, $today) {
            $created = 0;
            $cursor = $loan->proxima_cobranca_em->copy()->startOfMonth();
            while ($cursor->lte($today->copy()->startOfMonth())) {
                $dueDate = $this->dueDate($cursor, $loan->dia_vencimento);

                if ($loan->data_prevista_devolucao && $dueDate->gt($loan->data_prevista_devolucao)) {
                    break;
                }

                if ($dueDate->gt($today)) {
                    break;
                }

                $payment = PagamentoAluguel::firstOrCreate(['id_cessao' => $loan->id, 'competencia' => $cursor->toDateString()], ['valor' => $loan->valor_mensalidade, 'data_vencimento' => $dueDate, 'situacao' => $dueDate->lt($today) ? 'atrasado' : 'pendente']);
                $created += $payment->wasRecentlyCreated ? 1 : 0;
                $cursor->addMonth();
            }
            $loan->update(['proxima_cobranca_em' => $cursor]);

            return $created;
        });
    }
}
