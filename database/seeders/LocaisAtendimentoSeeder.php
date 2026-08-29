<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocaisAtendimentoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            [101, 'Sede Anjos do Peito', 101, 'Sala principal de acolhimento.'],
            [102, 'UBS Centro', 102, 'Atendimento em parceria.'],
            [103, 'UBS Floresta', 103, 'Sala de apoio materno.'],
            [104, 'Domiciliar Norte', 104, 'Visita domiciliar agendada.'],
            [105, 'Domiciliar Sul', 105, 'Visita domiciliar agendada.'],
        ] as [$id, $nome, $idEndereco, $descricao]) {
            DB::table('locais_atendimento')->updateOrInsert(
                ['id' => $id],
                ['nome' => $nome, 'id_endereco' => $idEndereco, 'descricao' => $descricao, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
