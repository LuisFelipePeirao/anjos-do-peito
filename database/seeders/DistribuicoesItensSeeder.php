<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistribuicoesItensSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 101, 101, 2, 'Fraldas para primeira semana.'],
            [102, 102, 102, 1, 'Caixa entregue.'],
            [103, 103, 103, 4, 'Potes para ordenha.'],
            [104, 104, 104, 3, 'Roupas separadas.'],
            [105, 105, 105, 2, 'Cartilhas orientativas.'],
        ] as [$id, $idDistribuicao, $idMaterial, $quantidade, $observacao]) {
            DB::table('distribuicoes_itens')->updateOrInsert(
                ['id' => $id],
                ['id_distribuicao' => $idDistribuicao, 'id_material' => $idMaterial, 'quantidade' => $quantidade, 'observacao' => $observacao]
            );
        }
    }
}
