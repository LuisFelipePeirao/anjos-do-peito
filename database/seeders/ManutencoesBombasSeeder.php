<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManutencoesBombasSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 101, 102, '2026-07-01 08:00:00', '2026-07-02 17:00:00', 'higienizacao', 'Higienizacao completa antes da cessao.', 'concluida', 'Liberada para uso.'],
            [102, 102, 103, '2026-07-05 09:00:00', '2026-07-05 12:00:00', 'preventiva', 'Revisao periodica.', 'concluida', 'Sem avarias.'],
            [103, 103, 102, '2026-08-10 10:00:00', null, 'corretiva', 'Verificar fonte de energia.', 'em_andamento', 'Aguardando peca.'],
            [104, 104, 103, '2026-08-15 13:00:00', null, 'preventiva', 'Conferencia pos-retirada.', 'aberta', 'Agendada.'],
            [105, 105, 102, '2026-06-21 09:00:00', '2026-06-22 16:00:00', 'corretiva', 'Equipamento sem pressao.', 'cancelada', 'Bomba baixada do estoque.'],
        ] as [$id, $idBomba, $idUsuario, $dataInicio, $dataFim, $tipo, $descricao, $situacao, $observacao]) {
            DB::table('manutencoes_bombas')->updateOrInsert(
                ['id' => $id],
                ['id_bomba' => $idBomba, 'id_usuario' => $idUsuario, 'data_inicio' => $dataInicio, 'data_fim' => $dataFim, 'tipo' => $tipo, 'descricao' => $descricao, 'situacao' => $situacao, 'observacao' => $observacao]
            );
        }
    }
}
