<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtendimentosSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            [101, '2026-08-25 09:00:00', '00:45', 'presencial', 101, 'agendado', false, 101, 101, 102],
            [102, '2026-08-25 10:30:00', '01:00', 'presencial', 102, 'realizado', false, 102, 102, 103],
            [103, '2026-08-26 14:00:00', '00:45', 'remota', null, 'realizado', true, 103, 103, null],
            [104, '2026-08-27 15:30:00', '00:30', 'presencial', 103, 'em_atendimento', true, 104, 104, 102],
            [105, '2026-08-28 08:30:00', '01:30', 'presencial', 104, 'cancelado', false, 105, 105, 103],
        ] as [$id, $dataHora, $duracaoPrevista, $modalidade, $idLocal, $situacao, $rascunho, $idBeneficiaria, $idCrianca, $idUsuario]) {
            DB::table('atendimentos')->updateOrInsert(
                ['id' => $id],
                ['data_hora' => $dataHora, 'duracao_prevista' => $duracaoPrevista, 'modalidade' => $modalidade, 'id_local' => $idLocal, 'situacao' => $situacao, 'rascunho' => $rascunho, 'id_beneficiaria' => $idBeneficiaria, 'id_crianca' => $idCrianca, 'id_usuario' => $idUsuario, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
