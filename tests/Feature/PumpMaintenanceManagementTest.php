<?php

use App\Models\BombaLeite;
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
