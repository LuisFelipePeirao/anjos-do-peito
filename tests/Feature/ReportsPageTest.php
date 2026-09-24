<?php

use App\Models\Atendimento;
use App\Models\Beneficiaria;
use App\Models\BombaLeite;
use App\Models\CategoriaAtendimento;
use App\Models\Cep;
use App\Models\CessaoBomba;
use App\Models\Doador;
use App\Models\Doacao;
use App\Models\DoacaoItem;
use App\Models\Endereco;
use App\Models\EstoqueMovimentacao;
use App\Models\LocalAtendimento;
use App\Models\Material;
use App\Models\ModeloBomba;
use App\Models\PagamentoAluguel;
use App\Models\Procedimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

function assertActivityReportRows($sheet, array $expectations): void
{
    $rows = $sheet->rangeToArray('A1:O120');

    foreach ($expectations as [$label, $jan, $fev, $total]) {
        $match = collect($rows)->first(function (array $row) use ($label): bool {
            $values = array_map(fn ($value) => mb_strtoupper(trim((string) $value)), $row);

            return in_array($label, $values, true);
        });

        expect($match)->not->toBeNull("Missing row {$label}");
        expect((int) $match[2])->toBe($jan);
        expect((int) $match[3])->toBe($fev);
        expect((int) $match[14])->toBe($total);
    }
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

it('shows activity report export button with current filters', function () {
    $user = User::factory()->administrador()->create();
    $exportUrl = route('reports.export', [
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'section' => 'all',
        'location' => 'all',
    ]);

    $this->actingAs($user)
        ->get(route('reports.index', [
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'location' => 'all',
        ]))
        ->assertOk()
        ->assertSee('Gerar Relatório de Atividades')
        ->assertSee(e($exportUrl), false);
});

it('downloads an xlsx activity report', function () {
    $user = User::factory()->administrador()->create();

    $response = $this->actingAs($user)->get(route('reports.export', [
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
    ]));

    $response->assertOk();
    expect($response->headers->get('content-disposition'))->toContain('relatorio-de-atividades-2026-01-01-a-2026-12-31.xlsx');
    expect($response->headers->get('content-type'))->toContain('spreadsheetml.sheet');
});

it('exports activity report grouped by attendance data', function () {
    $user = User::factory()->administrador()->create();
    $category = CategoriaAtendimento::create(['nome' => 'Gestantes']);
    $procedure = Procedimento::create(['nome' => 'Consulta de amamentacao']);
    $cep = Cep::create([
        'cep' => '89010000',
        'cidade' => 'Blumenau',
        'uf' => 'SC',
        'bairro' => 'Centro',
        'logradouro' => 'Rua Sete de Setembro',
    ]);
    $address = Endereco::create(['id_cep' => $cep->id, 'numero' => '100']);
    $location = LocalAtendimento::create(['nome' => 'UBS Centro', 'id_endereco' => $address->id]);
    $beneficiary = reportBeneficiary([
        'cpf' => '55555555555',
        'email' => 'atividade@example.com',
        'id_endereco' => $address->id,
    ]);

    foreach (['2026-01-10 18:30:00', '2026-02-07 09:00:00'] as $date) {
        Atendimento::create([
            'data_hora' => $date,
            'modalidade' => 'presencial',
            'situacao' => 'realizado',
            'rascunho' => false,
            'id_beneficiaria' => $beneficiary->id,
            'id_categoria_atendimento' => $category->id,
            'id_procedimento' => $procedure->id,
            'id_local' => $location->id,
            'id_usuario' => $user->id,
        ]);
    }

    $response = $this->actingAs($user)->get(route('reports.export', [
        'start_date' => '2026-01-01',
        'end_date' => '2026-12-31',
        'location' => $location->id,
    ]));

    $path = tempnam(sys_get_temp_dir(), 'activity-report').'.xlsx';
    file_put_contents($path, $response->streamedContent());
    $sheet = IOFactory::load($path)->getActiveSheet();
    unlink($path);

    expect($sheet->getCell('A1')->getValue())->toContain('RELATORIO DE ATIVIDADES');
    assertActivityReportRows($sheet, [
        ['GESTANTES', 1, 1, 2],
        ['CONSULTA DE AMAMENTACAO', 1, 1, 2],
        ['UBS CENTRO', 1, 1, 2],
        ['BLUMENAU', 1, 1, 2],
        ['ATENDIMENTOS APOS AS 18 HORAS, SABADOS, DOMINGOS E FERIADOS', 1, 1, 2],
    ]);
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
