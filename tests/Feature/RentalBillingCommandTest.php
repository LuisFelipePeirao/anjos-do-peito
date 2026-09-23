<?php

use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\CessaoBomba;
use App\Models\ModeloBomba;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

uses(RefreshDatabase::class);

it('generates one due installment and does not duplicate it', function () {
    $model = ModeloBomba::create(['fabricante' => 'G', 'modelo' => 'M']);
    $pump = BombaLeite::create(['codigo' => 'REC-1', 'id_modelo' => $model->id, 'situacao' => 'alugada', 'origem' => 'doacao']);
    $beneficiary = Beneficiaria::create(['nome' => 'Ana', 'cpf' => '12345678909', 'email' => 'ana@x.test', 'telefone' => '1', 'telefone_alternativo' => '', 'origem_cadastro' => 'busca_espontanea', 'situacao' => 'ativo']);
    $user = User::factory()->administrador()->create();
    $loan = CessaoBomba::create(['id_bomba' => $pump->id, 'id_beneficiaria' => $beneficiary->id, 'id_usuario_retirada' => $user->id, 'tipo' => 'aluguel', 'valor_mensalidade' => 100, 'dia_vencimento' => 31, 'forma_cobranca' => 'pix', 'primeira_cobranca_em' => '2026-01-31', 'proxima_cobranca_em' => '2026-02-01', 'data_retirada' => '2026-01-01', 'situacao' => 'ativa']);

    Artisan::call('rentals:generate-payments', ['--date' => '2026-02-28']);
    Artisan::call('rentals:generate-payments', ['--date' => '2026-02-28']);

    $this->assertDatabaseHas('pagamentos_alugueis', ['id_cessao' => $loan->id, 'competencia' => '2026-02-01 00:00:00', 'data_vencimento' => '2026-02-28 00:00:00', 'situacao' => 'pendente']);
    expect($loan->pagamentos()->count())->toBe(1);
});
