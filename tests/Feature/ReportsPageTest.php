<?php

use App\Models\Atendimento;
use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\CessaoBomba;
use App\Models\Doador;
use App\Models\Doacao;
use App\Models\DoacaoItem;
use App\Models\EstoqueMovimentacao;
use App\Models\Material;
use App\Models\ModeloBomba;
use App\Models\PagamentoAluguel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

function reportBeneficiary(array $overrides = []): Beneficiaria
{
    return Beneficiaria::create(array_merge([
        'nome' => 'Beneficiaria Relatorio',
        'cpf' => '12345678909',
        'email' => 'relatorio@example.com',
        'telefone' => '(47) 99999-1111',
        'telefone_alternativo' => '',
        'situacao' => 'ativo',
        'origem_cadastro' => 'busca_espontanea',
    ], $overrides));
}

it('renders reports from database records in the selected period', function () {
    $user = User::factory()->administrador()->create();
    $beneficiary = reportBeneficiary();

    Atendimento::create([
        'data_hora' => '2026-08-10 09:00:00',
        'modalidade' => 'presencial',
        'situacao' => 'realizado',
        'rascunho' => false,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario' => $user->id,
    ]);

    Atendimento::create([
        'data_hora' => '2026-08-12 10:00:00',
        'modalidade' => 'remota',
        'situacao' => 'realizado',
        'rascunho' => false,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario' => $user->id,
    ]);

    $model = ModeloBomba::create(['fabricante' => 'Real', 'modelo' => 'Reports', 'descricao' => null]);
    $pump = BombaLeite::create([
        'codigo' => 'BL-REL-1',
        'id_modelo' => $model->id,
        'situacao' => 'alugada',
        'origem' => 'doacao',
    ]);

    $loan = CessaoBomba::create([
        'id_bomba' => $pump->id,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario_retirada' => $user->id,
        'tipo' => 'aluguel',
        'valor_mensalidade' => 120,
        'data_retirada' => '2026-08-03 08:00:00',
        'data_prevista_devolucao' => '2026-08-20',
        'situacao' => 'ativa',
    ]);

    PagamentoAluguel::create([
        'id_cessao' => $loan->id,
        'competencia' => '2026-08-01',
        'valor' => 120,
        'data_vencimento' => '2026-08-15',
        'situacao' => 'pendente',
    ]);

    DB::table('categorias_materiais')->insert(['id' => 801, 'nome' => 'Categoria Real', 'ativo' => true]);
    $material = Material::create([
        'nome' => 'Kit Relatorio',
        'id_categoria' => 801,
        'unidade_medida' => 'kit',
        'estoque_minimo' => 5,
    ]);

    $donor = Doador::create(['nome' => 'Doador Real', 'telefone' => null, 'email' => null, 'observacao' => null]);
    $donation = Doacao::create([
        'id_doador' => $donor->id,
        'id_usuario' => $user->id,
        'data_doacao' => '2026-08-05 11:00:00',
        'observacao' => 'Campanha Real',
        'situacao' => 'recebida',
    ]);
    $item = DoacaoItem::create([
        'id_doacao' => $donation->id,
        'id_material' => $material->id,
        'quantidade' => 15,
    ]);
    EstoqueMovimentacao::create([
        'id_material' => $material->id,
        'tipo' => 'entrada',
        'quantidade' => 15,
        'data_hora' => '2026-08-05 11:00:00',
        'id_usuario' => $user->id,
        'id_doacao_item' => $item->id,
    ]);
    EstoqueMovimentacao::create([
        'id_material' => $material->id,
        'tipo' => 'saida',
        'quantidade' => 6,
        'data_hora' => '2026-08-13 11:00:00',
        'id_usuario' => $user->id,
    ]);

    $this->actingAs($user)
        ->get(route('reports.index', [
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-31',
        ]))
        ->assertOk()
        ->assertSee('Atendimentos realizados')
        ->assertSee('2')
        ->assertSee('BL-REL-1')
        ->assertSee('R$ 120,00')
        ->assertSee('Kit Relatorio')
        ->assertSee('Doador Real');
});

it('validates report filter dates', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)
        ->get(route('reports.index', [
            'start_date' => '2026-08-31',
            'end_date' => '2026-08-01',
        ]))
        ->assertSessionHasErrors('end_date');
});

it('counts pump loans that are still active even when withdrawn before the selected period', function () {
    $user = User::factory()->administrador()->create();
    $model = ModeloBomba::create(['fabricante' => 'G-Tech', 'modelo' => 'Smart', 'descricao' => null]);
    $beneficiaries = [
        reportBeneficiary(['cpf' => '11111111111', 'email' => 'mariana@example.com', 'nome' => 'Mariana Costa']),
        reportBeneficiary(['cpf' => '22222222222', 'email' => 'fernanda@example.com', 'nome' => 'Fernanda Martins']),
        reportBeneficiary(['cpf' => '33333333333', 'email' => 'patricia@example.com', 'nome' => 'Patricia Almeida']),
    ];

    foreach (['BL-00123', 'BL-003', 'BL-004'] as $index => $code) {
        $pump = BombaLeite::create([
            'codigo' => $code,
            'id_modelo' => $model->id,
            'situacao' => 'alugada',
            'origem' => 'doacao',
        ]);

        CessaoBomba::create([
            'id_bomba' => $pump->id,
            'id_beneficiaria' => $beneficiaries[$index]->id,
            'id_usuario_retirada' => $user->id,
            'tipo' => 'gratuita',
            'data_retirada' => '2026-08-0'.($index + 1).' 08:00:00',
            'data_prevista_devolucao' => $index === 1 ? '2026-09-05' : '2026-09-30',
            'situacao' => $index === 1 ? 'atrasada' : 'ativa',
        ]);
    }

    $this->actingAs($user)
        ->get(route('reports.index', [
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-30',
        ]))
        ->assertOk()
        ->assertSee('Bombas em uso')
        ->assertSee('3')
        ->assertSee('3 empréstimos e 0 aluguéis')
        ->assertSee('BL-00123')
        ->assertSee('BL-003')
        ->assertSee('Em atraso');
});

it('counts pump loans by date overlap even when the pump status is available', function () {
    $user = User::factory()->administrador()->create();
    $model = ModeloBomba::create(['fabricante' => 'Philips', 'modelo' => 'Avent', 'descricao' => null]);
    $beneficiary = reportBeneficiary(['cpf' => '44444444444', 'email' => 'periodo@example.com', 'nome' => 'Periodo Real']);
    $pump = BombaLeite::create([
        'codigo' => 'BL-PERIODO',
        'id_modelo' => $model->id,
        'situacao' => 'disponivel',
        'origem' => 'doacao',
    ]);

    CessaoBomba::create([
        'id_bomba' => $pump->id,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario_retirada' => $user->id,
        'tipo' => 'gratuita',
        'data_retirada' => '2026-08-20 08:00:00',
        'data_prevista_devolucao' => '2026-09-10',
        'data_devolucao' => '2026-09-05 11:00:00',
        'situacao' => 'finalizada',
    ]);

    $this->actingAs($user)
        ->get(route('reports.index', [
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-30',
        ]))
        ->assertOk()
        ->assertSee('1 empréstimos e 0 aluguéis')
        ->assertSee('BL-PERIODO')
        ->assertSee('05/09/2026');
});
