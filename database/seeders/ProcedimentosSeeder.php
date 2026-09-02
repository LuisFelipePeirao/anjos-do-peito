<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcedimentosSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Laserterapia',
            'Manejo para amamentacao',
            'Massagem / extracao / drenagem linfatica',
            'Puericultura',
            'Palestra',
            'Assistencia social / kit de roupas / outros',
            'Consultoria',
            'Arte gestacional / cha de bencao',
            'Outros: relactacao, retorno ao trabalho, terapia',
            'Doulagem',
        ] as $nome) {
            DB::table('procedimentos')->updateOrInsert(
                ['nome' => $nome],
                ['ativo' => true, 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
