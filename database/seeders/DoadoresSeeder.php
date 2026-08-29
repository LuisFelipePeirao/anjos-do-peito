<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoadoresSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 'Instituto Vida', '(47) 3300-1001', 'contato@institutovida.test', 'Doador recorrente.'],
            [102, 'Claudia Ribeiro', '(47) 3300-1002', 'claudia@example.test', 'Doacao de materiais.'],
            [103, 'Farmacia Popular', '(47) 3300-1003', 'farmacia@example.test', 'Parceiro local.'],
            [104, 'Grupo Materno Livre', '(47) 3300-1004', 'grupo@example.test', 'Campanha trimestral.'],
            [105, 'Rafael Mendes', '(47) 3300-1005', 'rafael@example.test', 'Doacao eventual.'],
        ] as [$id, $nome, $telefone, $email, $observacao]) {
            DB::table('doadores')->updateOrInsert(['id' => $id], compact('nome', 'telefone', 'email', 'observacao'));
        }
    }
}
