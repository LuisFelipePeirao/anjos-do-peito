<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BombaLeiteSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 'BL-001', 101, 'SN-2026-001', 'alugada', '2026-01-10', 'doacao', 101, 'Frasco, funil M, fonte.'],
            [102, 'BL-002', 102, 'SN-2026-002', 'disponivel', '2026-02-15', 'compra', null, 'Frasco e funil.'],
            [103, 'BL-003', 103, 'SN-2026-003', 'manutencao', '2026-03-20', 'doacao', 102, 'Fonte com mau contato.'],
            [104, 'BL-004', 104, 'SN-2026-004', 'alugada', '2026-04-25', 'emprestimo', 103, 'Kit duplo completo.'],
            [105, 'BL-005', 105, 'SN-2026-005', 'baixada', '2026-05-30', 'doacao', 104, 'Sem acessorios.'],
        ] as [$id, $codigo, $idModelo, $numSerie, $situacao, $dataAquisicao, $origem, $idDoador, $acessorios]) {
            DB::table('bomba_leite')->updateOrInsert(
                ['id' => $id],
                ['codigo' => $codigo, 'id_modelo' => $idModelo, 'num_serie' => $numSerie, 'situacao' => $situacao, 'data_aquisicao' => $dataAquisicao, 'origem' => $origem, 'id_doador' => $idDoador, 'acessorios' => $acessorios]
            );
        }
    }
}
