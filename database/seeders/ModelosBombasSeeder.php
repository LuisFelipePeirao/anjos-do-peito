<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelosBombasSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 'Medela', 'Swing Flex', 'Bomba eletrica compacta.'],
            [102, 'Philips Avent', 'Comfort', 'Bomba manual com frasco.'],
            [103, 'G-Tech', 'Smart', 'Bomba eletrica bivolt.'],
            [104, 'Lansinoh', 'Signature Pro', 'Bomba dupla eletrica.'],
            [105, 'Nuk', 'Nature Sense', 'Bomba manual leve.'],
        ] as [$id, $fabricante, $modelo, $descricao]) {
            DB::table('modelos_bombas')->updateOrInsert(['id' => $id], compact('fabricante', 'modelo', 'descricao'));
        }
    }
}
