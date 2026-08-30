<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoacoesSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 101, 101, '2026-08-01 09:00:00', 'Entrada mensal de campanha.', 'recebida'],
            [102, 102, 102, '2026-08-03 10:15:00', 'Entrega na sede.', 'recebida'],
            [103, 103, 103, '2026-08-05 14:30:00', 'Itens conferidos.', 'recebida'],
            [104, 104, 104, '2026-08-07 16:00:00', 'Campanha comunitaria.', 'recebida'],
            [105, 105, 105, '2026-08-09 11:45:00', 'Registro cancelado por duplicidade.', 'cancelada'],
        ] as [$id, $idDoador, $idUsuario, $dataDoacao, $observacao, $situacao]) {
            DB::table('doacoes')->updateOrInsert(
                ['id' => $id],
                ['id_doador' => $idDoador, 'id_usuario' => $idUsuario, 'data_doacao' => $dataDoacao, 'observacao' => $observacao, 'situacao' => $situacao]
            );
        }
    }
}
