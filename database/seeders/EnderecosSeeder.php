<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnderecosSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            [101, 101, 'Casa 1', '120'],
            [102, 102, 'Apto 202', '45'],
            [103, 103, null, '870'],
            [104, 104, 'Fundos', '33'],
            [105, 105, 'Bloco B', '510'],
        ] as [$id, $idCep, $complemento, $numero]) {
            DB::table('enderecos')->updateOrInsert(
                ['id' => $id],
                ['id_cep' => $idCep, 'complemento' => $complemento, 'numero' => $numero, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
