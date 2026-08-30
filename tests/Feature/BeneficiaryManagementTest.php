<?php

use App\Models\Beneficiaria;
use App\Models\Crianca;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function beneficiaryPayload(array $overrides = []): array
{
    return array_merge([
        'nome' => 'Maria da Silva',
        'cpf' => '123.456.789-09',
        'email' => 'maria@example.com',
        'telefone' => '(47) 99999-1111',
        'telefone_alternativo' => '(47) 98888-2222',
        'origem_cadastro' => 'busca_espontanea',
    ], $overrides);
}

it('requires authentication for beneficiary management', function () {
    $this->get(route('beneficiaries.index'))->assertRedirect(route('login'));
});

it('creates an active beneficiary with an address', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('beneficiaries.store'), beneficiaryPayload([
        'cep' => '88000-000',
        'logradouro' => 'Rua das Flores',
        'bairro' => 'Centro',
        'cidade' => 'Florianópolis',
        'uf' => 'SC',
        'numero' => '42',
    ]))->assertRedirect(route('beneficiaries.index'));

    $this->assertDatabaseHas('beneficiarias', ['cpf' => '12345678909', 'situacao' => 'ativo']);
    $this->assertDatabaseHas('cep', ['cidade' => 'Florianópolis', 'uf' => 'SC']);
    $this->assertDatabaseHas('enderecos', ['numero' => '42']);
});

it('rejects a duplicate cpf', function () {
    $user = User::factory()->create();
    Beneficiaria::create([...beneficiaryPayload(), 'cpf' => '12345678909', 'situacao' => 'ativo']);

    $this->actingAs($user)->post(route('beneficiaries.store'), beneficiaryPayload())
        ->assertSessionHasErrors('cpf');
});

it('allows an empty alternate phone number', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('beneficiaries.store'), beneficiaryPayload([
        'telefone_alternativo' => '',
    ]))->assertRedirect(route('beneficiaries.index'));

    $this->assertDatabaseHas('beneficiarias', ['cpf' => '12345678909', 'telefone_alternativo' => '']);
});

it('filters beneficiaries by status and search', function () {
    $user = User::factory()->create();
    Beneficiaria::create([...beneficiaryPayload(), 'cpf' => '12345678909', 'situacao' => 'ativo']);
    Beneficiaria::create([...beneficiaryPayload(['nome' => 'Ana Souza', 'email' => 'ana@example.com']), 'cpf' => '98765432100', 'situacao' => 'inativo']);

    $this->actingAs($user)->get(route('beneficiaries.index', ['q' => 'Ana', 'status' => 'inactive']))
        ->assertOk()
        ->assertSee('Ana Souza')
        ->assertDontSee('Maria da Silva');
});

it('inactivates a beneficiary from the profile action', function () {
    $user = User::factory()->create();
    $beneficiaria = Beneficiaria::create([...beneficiaryPayload(), 'cpf' => '12345678909', 'situacao' => 'ativo']);

    $this->actingAs($user)->patch(route('beneficiaries.deactivate', $beneficiaria))
        ->assertRedirect(route('beneficiaries.show', $beneficiaria));

    expect($beneficiaria->fresh()->situacao)->toBe('inativo');
});

it('manages children only within their beneficiary profile', function () {
    $user = User::factory()->create();
    $beneficiaria = Beneficiaria::create([...beneficiaryPayload(), 'cpf' => '12345678909', 'situacao' => 'ativo']);

    $this->actingAs($user)->post(route('beneficiaries.children.store', $beneficiaria), [
        'nome' => 'Lucas da Silva', 'data_nascimento' => '2026-01-15', 'sexo' => 'masculino',
    ])->assertRedirect(route('beneficiaries.show', $beneficiaria));

    $crianca = Crianca::firstOrFail();
    $this->actingAs($user)->put(route('beneficiaries.children.update', [$beneficiaria, $crianca]), [
        'nome' => 'Lucas Silva', 'data_nascimento' => '2026-01-15', 'sexo' => 'masculino',
    ])->assertRedirect(route('beneficiaries.show', $beneficiaria));

    $this->assertDatabaseHas('criancas', ['nome' => 'Lucas Silva', 'id_beneficiaria' => $beneficiaria->id]);
});
