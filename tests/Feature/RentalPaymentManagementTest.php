<?php

use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\CessaoBomba;
use App\Models\ModeloBomba;
use App\Models\PagamentoAluguel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a pending rental payment as paid', function () {
    $model = ModeloBomba::create(['fabricante' => 'G', 'modelo' => 'M']);
    $pump = BombaLeite::create(['codigo' => 'PAY-1', 'id_modelo' => $model->id, 'situacao' => 'alugada', 'origem' => 'doacao']);
    $beneficiary = Beneficiaria::create(['nome' => 'Maria', 'cpf' => '12345678909', 'email' => 'maria@x.test', 'telefone' => '1', 'telefone_alternativo' => '', 'origem_cadastro' => 'busca_espontanea', 'situacao' => 'ativo']);
    $manager = User::factory()->administrador()->create();
    $loan = CessaoBomba::create(['id_bomba' => $pump->id, 'id_beneficiaria' => $beneficiary->id, 'id_usuario_retirada' => $manager->id, 'tipo' => 'aluguel', 'valor_mensalidade' => 45, 'data_retirada' => '2026-09-01', 'situacao' => 'ativa']);
    $payment = PagamentoAluguel::create(['id_cessao' => $loan->id, 'competencia' => '2026-09-01', 'valor' => 45, 'data_vencimento' => '2026-09-10', 'situacao' => 'pendente']);

    $this->actingAs($manager)->patch(route('pumps.payments.pay', [$pump, $payment]), ['paid_at' => '2026-09-12', 'notes' => 'Recebido em dinheiro.'])
        ->assertRedirect(route('pumps.show', ['pump' => $pump, 'tab' => 'payments']));

    $this->assertDatabaseHas('pagamentos_alugueis', ['id' => $payment->id, 'situacao' => 'pago', 'data_pagamento' => '2026-09-12 00:00:00']);
});
