<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriaisSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 'Fralda RN', 101, 'pacote', 10],
            [102, 'Absorvente para seios', 101, 'caixa', 8],
            [103, 'Pote coletor esteril', 103, 'unidade', 20],
            [104, 'Body infantil', 104, 'unidade', 12],
            [105, 'Cartilha de amamentacao', 105, 'unidade', 30],
        ] as [$id, $nome, $idCategoria, $unidadeMedida, $estoqueMinimo]) {
            DB::table('materiais')->updateOrInsert(
                ['id' => $id],
                ['nome' => $nome, 'id_categoria' => $idCategoria, 'unidade_medida' => $unidadeMedida, 'estoque_minimo' => $estoqueMinimo]
            );
        }
    }
}
