<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstoqueMovimentacoesSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 101, 'entrada', 30, '2026-08-01 09:10:00', 101, 101, null, 'Entrada por doacao.'],
            [102, 102, 'entrada', 15, '2026-08-03 10:20:00', 102, 102, null, 'Entrada por doacao.'],
            [103, 103, 'saida', 4, '2026-08-13 15:10:00', 103, null, 103, 'Saida por distribuicao.'],
            [104, 104, 'saida', 3, '2026-08-14 16:40:00', 104, null, 104, 'Saida cancelada para conferencia.'],
            [105, 105, 'ajuste', 10, '2026-08-16 08:00:00', 105, null, null, 'Ajuste apos inventario.'],
        ] as [$id, $idMaterial, $tipo, $quantidade, $dataHora, $idUsuario, $idDoacaoItem, $idDistribuicaoItem, $observacao]) {
            DB::table('estoque_movimentacoes')->updateOrInsert(
                ['id' => $id],
                ['id_material' => $idMaterial, 'tipo' => $tipo, 'quantidade' => $quantidade, 'data_hora' => $dataHora, 'id_usuario' => $idUsuario, 'id_doacao_item' => $idDoacaoItem, 'id_distribuicao_item' => $idDistribuicaoItem, 'observacao' => $observacao]
            );
        }
    }
}
