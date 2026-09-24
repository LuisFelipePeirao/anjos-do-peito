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

it('shows the system logo in the sidebar', function () {
    $user = User::factory()->enfermeira()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('assets/img/logo.png');
});

it('shows the VITA favicon in the browser tab', function () {
    $user = User::factory()->enfermeira()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('assets/img/favicon_VITA.png');
});

it('shows monthly realized attendances without a target', function () {
    $user = User::factory()->enfermeira()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Atendimentos realizados por mês')
        ->assertDontSee('Meta calculada')
        ->assertDontSee('da meta');
});

it('keeps the monthly attendance chart at its content height', function () {
    $user = User::factory()->enfermeira()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee('shadow-[0_14px_35px_rgba(28,25,23,0.05)] self-start', false);
});

it('explains each stock status in the distribution chart', function () {
    $html = view('components.chart.stock-distribution', [
        'title' => 'Estoque',
        'description' => 'Teste',
        'data' => [
            ['label' => 'Adequado', 'available' => 5, 'used' => 1, 'minimum' => 2],
            ['label' => 'Baixo', 'available' => 1, 'used' => 4, 'minimum' => 2],
            ['label' => 'Vazio', 'available' => 0, 'used' => 3, 'minimum' => 1],
        ],
    ])->render();

    expect($html)
        ->toContain('Estoque adequado')
        ->toContain('Baixo estoque')
        ->toContain('Sem estoque')
        ->toContain('Mínimo: 2')
        ->toContain('Disponível')
        ->toContain('Em uso');
});

it('keeps the attendance legend without a latest-month summary card', function () {
    $html = view('components.chart.column-chart', [
        'title' => 'Atendimentos realizados por mês',
        'description' => 'Quantidade de atendimentos realizados nos últimos meses.',
        'data' => [
            'values' => [
                ['month' => 'Ago', 'total' => 7],
                ['month' => 'Set', 'total' => 9],
            ],
        ],
    ])->render();

    expect($html)
        ->toContain('>16</strong>')
        ->toContain('nos últimos 2 meses')
        ->toContain('Atendimentos realizados')
        ->not->toContain('9 realizados')
        ->not->toContain('+2 vs. Ago');
});
