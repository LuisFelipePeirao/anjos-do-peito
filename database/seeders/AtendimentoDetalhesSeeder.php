<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtendimentoDetalhesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            [101, 101, 'Orientacao inicial', 'Avaliar amamentacao', 'Dor ao amamentar', 'Pega ajustada', 'Retorno em 7 dias', 'Sem intercorrencias.'],
            [102, 102, 'Consulta completa', 'Acompanhar ganho de peso', 'Baixa producao percebida', 'Producao adequada', 'Livre demanda', 'Familia orientada.'],
            [103, 103, 'Rascunho retroativo', 'Registrar evolucao', 'Fissura mamilar', 'Em avaliacao', 'Orientar ordenha', 'Completar dados depois.'],
            [104, 104, 'Atendimento em curso', 'Manter acompanhamento', 'Ingurgitamento', 'Massagem orientada', 'Compressas frias', 'Revisar no retorno.'],
            [105, 105, 'Atendimento cancelado', 'Reagendar suporte', 'Nao compareceu', 'Sem avaliacao', 'Contato telefonico', 'Aguardando retorno.'],
        ] as [$id, $idAtendimento, $resumo, $objetivo, $queixa, $avaliacao, $conduta, $observacao]) {
            DB::table('atendimento_detalhes')->updateOrInsert(
                ['id' => $id],
                ['id_atendimento' => $idAtendimento, 'resumo' => $resumo, 'objetivo' => $objetivo, 'queixa' => $queixa, 'avaliacao' => $avaliacao, 'conduta' => $conduta, 'observacao' => $observacao, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
