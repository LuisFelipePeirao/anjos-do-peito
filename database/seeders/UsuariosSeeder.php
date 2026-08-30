<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            [101, 'Ana Souza', 'ana.souza@anjos.test', 'administrador'],
            [102, 'Bruna Lima', 'bruna.lima@anjos.test', 'enfermeira'],
            [103, 'Carla Rocha', 'carla.rocha@anjos.test', 'enfermeira'],
            [104, 'Daniel Alves', 'daniel.alves@anjos.test', 'atendente'],
            [105, 'Elisa Moraes', 'elisa.moraes@anjos.test', 'atendente'],
        ] as [$id, $nome, $email, $perfil]) {
            DB::table('usuarios')->updateOrInsert(
                ['id' => $id],
                ['nome' => $nome, 'email' => $email, 'email_verificado_em' => $now, 'senha' => Hash::make('password'), 'perfil' => $perfil, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
