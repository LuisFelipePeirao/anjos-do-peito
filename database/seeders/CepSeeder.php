<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CepSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            [101, 89201000, 'Joinville', 'SC', 'Centro', 'Rua das Palmeiras'],
            [102, 89202000, 'Joinville', 'SC', 'Anita Garibaldi', 'Rua Borba Gato'],
            [103, 89203000, 'Joinville', 'SC', 'America', 'Rua Blumenau'],
            [104, 89204000, 'Joinville', 'SC', 'Floresta', 'Rua Sao Paulo'],
            [105, 89205000, 'Joinville', 'SC', 'Costa e Silva', 'Rua Benjamin Constant'],
        ] as [$id, $cep, $cidade, $uf, $bairro, $logradouro]) {
            DB::table('cep')->updateOrInsert(
                ['id' => $id],
                compact('cep', 'cidade', 'uf', 'bairro', 'logradouro') + ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
