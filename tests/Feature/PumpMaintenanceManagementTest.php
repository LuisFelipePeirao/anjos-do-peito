<?php

use App\Models\BombaLeite;
use App\Models\ManutencaoBomba;
use App\Models\ModeloBomba;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function maintenancePump(array $overrides = []): BombaLeite
{
    $model = ModeloBomba::create([
        'fabricante' => 'Medela',
        'modelo' => 'Swing',
        'descricao' => 'Bomba elétrica',
    ]);

    return BombaLeite::create(array_merge([
        'codigo' => 'BL-MAINT',
        'id_modelo' => $model->id,
        'num_serie' => 'SN-MAINT',
        'situacao' => 'disponivel',
        'data_aquisicao' => '2026-08-20',
        'origem' => 'doacao',
        'acessorios' => 'Frasco e funil.',
    ], $overrides));
}

function validMaintenancePayload(array $overrides = []): array
{
    return array_merge([
        'type' => 'corretiva',
        'started_at' => '2026-09-24T09:30',
        'status' => 'em_andamento',
        'description' => 'Fonte sem energia.',
        'notes' => 'Aguardar peça.',
    ], $overrides);
}

function maintenanceInProgress(): array
{
    $user = User::factory()->administrador()->create();
    $pump = maintenancePump(['codigo' => 'BL-IN-PROGRESS', 'situacao' => 'manutencao']);
    $maintenance = ManutencaoBomba::create([
        'id_bomba' => $pump->id,
        'id_usuario' => $user->id,
        'data_inicio' => '2026-09-24 09:30:00',
        'tipo' => 'corretiva',
        'descricao' => 'Fonte sem energia.',
        'situacao' => 'em_andamento',
        'observacao' => 'Aguardar peça.',
    ]);

    return [$user, $pump, $maintenance];
}

it('opens maintenance only for an available pump', function () {
    $user = User::factory()->administrador()->create();
    $pump = maintenancePump();

    $this->actingAs($user)->post(route('pumps.maintenance.store', $pump), validMaintenancePayload())
        ->assertRedirect(route('pumps.show', ['pump' => $pump, 'tab' => 'maintenance']));

    $this->assertDatabaseHas('manutencoes_bombas', [
        'id_bomba' => $pump->id,
        'id_usuario' => $user->id,
        'tipo' => 'corretiva',
        'situacao' => 'em_andamento',
    ]);
    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'situacao' => 'manutencao']);
});

dataset('unavailablePumpStatuses', ['alugada', 'manutencao', 'baixada']);

it('does not open maintenance for unavailable pumps', function (string $status) {
    $pump = maintenancePump(['codigo' => "BL-$status", 'situacao' => $status]);

    $this->actingAs(User::factory()->administrador()->create())
        ->post(route('pumps.maintenance.store', $pump), validMaintenancePayload())
        ->assertStatus(409);

    $this->assertDatabaseMissing('manutencoes_bombas', ['id_bomba' => $pump->id]);
})->with('unavailablePumpStatuses');

it('finishes maintenance and releases the pump', function () {
    [$user, $pump, $maintenance] = maintenanceInProgress();

    $this->actingAs($user)->patch(route('pumps.maintenance.finish', [$pump, $maintenance]), [
        'finished_at' => '2026-09-24T17:00',
        'notes' => 'Teste final aprovado.',
    ])->assertRedirect(route('pumps.show', ['pump' => $pump, 'tab' => 'maintenance']));

    $this->assertDatabaseHas('manutencoes_bombas', [
        'id' => $maintenance->id,
        'situacao' => 'concluida',
        'data_fim' => '2026-09-24 17:00:00',
        'observacao' => 'Teste final aprovado.',
    ]);
    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'situacao' => 'disponivel']);
});

it('cancels maintenance and releases the pump', function () {
    [$user, $pump, $maintenance] = maintenanceInProgress();

    $this->actingAs($user)->patch(route('pumps.maintenance.cancel', [$pump, $maintenance]), [
        'notes' => 'Peça não necessária.',
    ])->assertRedirect(route('pumps.show', ['pump' => $pump, 'tab' => 'maintenance']));

    $this->assertDatabaseHas('manutencoes_bombas', [
        'id' => $maintenance->id,
        'situacao' => 'cancelada',
        'observacao' => 'Peça não necessária.',
    ]);
    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'situacao' => 'disponivel']);
});

it('rejects a maintenance finish before its start', function () {
    [$user, $pump, $maintenance] = maintenanceInProgress();

    $this->actingAs($user)->patch(route('pumps.maintenance.finish', [$pump, $maintenance]), [
        'finished_at' => $maintenance->data_inicio->copy()->subMinute()->format('Y-m-d\TH:i'),
    ])->assertSessionHasErrors('finished_at');

    $this->assertDatabaseHas('manutencoes_bombas', ['id' => $maintenance->id, 'situacao' => 'em_andamento']);
});

it('does not finish maintenance through another pump url', function () {
    [$user, $pump, $maintenance] = maintenanceInProgress();
    $otherPump = maintenancePump(['codigo' => 'BL-OTHER', 'situacao' => 'disponivel']);

    $this->actingAs($user)->patch(route('pumps.maintenance.finish', [$otherPump, $maintenance]), [
        'finished_at' => '2026-09-24T17:00',
    ])->assertNotFound();

    $this->assertDatabaseHas('manutencoes_bombas', ['id' => $maintenance->id, 'situacao' => 'em_andamento']);
    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'situacao' => 'manutencao']);
});
