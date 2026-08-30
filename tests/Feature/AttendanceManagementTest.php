<?php

use App\Models\Atendimento;
use App\Models\Beneficiaria;
use App\Models\Crianca;
use App\Models\LocalAtendimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function attendanceBeneficiary(array $overrides = []): Beneficiaria
{
    return Beneficiaria::create(array_merge(['nome' => 'Maria da Silva', 'cpf' => '12345678909', 'email' => 'maria@example.com', 'telefone' => '(47) 99999-1111', 'telefone_alternativo' => '', 'origem_cadastro' => 'busca_espontanea', 'situacao' => 'ativo'], $overrides));
}

function attendancePayload(array $overrides = []): array
{
    $beneficiaria = $overrides['beneficiaria'] ?? attendanceBeneficiary();
    $professional = $overrides['professionalUser'] ?? User::factory()->enfermeira()->create();
    $local = $overrides['localModel'] ?? LocalAtendimento::create(['nome' => 'Domiciliar']);
    unset($overrides['beneficiaria'], $overrides['professionalUser'], $overrides['localModel']);

    return array_merge([
        'save_as' => 'final', 'confirmed_finalization' => 1, 'date' => '2026-08-25', 'time' => '14:30', 'duration' => '00:45', 'status' => 'agendado',
        'modality' => 'presencial', 'location' => $local->id, 'beneficiary' => $beneficiaria->id, 'child' => null,
        'professional' => $professional->id, 'summary' => 'Orientações sobre amamentação', 'objective' => 'Avaliar a pega e orientar manejo.',
        'complaint' => 'Dor durante a mamada.', 'evaluation' => 'Mãe orientada e bebê ativo.', 'conduct' => 'Manter livre demanda.', 'notes' => 'Confirmar próximo contato.',
    ], $overrides);
}

it('requires authentication and limits attendance access to administrators and nurses', function () {
    $this->get(route('attendances.index'))->assertRedirect(route('login'));
    $this->actingAs(User::factory()->atendente()->create())->get(route('attendances.index'))->assertForbidden();
    $this->actingAs(User::factory()->enfermeira()->create())->get(route('attendances.index'))->assertOk();
});

it('shows a scheduled form with clinical fields hidden and draft action', function () {
    $user = User::factory()->administrador()->create();
    attendanceBeneficiary();
    User::factory()->enfermeira()->create();
    LocalAtendimento::create(['nome' => 'Domiciliar']);

    $this->actingAs($user)->get(route('attendances.create'))
        ->assertOk()->assertSee('data-attendance-clinical-fields class="space-y-6 hidden"', false)
        ->assertSee('Salvar rascunho')->assertSee('attendance-finalize-confirmation');
});

it('creates a final scheduled attendance without persisting clinical details', function () {
    $user = User::factory()->administrador()->create();
    $this->actingAs($user)->post(route('attendances.store'), attendancePayload())->assertRedirect();

    $this->assertDatabaseHas('atendimentos', ['situacao' => 'agendado', 'rascunho' => false]);
    $this->assertDatabaseMissing('atendimento_detalhes', ['resumo' => 'Orientações sobre amamentação']);
});

it('creates an incomplete draft requiring only beneficiary and status', function () {
    $user = User::factory()->administrador()->create();
    $beneficiaria = attendanceBeneficiary();

    $this->actingAs($user)->post(route('attendances.store'), ['save_as' => 'draft', 'status' => 'realizado', 'beneficiary' => $beneficiaria->id])->assertRedirect();

    $this->assertDatabaseHas('atendimentos', ['situacao' => 'realizado', 'rascunho' => true, 'id_beneficiaria' => $beneficiaria->id, 'id_usuario' => null]);
});

it('requires all clinical data when finalizing a retroactive attendance', function () {
    $user = User::factory()->administrador()->create();
    $payload = attendancePayload(['status' => 'realizado', 'summary' => '', 'objective' => '', 'complaint' => '', 'evaluation' => '', 'conduct' => '']);

    $this->actingAs($user)->post(route('attendances.store'), $payload)
        ->assertSessionHasErrors(['summary', 'objective', 'complaint', 'evaluation', 'conduct']);
});

it('requires confirmation before finalizing a realized attendance', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)->post(route('attendances.store'), attendancePayload(['status' => 'realizado', 'confirmed_finalization' => 0]))
        ->assertSessionHasErrors('status');
});

it('locks final realized attendances in the interface and backend', function () {
    $user = User::factory()->administrador()->create();
    $payload = attendancePayload(['status' => 'realizado']);
    $this->actingAs($user)->post(route('attendances.store'), $payload);
    $attendance = Atendimento::firstOrFail();

    $this->actingAs($user)->get(route('attendances.show', $attendance))->assertOk()->assertDontSee('>Editar<', false);
    $this->actingAs($user)->get(route('attendances.edit', $attendance))->assertForbidden();
    $this->actingAs($user)->put(route('attendances.update', $attendance), array_merge($payload, ['status' => 'realizado']))->assertForbidden();
});

