<?php

namespace App\Services;

use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\CessaoBomba;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PumpLoanService
{
    public function createOptions(): array
    {
        return [
            'availablePumps' => BombaLeite::query()
                ->with('modelo')
                ->where('situacao', 'disponivel')
                ->orderBy('codigo')
                ->get()
                ->map(fn (BombaLeite $pump) => [
                    'id' => $pump->id,
                    'code' => $pump->codigo,
                    'model' => $pump->modelo ? trim($pump->modelo->fabricante.' '.$pump->modelo->modelo) : '-',
                ])
                ->all(),
            'beneficiaries' => Beneficiaria::where('situacao', 'ativo')->orderBy('nome')->pluck('nome', 'id')->all(),
            'billingMethods' => ['pix' => 'Pix', 'dinheiro' => 'Dinheiro', 'boleto' => 'Boleto'],
        ];
    }

    public function create(array $data, int $userId): CessaoBomba
    {
        return DB::transaction(function () use ($data, $userId) {
            $pump = BombaLeite::query()->lockForUpdate()->findOrFail($data['pump']);
            abort_unless($pump->situacao === 'disponivel', 409);
            $isRental = $data['contract_type'] === 'aluguel';
            $firstBilling = $isRental ? Carbon::parse($data['first_billing_at']) : null;
            $loan = CessaoBomba::create([
                'id_bomba' => $data['pump'],
                'id_beneficiaria' => $data['beneficiary'],
                'id_usuario_retirada' => $userId,
                'tipo' => $isRental ? 'aluguel' : 'gratuita',
                'valor_mensalidade' => $isRental ? $data['monthly_fee'] : null,
                'dia_vencimento' => $isRental ? $data['due_day'] : null,
                'forma_cobranca' => $isRental ? $data['billing_method'] : null,
                'primeira_cobranca_em' => $firstBilling,
                'proxima_cobranca_em' => $firstBilling?->copy()->startOfMonth()->addMonth(),
                'data_retirada' => $data['withdrawn_at'],
                'data_prevista_devolucao' => $data['expected_return'],
                'situacao' => 'ativa',
                'observacao_retirada' => $this->withdrawalNotes($data),
            ]);

            $pump->update(['situacao' => 'alugada']);

            if ($isRental) {
                $loan->pagamentos()->create([
                    'competencia' => $firstBilling->copy()->startOfMonth(),
                    'valor' => $data['monthly_fee'],
                    'data_vencimento' => $data['first_billing_at'],
                    'situacao' => 'pendente',
                    'observacao' => $this->billingNotes($data),
                ]);
            }

            return $loan->refresh();
        });
    }

    private function withdrawalNotes(array $data): ?string
    {
        return collect([
            'Termo: '.($data['term_signed'] ? 'assinado' : 'não assinado'),
            $data['notes'] ?? null,
        ])->filter()->join("\n") ?: null;
    }

    private function billingNotes(array $data): ?string
    {
        return collect([
            'Forma de cobrança: '.$this->billingMethodLabel($data['billing_method'] ?? null),
            'Dia de vencimento: '.($data['due_day'] ?? '-'),
            $data['billing_notes'] ?? null,
        ])->filter(fn (?string $value) => filled($value))->join("\n") ?: null;
    }

    private function billingMethodLabel(?string $method): string
    {
        return Str::ucfirst(['pix' => 'Pix', 'dinheiro' => 'dinheiro', 'boleto' => 'boleto'][$method] ?? '-');
    }
}
