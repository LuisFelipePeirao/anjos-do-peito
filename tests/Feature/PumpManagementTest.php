<?php

use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\CessaoBomba;
use App\Models\ModeloBomba;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function pumpModel(array $overrides = []): ModeloBomba
{
    return ModeloBomba::create(array_merge([
        'fabricante' => 'Medela',
        'modelo' => 'Swing',
        'descricao' => 'Bomba elétrica',
    ], $overrides));
}

function pumpPayload(array $overrides = []): array
{
    $model = $overrides['model'] ?? pumpModel();
    unset($overrides['model']);

    return array_merge([
        'codigo' => 'BL-900',
        'id_modelo' => $model->id,
        'num_serie' => 'SN-900',
        'situacao' => 'disponivel',
        'data_aquisicao' => '2026-08-20',
        'origem' => 'doacao',
        'id_doador' => null,
        'acessorios' => 'Frasco, funil e fonte.',
    ], $overrides);
}

function pumpBeneficiary(array $overrides = []): Beneficiaria
{
    return Beneficiaria::create(array_merge([
        'nome' => 'Maria da Bomba',
        'cpf' => '12345678909',
        'email' => 'maria.bomba@example.com',
        'telefone' => '(47) 99999-1111',
        'telefone_alternativo' => '',
        'origem_cadastro' => 'busca_espontanea',
        'situacao' => 'ativo',
    ], $overrides));
}

it('requires management profile for pump mutations', function () {
    $model = pumpModel();
    $pump = BombaLeite::create(pumpPayload(['model' => $model]));

    $this->actingAs(User::factory()->atendente()->create())->get(route('pumps.create'))->assertForbidden();
    $this->actingAs(User::factory()->atendente()->create())->post(route('pumps.store'), pumpPayload(['codigo' => 'BL-901', 'model' => $model]))->assertForbidden();
    $this->actingAs(User::factory()->atendente()->create())->get(route('pumps.edit', $pump))->assertForbidden();
});

it('creates lists shows and updates milk pumps using database records', function () {
    $user = User::factory()->administrador()->create();
    $model = pumpModel();

    $this->actingAs($user)->get(route('pumps.create'))->assertOk()->assertSee('Nova bomba de leite');
    $this->actingAs($user)->post(route('pumps.store'), pumpPayload(['model' => $model]))->assertRedirect();

    $pump = BombaLeite::where('codigo', 'BL-900')->firstOrFail();
    $this->assertDatabaseHas('bomba_leite', ['codigo' => 'BL-900', 'situacao' => 'disponivel']);

    $this->actingAs($user)->get(route('pumps.index'))->assertOk()->assertSee('BL-900')->assertSee('Medela Swing');
    $this->actingAs($user)->get(route('pumps.show', $pump))->assertOk()->assertSee('BL-900')->assertSee('Frasco, funil e fonte.');

    $this->actingAs($user)->put(route('pumps.update', $pump), pumpPayload([
        'codigo' => 'BL-901',
        'model' => $model,
        'situacao' => 'manutencao',
    ]))->assertRedirect(route('pumps.show', $pump));

    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'codigo' => 'BL-901', 'situacao' => 'manutencao']);
});

it('accepts pump form labels submitted by material selects', function () {
    $user = User::factory()->administrador()->create();
    pumpModel(['fabricante' => 'G-Tech', 'modelo' => 'Smart']);

    $this->actingAs($user)->post(route('pumps.store'), [
        ...pumpPayload(['codigo' => 'BL-902']),
        'id_modelo' => 'G-Tech Smart',
        'situacao' => 'Disponível',
        'origem' => 'Doação',
        'id_doador' => 'Sem doador vinculado',
    ])->assertRedirect();

    $this->assertDatabaseHas('bomba_leite', ['codigo' => 'BL-902', 'situacao' => 'disponivel', 'origem' => 'doacao']);
});

