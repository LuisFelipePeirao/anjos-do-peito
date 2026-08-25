<?php

use App\Models\Atendimento;
use App\Models\Beneficiaria;
use App\Models\LocalAtendimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function attendanceBeneficiary(array $overrides = []): Beneficiaria
{
    return Beneficiaria::create(array_merge([
        'nome' => 'Maria da Silva',
        'cpf' => '12345678909',
        'email' => 'maria@example.com',
        'telefone' => '(47) 99999-1111',
        'telefone_alternativo' => '',
        'origem_cadastro' => 'busca_espontanea',
        'situacao' => 'ativo',
    ], $overrides));
}

function attendancePayload(array $overrides = []): array
{
    $beneficiaria = $overrides['beneficiaria'] ?? attendanceBeneficiary();
    $professional = $overrides['professionalUser'] ?? User::factory()->enfermeira()->create();
    $local = $overrides['localModel'] ?? LocalAtendimento::create(['nome' => 'Domiciliar']);

    unset($overrides['beneficiaria'], $overrides['professionalUser'], $overrides['localModel']);

    return array_merge([
        'date' => '2026-08-25',
        'time' => '14:30',
        'duration' => '00:45',
        'status' => 'agendado',
        'modality' => 'presencial',
        'location' => $local->id,
        'beneficiary' => $beneficiaria->id,
        'professional' => $professional->id,
        'summary' => 'Orientações sobre amamentação',
        'objective' => 'Avaliar a pega e orientar manejo.',
        'complaint' => 'Dor durante a mamada.',
        'evaluation' => 'Mãe orientada e bebê ativo.',
        'conduct' => 'Manter livre demanda.',
        'notes' => 'Confirmar próximo contato.',
    ], $overrides);
}

it('requires authentication for attendance management', function () {
    $this->get(route('attendances.index'))->assertRedirect(route('login'));
});

it('allows administrators and nurses to access attendance management', function () {
    $this->actingAs(User::factory()->atendente()->create())
        ->get(route('attendances.index'))
        ->assertForbidden();

    $this->actingAs(User::factory()->enfermeira()->create())
        ->get(route('attendances.index'))
        ->assertOk();
});

it('shows participants and hides clinical fields by default for scheduled attendance form', function () {
    $user = User::factory()->administrador()->create();
    attendanceBeneficiary();
    User::factory()->enfermeira()->create();
    LocalAtendimento::create(['nome' => 'Domiciliar']);

    $this->actingAs($user)
        ->get(route('attendances.create'))
        ->assertOk()
        ->assertSee('Participantes')
        ->assertSee('data-attendance-clinical-fields class="space-y-6 hidden"', false);
});

it('creates a scheduled attendance with a registered location and without clinical details', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)
        ->post(route('attendances.store'), attendancePayload())
        ->assertRedirect();

    $this->assertDatabaseHas('atendimentos', [
        'modalidade' => 'presencial',
        'situacao' => 'agendado',
    ]);

    $this->assertDatabaseMissing('atendimento_detalhes', [
        'resumo' => 'Orientações sobre amamentação',
        'queixa' => 'Dor durante a mamada.',
    ]);
});

it('creates an attendance location from the index modal', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)
        ->post(route('attendances.locations.store'), [
            'nome' => 'UBS Centro',
            'descricao' => 'Sala de apoio para atendimentos presenciais.',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('locais_atendimento', [
        'nome' => 'UBS Centro',
        'descricao' => 'Sala de apoio para atendimentos presenciais.',
    ]);
});

it('validates attendance location modal data in a separate error bag', function () {
    $user = User::factory()->administrador()->create();
    LocalAtendimento::create(['nome' => 'Domiciliar']);

    $this->actingAs($user)
        ->from(route('attendances.index'))
        ->post(route('attendances.locations.store'), ['nome' => 'Domiciliar'])
        ->assertRedirect(route('attendances.index'))
        ->assertSessionHasErrors(['nome'], null, 'location');
});

it('updates attendance agenda and detail data', function () {
    $user = User::factory()->administrador()->create();
    $payload = attendancePayload();

    $this->actingAs($user)->post(route('attendances.store'), $payload);

    $atendimento = Atendimento::firstOrFail();

    $this->actingAs($user)
        ->put(route('attendances.update', $atendimento), array_merge($payload, [
            'status' => 'realizado',
            'summary' => 'Consulta de acompanhamento',
            'conduct' => 'Retorno se houver dor persistente.',
        ]))
        ->assertRedirect(route('attendances.show', $atendimento));

    $this->assertDatabaseHas('atendimentos', ['id' => $atendimento->id, 'situacao' => 'realizado']);
    $this->assertDatabaseHas('atendimento_detalhes', ['id_atendimento' => $atendimento->id, 'resumo' => 'Consulta de acompanhamento']);
});

it('does not allow em atendimento status through the attendance form', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)
        ->post(route('attendances.store'), attendancePayload(['status' => 'em_atendimento']))
        ->assertSessionHasErrors('status');
});

it('starts only scheduled attendances', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)->post(route('attendances.store'), attendancePayload());

    $atendimento = Atendimento::firstOrFail();

    $this->actingAs($user)
        ->patch(route('attendances.start', $atendimento))
        ->assertRedirect(route('attendances.show', $atendimento));

    expect($atendimento->fresh()->situacao)->toBe('em_atendimento');

    $this->actingAs($user)
        ->patch(route('attendances.start', $atendimento))
        ->assertStatus(409);
});

it('filters attendances by search status and modality', function () {
    $user = User::factory()->administrador()->create();
    $beneficiaria = attendanceBeneficiary(['nome' => 'Ana Souza', 'cpf' => '98765432100', 'email' => 'ana@example.com']);

    $this->actingAs($user)->post(route('attendances.store'), attendancePayload([
        'beneficiaria' => $beneficiaria,
        'status' => 'realizado',
        'modality' => 'remota',
        'summary' => 'Consulta remota',
    ]));

    $this->actingAs($user)
        ->get(route('attendances.index', ['q' => 'Ana', 'status' => 'realizado', 'modality' => 'remota']))
        ->assertOk()
        ->assertSee('Ana Souza')
        ->assertSee('Realizado')
        ->assertSee('Remota');
});

it('deletes an attendance and its detail', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)->post(route('attendances.store'), attendancePayload());

    $atendimento = Atendimento::firstOrFail();

    $this->actingAs($user)
        ->delete(route('attendances.destroy', $atendimento))
        ->assertRedirect(route('attendances.index'));

    $this->assertDatabaseMissing('atendimentos', ['id' => $atendimento->id]);
    $this->assertDatabaseMissing('atendimento_detalhes', ['id_atendimento' => $atendimento->id]);
});
