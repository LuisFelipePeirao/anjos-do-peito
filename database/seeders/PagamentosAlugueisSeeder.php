<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagamentosAlugueisSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 101, '2026-08-01', 45.00, '2026-08-10', '2026-08-09', 'pago', 'Pagamento via PIX.'],
            [102, 101, '2026-09-01', 45.00, '2026-09-10', null, 'pendente', 'Aguardando vencimento.'],
            [103, 104, '2026-08-01', 55.00, '2026-08-20', null, 'atrasado', 'Contato realizado.'],
            [104, 104, '2026-09-01', 55.00, '2026-09-20', null, 'pendente', 'Boleto gerado.'],
            [105, 105, '2026-06-01', 0.00, '2026-06-10', null, 'cancelado', 'Cessao cancelada.'],
        ] as [$id, $idCessao, $competencia, $valor, $dataVencimento, $dataPagamento, $situacao, $observacao]) {
            DB::table('pagamentos_alugueis')->updateOrInsert(
                ['id' => $id],
                ['id_cessao' => $idCessao, 'competencia' => $competencia, 'valor' => $valor, 'data_vencimento' => $dataVencimento, 'data_pagamento' => $dataPagamento, 'situacao' => $situacao, 'observacao' => $observacao]
            );
        }
    }
}
