<?php

namespace App\Services;

use App\Models\CessaoBomba;

class PumpLoanTermService
{
    public function snapshot(CessaoBomba $loan): array
    {
        $loan->load(['bomba.modelo', 'beneficiaria', 'usuarioRetirada', 'pagamentos']);
        $money = fn ($value) => 'R$ '.number_format((float) $value, 2, ',', '.');

        return [
            'number' => $loan->id,
            'issued_at' => now()->format('d/m/Y H:i'),
            'type' => $loan->tipo === 'aluguel' ? 'Aluguel' : 'Empréstimo gratuito',
            'beneficiary' => [
                'name' => $loan->beneficiaria->nome,
                'cpf' => $loan->beneficiaria->cpf,
                'phone' => $loan->beneficiaria->telefone,
            ],
            'pump' => [
                'code' => $loan->bomba->codigo,
                'model' => trim(($loan->bomba->modelo?->fabricante ?? '').' '.($loan->bomba->modelo?->modelo ?? '')),
                'serial' => $loan->bomba->num_serie,
                'accessories' => $loan->bomba->acessorios,
            ],
            'responsible' => $loan->usuarioRetirada?->nome ?? '-',
            'withdrawn_at' => $loan->data_retirada->format('d/m/Y'),
            'expected_return' => $loan->data_prevista_devolucao->format('d/m/Y'),
            'monthly_fee' => $loan->tipo === 'aluguel' ? $money($loan->valor_mensalidade) : 'Sem cobrança',
            'due_day' => $loan->dia_vencimento,
            'billing_method' => ['pix' => 'Pix', 'dinheiro' => 'Dinheiro', 'boleto' => 'Boleto'][$loan->forma_cobranca] ?? '-',
            'first_billing_at' => $loan->primeira_cobranca_em?->format('d/m/Y'),
            'notes' => $loan->observacao_retirada,
            'payments' => $loan->pagamentos->map(fn ($payment) => [
                'reference' => $payment->competencia?->format('m/Y'),
                'amount' => $money($payment->valor),
                'due_at' => $payment->data_vencimento?->format('d/m/Y'),
                'paid_at' => $payment->data_pagamento?->format('d/m/Y') ?? '-',
                'status' => ['pendente' => 'Pendente', 'pago' => 'Pago', 'atrasado' => 'Em atraso', 'cancelado' => 'Cancelado'][$payment->situacao] ?? $payment->situacao,
                'notes' => $payment->observacao,
            ])->all(),
        ];
    }
}
