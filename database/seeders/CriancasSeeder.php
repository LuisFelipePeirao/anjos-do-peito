<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriancasSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            [101, 'Lucas Costa', '2026-01-12', 'masculino', 101],
            [102, 'Laura Pereira', '2026-02-20', 'feminino', 102],
            [103, 'Miguel Martins', '2025-12-05', 'masculino', 103],
            [104, 'Helena Almeida', '2026-03-14', 'feminino', 104],
            [105, 'Sofia Gomes', '2026-04-02', 'feminino', 105],
        ] as [$id, $nome, $dataNascimento, $sexo, $idBeneficiaria]) {
            DB::table('criancas')->updateOrInsert(
                ['id' => $id],
                ['nome' => $nome, 'data_nascimento' => $dataNascimento, 'sexo' => $sexo, 'id_beneficiaria' => $idBeneficiaria, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
