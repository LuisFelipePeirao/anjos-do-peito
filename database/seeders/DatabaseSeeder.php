<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::query()->where('perfil', 'administrador')->exists()) {
            return;
        }

        User::factory()->administrador()->create([
            'nome' => env('ADMIN_SEED_NOME', 'Administrador'),
            'email' => env('ADMIN_SEED_EMAIL', 'admin@anjosdopeito.org.br'),
            'senha' => env('ADMIN_SEED_PASSWORD', 'change-me'),
        ]);
    }
}
