<?php

use App\Models\Atendimento;
use App\Models\Beneficiaria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('builds the home dashboard from database records', function () {
    $user = User::factory()->administrador()->create();
    $beneficiaria = Beneficiaria::create([
        'nome' => 'Maria Real',
        'cpf' => '12345678909',
        'email' => 'maria.real@example.com',
        'telefone' => '(47) 99999-1111',
        'telefone_alternativo' => '',
        'situacao' => 'ativo',
        'origem_cadastro' => 'busca_espontanea',
    ]);

    Atendimento::create([
        'data_hora' => now()->setTime(9, 30),
        'modalidade' => 'presencial',
        'situacao' => 'realizado',
        'rascunho' => false,
        'id_beneficiaria' => $beneficiaria->id,
        'id_usuario' => $user->id,
    ]);

    DB::table('categorias_materiais')->insert(['id' => 501, 'nome' => 'Fraldas', 'ativo' => true]);
    DB::table('materiais')->insert(['id' => 501, 'nome' => 'Fralda P', 'id_categoria' => 501, 'unidade_medida' => 'pacote', 'estoque_minimo' => 2]);
    DB::table('estoque_movimentacoes')->insert([
        'id_material' => 501,
        'tipo' => 'entrada',
        'quantidade' => 5,
        'data_hora' => now()->setTime(10, 15),
        'id_usuario' => $user->id,
    ]);

    DB::table('modelos_bombas')->insert(['id' => 501, 'fabricante' => 'Teste', 'modelo' => 'Modelo Real']);
    DB::table('bomba_leite')->insert([
        'id' => 501,
        'codigo' => 'BL-REAL',
        'id_modelo' => 501,
        'situacao' => 'disponivel',
        'origem' => 'doacao',
    ]);

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Beneficiárias ativas')
        ->assertSee('1 novos cadastros no mês')
        ->assertSee('Atendimento registrado para Maria Real.')
        ->assertSee('Entrada de 5 pacote de Fralda P.');
});

it('shows the authenticated user in the top navbar', function () {
    $user = User::factory()->enfermeira()->create([
        'nome' => 'Carla Navbar',
        'email' => 'carla.navbar@example.com',
    ]);

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Carla Navbar')
        ->assertSee('Enfermeira')
        ->assertDontSee('Luzilene Zimmerman');
});
