<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoacoesItensSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 101, 101, 30, 'Pacotes lacrados.'],
            [102, 102, 102, 15, 'Caixas completas.'],
            [103, 103, 103, 50, 'Material esteril.'],
            [104, 104, 104, 20, 'Tamanhos variados.'],
            [105, 105, 105, 100, 'Impressao nova.'],
        ] as [$id, $idDoacao, $idMaterial, $quantidade, $observacao]) {
            DB::table('doacoes_itens')->updateOrInsert(
                ['id' => $id],
                ['id_doacao' => $idDoacao, 'id_material' => $idMaterial, 'quantidade' => $quantidade, 'observacao' => $observacao]
            );
        }
    }
}
