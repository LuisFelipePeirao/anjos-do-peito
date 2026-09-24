<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasAtendimentoSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Puerperas e nutrizes',
            'Gestantes',
            'Bebes',
            'Familia',
        ] as $nome) {
            DB::table('categorias_atendimento')->updateOrInsert(
                ['nome' => $nome],
                ['ativo' => true, 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
