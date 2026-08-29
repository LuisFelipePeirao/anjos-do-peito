<?php

namespace App\Services;

use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\CessaoBomba;
use Illuminate\Support\Facades\DB;
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
            'renewals' => ['none' => 'Sem renovação automática', '30_days' => 'A cada 30 dias', '60_days' => 'A cada 60 dias'],
            'billingMethods' => ['pix' => 'Pix', 'dinheiro' => 'Dinheiro', 'boleto' => 'Boleto'],
        ];
    }

    public function create(array $data, int $userId): CessaoBomba
    {
        return DB::transaction(function () use ($data, $userId) {
            $loan = CessaoBomba::create([
                'id_bomba' => $data['pump'],
                'id_beneficiaria' => $data['beneficiary'],
                'id_usuario_retirada' => $userId,
                'tipo' => $data['contract_type'] === 'aluguel' ? 'aluguel' : 'gratuita',
                'valor_mensalidade' => $data['contract_type'] === 'aluguel' ? $data['monthly_fee'] : null,
                'data_retirada' => $data['withdrawn_at'],
                'data_prevista_devolucao' => $data['expected_return'],
                'situacao' => 'ativa',
                'observacao_retirada' => $this->withdrawalNotes($data),
            ]);

            BombaLeite::whereKey($data['pump'])->update(['situacao' => 'alugada']);

            if ($data['contract_type'] === 'aluguel') {
                $loan->pagamentos()->create([
                    'competencia' => $data['first_billing_at'],
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
            filled($data['renewal'] ?? null) && $data['renewal'] !== 'none' ? 'Renovação: '.$this->renewalLabel($data['renewal']) : null,
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

    private function renewalLabel(?string $renewal): string
    {
        return ['30_days' => 'a cada 30 dias', '60_days' => 'a cada 60 dias'][$renewal] ?? 'sem renovação automática';
    }

    private function billingMethodLabel(?string $method): string
    {
        return Str::ucfirst(['pix' => 'Pix', 'dinheiro' => 'dinheiro', 'boleto' => 'boleto'][$method] ?? '-');
    }
}