it('filters overdue pumps and inactivates pumps with linked history on delete', function () {
    $user = User::factory()->administrador()->create();
    $model = pumpModel();
    $beneficiary = pumpBeneficiary();
    $pump = BombaLeite::create(pumpPayload(['model' => $model, 'situacao' => 'alugada']));

    CessaoBomba::create([
        'id_bomba' => $pump->id,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario_retirada' => $user->id,
        'tipo' => 'gratuita',
        'data_retirada' => now()->subDays(20),
        'data_prevista_devolucao' => now()->subDay()->toDateString(),
        'situacao' => 'ativa',
    ]);

    $this->actingAs($user)->get(route('pumps.index', ['status' => 'overdue']))->assertOk()->assertSee('Em atraso')->assertSee('Maria da Bomba');
    $this->actingAs($user)->delete(route('pumps.destroy', $pump))->assertRedirect(route('pumps.index'));

    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'situacao' => 'baixada']);
});

it('deletes pumps without linked history', function () {
    $user = User::factory()->administrador()->create();
    $model = pumpModel();
    $pump = BombaLeite::create(pumpPayload(['model' => $model]));

    $this->actingAs($user)->delete(route('pumps.destroy', $pump))->assertRedirect(route('pumps.index'));

    $this->assertDatabaseMissing('bomba_leite', ['id' => $pump->id]);
});

it('shows renewal only for borrowed pumps and renews the current loan', function () {
    $user = User::factory()->administrador()->create();
    $model = pumpModel();
    $beneficiary = pumpBeneficiary();
    $availablePump = BombaLeite::create(pumpPayload(['model' => $model, 'codigo' => 'BL-AVAILABLE']));
    $borrowedPump = BombaLeite::create(pumpPayload(['model' => $model, 'codigo' => 'BL-BORROWED', 'situacao' => 'alugada']));

    CessaoBomba::create([
        'id_bomba' => $borrowedPump->id,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario_retirada' => $user->id,
        'tipo' => 'gratuita',
        'data_retirada' => now()->subDays(5),
        'data_prevista_devolucao' => now()->addDays(5)->toDateString(),
        'situacao' => 'ativa',
    ]);

    $this->actingAs($user)->get(route('pumps.show', $availablePump))->assertOk()->assertDontSee('Renovar empréstimo');
    $this->actingAs($user)->get(route('pumps.show', $borrowedPump))->assertOk()->assertSee('Renovar empréstimo');

    $this->actingAs($user)
        ->patch(route('pumps.loans.renew', $borrowedPump), ['expires_at' => now()->addDays(20)->toDateString()])
        ->assertRedirect(route('pumps.show', $borrowedPump));

    $this->assertDatabaseHas('cessoes_bombas', [
        'id_bomba' => $borrowedPump->id,
        'data_prevista_devolucao' => now()->addDays(20)->toDateString().' 00:00:00',
        'situacao' => 'ativa',
    ]);
});

it('warns before renewing overdue loans and normalizes their status', function () {
    $user = User::factory()->administrador()->create();
    $model = pumpModel();
    $beneficiary = pumpBeneficiary();
    $pump = BombaLeite::create(pumpPayload(['model' => $model, 'codigo' => 'BL-LATE', 'situacao' => 'alugada']));

    CessaoBomba::create([
        'id_bomba' => $pump->id,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario_retirada' => $user->id,
        'tipo' => 'gratuita',
        'data_retirada' => now()->subDays(40),
        'data_prevista_devolucao' => now()->subDay()->toDateString(),
        'situacao' => 'atrasada',
    ]);

    $this->actingAs($user)
        ->get(route('pumps.show', $pump))
        ->assertOk()
        ->assertSee('Este empréstimo está atrasado');

    $this->actingAs($user)
        ->patch(route('pumps.loans.renew', $pump), ['expires_at' => now()->addMonth()->toDateString()])
        ->assertRedirect(route('pumps.show', $pump));

    $this->assertDatabaseHas('cessoes_bombas', [
        'id_bomba' => $pump->id,
        'data_prevista_devolucao' => now()->addMonth()->toDateString().' 00:00:00',
        'situacao' => 'ativa',
    ]);
});