it('allows a realized draft to be completed and then locks it', function () {
    $user = User::factory()->administrador()->create();
    $beneficiaria = attendanceBeneficiary();
    $this->actingAs($user)->post(route('attendances.store'), ['save_as' => 'draft', 'status' => 'realizado', 'beneficiary' => $beneficiaria->id]);
    $attendance = Atendimento::firstOrFail();

    $this->actingAs($user)->put(route('attendances.update', $attendance), attendancePayload(['beneficiaria' => $beneficiaria, 'status' => 'realizado', 'save_as' => 'final']))->assertRedirect(route('attendances.show', $attendance));
    expect($attendance->fresh()->rascunho)->toBeFalse();
    $this->actingAs($user)->put(route('attendances.update', $attendance), attendancePayload(['beneficiaria' => $beneficiaria, 'status' => 'realizado']))->assertForbidden();
});

it('returns only the selected beneficiary children and validates the child ownership', function () {
    $user = User::factory()->administrador()->create();
    $beneficiaria = attendanceBeneficiary();
    $other = attendanceBeneficiary(['nome' => 'Outra', 'cpf' => '98765432100', 'email' => 'outra@example.com']);
    $child = Crianca::create(['nome' => 'João', 'data_nascimento' => '2025-01-01', 'sexo' => 'masculino', 'id_beneficiaria' => $beneficiaria->id]);
    $otherChild = Crianca::create(['nome' => 'Ana', 'data_nascimento' => '2024-01-01', 'sexo' => 'feminino', 'id_beneficiaria' => $other->id]);

    $this->actingAs($user)->get(route('attendances.children.index', $beneficiaria))->assertOk()->assertJsonFragment(['value' => $child->id, 'label' => 'João'])->assertJsonMissing(['value' => $otherChild->id]);
    $this->actingAs($user)->post(route('attendances.store'), attendancePayload(['beneficiaria' => $beneficiaria, 'child' => $otherChild->id]))->assertSessionHasErrors('child');
    $this->actingAs($user)->post(route('attendances.store'), attendancePayload(['beneficiaria' => $beneficiaria, 'child' => $child->id]))->assertSessionHasNoErrors();
    $this->assertDatabaseHas('atendimentos', ['id_crianca' => $child->id]);
});

it('starts an attendance and saves or finalizes its clinical continuation', function () {
    $user = User::factory()->administrador()->create();
    $this->actingAs($user)->post(route('attendances.store'), attendancePayload());
    $attendance = Atendimento::firstOrFail();

    $this->actingAs($user)->patch(route('attendances.start', $attendance))->assertRedirect(route('attendances.continue', $attendance));
    expect($attendance->fresh()->situacao)->toBe('em_atendimento');
    $this->actingAs($user)->get(route('attendances.continue', $attendance))->assertOk()->assertSee('Informações do atendimento')->assertSee('Registro clínico');

    $this->actingAs($user)->put(route('attendances.continue.save', $attendance), ['save_as' => 'draft', 'summary' => 'Registro parcial'])->assertRedirect(route('attendances.show', $attendance));
    expect($attendance->fresh()->situacao)->toBe('em_atendimento')->and($attendance->fresh()->rascunho)->toBeTrue();

    $this->actingAs($user)->put(route('attendances.continue.save', $attendance), ['save_as' => 'final', 'confirmed_finalization' => 1, 'summary' => 'Registro completo', 'objective' => 'Objetivo', 'complaint' => 'Queixa', 'evaluation' => 'Avaliação', 'conduct' => 'Conduta'])->assertRedirect(route('attendances.show', $attendance));
    expect($attendance->fresh()->situacao)->toBe('realizado')->and($attendance->fresh()->rascunho)->toBeFalse();
});

it('prevents invalid manual statuses and keeps location creation separate', function () {
    $user = User::factory()->administrador()->create();
    $payload = attendancePayload();
    $this->actingAs($user)->post(route('attendances.store'), array_merge($payload, ['status' => 'em_atendimento']))->assertSessionHasErrors('status');
    $this->actingAs($user)->post(route('attendances.store'), array_merge($payload, ['status' => 'cancelado']))->assertSessionHasErrors('status');
    $this->actingAs($user)->post(route('attendances.locations.store'), ['nome' => 'UBS Centro', 'descricao' => 'Sala de apoio'])->assertRedirect();
    $this->assertDatabaseHas('locais_atendimento', ['nome' => 'UBS Centro']);
});
