<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistribuicoesSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 101, 101, '2026-08-11 09:30:00', 'entregue', 'Kit entregue na sede.'],
            [102, 102, 102, '2026-08-12 10:00:00', 'entregue', 'Retirada por familiar.'],
            [103, 103, 103, '2026-08-13 15:00:00', 'pendente', 'Separado para visita.'],
            [104, 104, 104, '2026-08-14 16:30:00', 'cancelada', 'Beneficiaria reagendou.'],
            [105, 105, 105, '2026-08-15 11:00:00', 'entregue', 'Entrega domiciliar.'],
        ] as [$id, $idBeneficiaria, $idUsuario, $dataHora, $situacao, $observacao]) {
            DB::table('distribuicoes')->updateOrInsert(
                ['id' => $id],
                ['id_beneficiaria' => $idBeneficiaria, 'id_usuario' => $idUsuario, 'data_hora' => $dataHora, 'situacao' => $situacao, 'observacao' => $observacao]
            );
        }
    }
}
