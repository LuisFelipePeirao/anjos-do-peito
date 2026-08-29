<?php

use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\ModeloBomba;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function loanPumpModel(array $overrides = []): ModeloBomba
{
    return ModeloBomba::create(array_merge([
        'fabricante' => 'G-Tech',
        'modelo' => 'Smart',
        'descricao' => 'Bomba elétrica',
    ], $overrides));
}

function loanPump(array $overrides = []): BombaLeite
{
    $model = $overrides['model'] ?? loanPumpModel();
    unset($overrides['model']);

    return BombaLeite::create(array_merge([
        'codigo' => 'BL-100',
        'id_modelo' => $model->id,
        'num_serie' => 'SN-100',
        'situacao' => 'disponivel',
        'data_aquisicao' => '2026-08-01',
        'origem' => 'doacao',
        'acessorios' => 'Frasco e fonte.',
    ], $overrides));
}

function loanBeneficiary(array $overrides = []): Beneficiaria
{
    return Beneficiaria::create(array_merge([
        'nome' => 'Ana Empréstimo',
        'cpf' => '12345678909',
        'email' => 'ana.emprestimo@example.com',
        'telefone' => '(47) 99999-1111',
        'telefone_alternativo' => '',
        'origem_cadastro' => 'busca_espontanea',
        'situacao' => 'ativo',
    ], $overrides));
}

it('requires management profile for loan registration', function () {
    $this->actingAs(User::factory()->atendente()->create())
        ->get(route('pumps.loans.create'))
        ->assertForbidden();
});

it('registers a free pump loan and marks pump as borrowed', function () {
    $user = User::factory()->administrador()->create();
    $pump = loanPump();
    $beneficiary = loanBeneficiary();

    $this->actingAs($user)->get(route('pumps.loans.create'))->assertOk()->assertSee('BL-100 - G-Tech Smart');

    $this->actingAs($user)->post(route('pumps.loans.store'), [
        'contract_type' => 'emprestimo',
        'pump' => $pump->id,
        'beneficiary' => $beneficiary->id,
        'withdrawn_at' => '2026-08-20',
        'expected_return' => '2026-09-20',
        'renewal' => 'none',
        'term_signed' => 1,
        'notes' => 'Orientada sobre higienização.',
    ])->assertRedirect(route('pumps.show', $pump));

    $this->assertDatabaseHas('cessoes_bombas', [
        'id_bomba' => $pump->id,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario_retirada' => $user->id,
        'tipo' => 'gratuita',
        'situacao' => 'ativa',
    ]);
    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'situacao' => 'alugada']);
});

it('registers a rental and creates the first pending payment', function () {
    $user = User::factory()->enfermeira()->create();
    $pump = loanPump(['codigo' => 'BL-200']);
    $beneficiary = loanBeneficiary(['cpf' => '98765432100', 'email' => 'rental@example.com']);

    $this->actingAs($user)->post(route('pumps.loans.store'), [
        'contract_type' => 'Aluguel',
        'pump' => 'BL-200 - G-Tech Smart',
        'beneficiary' => 'Ana Empréstimo',
        'withdrawn_at' => '2026-08-21',
        'expected_return' => '2026-09-21',
        'renewal' => 'A cada 30 dias',
        'monthly_fee' => 'R$ 120,50',
        'due_day' => 10,
        'billing_method' => 'Pix',
        'first_billing_at' => '2026-08-25',
        'billing_notes' => 'Combinação por Pix.',
        'term_signed' => 'Sim',
        'notes' => 'Aluguel social.',
    ])->assertRedirect(route('pumps.show', $pump));

    $this->assertDatabaseHas('cessoes_bombas', [
        'id_bomba' => $pump->id,
        'id_beneficiaria' => $beneficiary->id,
        'tipo' => 'aluguel',
        'valor_mensalidade' => 120.50,
        'situacao' => 'ativa',
    ]);
    $this->assertDatabaseHas('pagamentos_alugueis', [
        'valor' => 120.50,
        'data_vencimento' => '2026-08-25 00:00:00',
        'situacao' => 'pendente',
    ]);
});

it('rejects unavailable pumps for new loans', function () {
    $user = User::factory()->administrador()->create();
    $pump = loanPump(['situacao' => 'manutencao']);
    $beneficiary = loanBeneficiary();

    $this->actingAs($user)->post(route('pumps.loans.store'), [
        'contract_type' => 'emprestimo',
        'pump' => $pump->id,
        'beneficiary' => $beneficiary->id,
        'withdrawn_at' => '2026-08-20',
        'expected_return' => '2026-09-20',
        'term_signed' => 1,
    ])->assertSessionHasErrors('pump');
});
