<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasMateriaisSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 'Higiene', true],
            [102, 'Alimentacao', true],
            [103, 'Ordenha', true],
            [104, 'Vestuario', true],
            [105, 'Educativo', true],
        ] as [$id, $nome, $ativo]) {
            DB::table('categorias_materiais')->updateOrInsert(['id' => $id], compact('nome', 'ativo'));
        }
    }
}
