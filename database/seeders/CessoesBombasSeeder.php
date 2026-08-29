<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CessoesBombasSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [101, 101, 101, 102, null, 'aluguel', 45.00, '2026-08-01 09:00:00', '2026-09-01', null, 'ativa', 'Retirada com termo assinado.', null],
            [102, 102, 102, 103, 104, 'gratuita', null, '2026-07-10 10:30:00', '2026-08-10', '2026-08-09 15:00:00', 'finalizada', 'Kit conferido.', 'Devolucao em bom estado.'],
            [103, 103, 103, 102, null, 'gratuita', null, '2026-08-05 14:00:00', '2026-08-25', null, 'atrasada', 'Orientada sobre higienizacao.', null],
            [104, 104, 104, 103, null, 'aluguel', 55.00, '2026-08-12 16:00:00', '2026-09-12', null, 'ativa', 'Acessorios completos.', null],
            [105, 105, 105, 102, 103, 'gratuita', null, '2026-06-01 11:00:00', '2026-07-01', '2026-06-20 09:00:00', 'cancelada', 'Cancelada por troca de equipamento.', 'Bomba baixada.'],
        ] as [$id, $idBomba, $idBeneficiaria, $idUsuarioRetirada, $idUsuarioDevolucao, $tipo, $valorMensalidade, $dataRetirada, $dataPrevistaDevolucao, $dataDevolucao, $situacao, $observacaoRetirada, $observacaoDevolucao]) {
            DB::table('cessoes_bombas')->updateOrInsert(
                ['id' => $id],
                ['id_bomba' => $idBomba, 'id_beneficiaria' => $idBeneficiaria, 'id_usuario_retirada' => $idUsuarioRetirada, 'id_usuario_devolucao' => $idUsuarioDevolucao, 'tipo' => $tipo, 'valor_mensalidade' => $valorMensalidade, 'data_retirada' => $dataRetirada, 'data_prevista_devolucao' => $dataPrevistaDevolucao, 'data_devolucao' => $dataDevolucao, 'situacao' => $situacao, 'observacao_retirada' => $observacaoRetirada, 'observacao_devolucao' => $observacaoDevolucao]
            );
        }
    }
}
