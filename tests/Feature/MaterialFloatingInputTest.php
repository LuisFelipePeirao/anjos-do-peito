<?php

use App\Models\Beneficiaria;
use App\Models\LocalAtendimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('keeps date labels floated without relying on placeholder state', function () {
    $administrator = User::factory()->administrador()->create();
    User::factory()->enfermeira()->create();
    Beneficiaria::create([
        'nome' => 'Maria da Silva',
        'cpf' => '12345678909',
        'email' => 'maria@example.com',
        'telefone' => '(47) 99999-1111',
        'telefone_alternativo' => '',
        'origem_cadastro' => 'busca_espontanea',
        'situacao' => 'ativo',
    ]);
    LocalAtendimento::create(['nome' => 'Domiciliar']);

    $content = $this->actingAs($administrator)
        ->get(route('attendances.create'))
        ->assertOk()
        ->getContent();

    expect($content)->toMatch('/<input[^>]*type="date"[^>]*name="date"[^>]*>\s*<label[^>]*class="[^"]*\s-top-2\\.5\s[^"]*"/s');
});
