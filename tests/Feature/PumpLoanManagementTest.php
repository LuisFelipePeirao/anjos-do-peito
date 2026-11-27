<?php

use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\CessaoBomba;
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

it('uses floating controls while keeping billing fields disabled', function () {
    $user = User::factory()->administrador()->create();
    loanPump();
    loanBeneficiary();

    $this->actingAs($user)->get(route('pumps.loans.create'))
        ->assertOk()
        ->assertSee('for="contract-type-loan"', false)
        ->assertSee('id="contract-type-loan"', false)
        ->assertSee('for="contract-type-rental"', false)
        ->assertSee('id="contract-type-rental"', false)
        ->assertSee('id="withdrawn_at"', false)
        ->assertSee('name="billing_notes"', false)
        ->assertSee('data-pump-billing-field', false)
        ->assertSee('data-mask="currency-brl"', false)
        ->assertSee('disabled="disabled"', false)
        ->assertDontSee('name="renewal"', false)
        ->assertSee('peer-not-placeholder-shown:-top-2.5', false);
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
    $loan = CessaoBomba::firstOrFail();
    expect($loan->termo_dados['monthly_fee'])->toBe('Sem cobrança');
    expect($loan->termo_dados['payments'])->toBe([]);
    $this->get(route('pumps.loans.term', $loan))->assertOk()->assertHeader('Content-Type', 'application/pdf');
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
        'dia_vencimento' => 10,
        'forma_cobranca' => 'pix',
        'primeira_cobranca_em' => '2026-08-25 00:00:00',
        'proxima_cobranca_em' => '2026-09-01 00:00:00',
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

it('freezes rental term data and reissues a real pdf without using updated records', function () {
    $user = User::factory()->administrador()->create();
    $pump = loanPump();
    $beneficiary = loanBeneficiary();

    $this->actingAs($user)->post(route('pumps.loans.store'), [
        'contract_type' => 'aluguel', 'pump' => $pump->id, 'beneficiary' => $beneficiary->id,
        'withdrawn_at' => '2026-11-21', 'expected_return' => '2026-12-21',
        'monthly_fee' => '120,50', 'due_day' => 25, 'billing_method' => 'pix',
        'first_billing_at' => '2026-11-25', 'term_signed' => 1,
        'billing_notes' => 'Pagamento combinado.', 'notes' => 'Frasco entregue.',
    ])->assertSessionHas('loan_term_id');

    $loan = CessaoBomba::firstOrFail();
    $snapshot = $loan->termo_dados;
    expect($snapshot)->toBeArray();
    expect($snapshot['beneficiary']['name'])->toBe('Ana Empréstimo');
    expect($snapshot['payments'][0]['status'])->toBe('Pendente');
    expect($loan->observacao_retirada)->not->toContain('Termo: assinado');
    $this->get(route('pumps.show', $pump))
        ->assertOk()->assertSee('data-dialog-auto-open', false)
        ->assertSee(route('pumps.loans.term', $loan), false);

    $beneficiary->update(['nome' => 'Nome alterado']);
    $pump->update(['codigo' => 'BL-ALTERADA']);
    $loan->update(['data_prevista_devolucao' => '2027-01-21']);
    $loan->pagamentos()->first()->update(['situacao' => 'pago', 'valor' => 999]);
    expect($loan->fresh()->termo_dados)->toBe($snapshot);

    $response = $this->get(route('pumps.loans.term', $loan));
    $response->assertOk()->assertHeader('Content-Type', 'application/pdf');
    expect($response->getContent())->toStartWith('%PDF-');
    $html = view('pages.pumps.loans.term', ['term' => $snapshot])->render();
    expect($html)->toContain('Ana Empréstimo', 'BL-100', '120,50', 'Pendente', 'Assinatura');
    expect($html)->not->toContain('Nome alterado', 'BL-ALTERADA', '999,00');

    $this->get(route('pumps.show', ['pump' => $pump, 'tab' => 'loans']))
        ->assertOk()->assertSee('Emitir termo')->assertDontSee('data-dialog-auto-open', false);

    $this->get(route('pumps.loans.term', [$loan, 'download' => 1]))
        ->assertOk()->assertHeader('Content-Disposition', 'attachment; filename="termo-emprestimo-'.$loan->id.'.pdf"');

    $this->actingAs(User::factory()->atendente()->create())
        ->get(route('pumps.loans.term', $loan))->assertForbidden();
    auth()->logout();
    $this->get(route('pumps.loans.term', $loan))->assertRedirect(route('login'));
});

it('does not generate or offer a term when no was selected or historical data is missing', function () {
    $user = User::factory()->administrador()->create();
    $pump = loanPump();
    $beneficiary = loanBeneficiary();
    $this->actingAs($user)->post(route('pumps.loans.store'), [
        'contract_type' => 'emprestimo', 'pump' => $pump->id, 'beneficiary' => $beneficiary->id,
        'withdrawn_at' => '2026-11-21', 'expected_return' => '2026-12-21', 'term_signed' => 0,
    ])->assertSessionMissing('loan_term_id');
    $loan = CessaoBomba::firstOrFail();
    expect($loan->termo_dados)->toBeNull();
    $loan->update(['observacao_retirada' => 'Termo: assinado']);
    $this->get(route('pumps.loans.term', $loan))->assertNotFound();
    $this->get(route('pumps.show', ['pump' => $pump, 'tab' => 'loans']))
        ->assertOk()->assertDontSee('Emitir termo')->assertDontSee('data-dialog-auto-open', false);
});
