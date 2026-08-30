<?php

use App\Models\Beneficiaria;
use App\Models\CategoriaMaterial;
use App\Models\Distribuicao;
use App\Models\Doador;
use App\Models\EstoqueMovimentacao;
use App\Models\Material;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function stockCategory(array $overrides = []): CategoriaMaterial
{
    return CategoriaMaterial::create(array_merge([
        'nome' => 'Fraldas',
        'ativo' => true,
    ], $overrides));
}

function stockMaterial(array $overrides = []): Material
{
    $category = $overrides['category'] ?? stockCategory();
    unset($overrides['category']);

    return Material::create(array_merge([
        'nome' => 'Fralda tamanho P',
        'id_categoria' => $category->id,
        'unidade_medida' => 'pacote',
        'estoque_minimo' => 10,
    ], $overrides));
}

function stockDonor(array $overrides = []): Doador
{
    return Doador::create(array_merge([
        'nome' => 'Campanha Solidária',
        'telefone' => '(47) 99999-1111',
        'email' => 'campanha@example.com',
    ], $overrides));
}

function stockBeneficiary(array $overrides = []): Beneficiaria
{
    return Beneficiaria::create(array_merge([
        'nome' => 'Maria Estoque',
        'cpf' => '12345678909',
        'email' => 'maria.estoque@example.com',
        'telefone' => '(47) 99999-2222',
        'telefone_alternativo' => '',
        'origem_cadastro' => 'busca_espontanea',
        'situacao' => 'ativo',
    ], $overrides));
}

it('uses database records on donations and stock pages', function () {
    $user = User::factory()->atendente()->create();
    $material = stockMaterial();

    $this->actingAs($user)
        ->get(route('donations.index'))
        ->assertOk()
        ->assertSee('Fralda tamanho P')
        ->assertSee('Crítico');

    $this->actingAs($user)
        ->get(route('donations.show', $material))
        ->assertOk()
        ->assertSee('Fralda tamanho P')
        ->assertSee('Sem movimentação');
});

it('shows stock items as a separate stock item surface', function () {
    $user = User::factory()->atendente()->create();
    $material = stockMaterial();

    $this->actingAs($user)
        ->get(route('donations.index'))
        ->assertOk()
        ->assertSee('Itens de estoque')
        ->assertSee('Registrar movimentação')
        ->assertSee('Novo item')
        ->assertSee('Fralda tamanho P')
        ->assertDontSee('Gestão de doações e estoque');

    $this->actingAs($user)
        ->get(route('donations.show', $material))
        ->assertOk()
        ->assertSee('Movimentações')
        ->assertSee('Registrar movimentação');
});

it('creates materials donors and donations through layered requests and service', function () {
    $user = User::factory()->administrador()->create();
    $category = stockCategory(['nome' => 'Higiene']);
    $donor = stockDonor();

    $this->actingAs($user)->get(route('donations.materials.create'))->assertOk()->assertSee('Novo item de estoque');
    $this->actingAs($user)->get(route('donations.donors.create'))->assertRedirect(route('movements.create', ['tipo' => 'entrada']));
    $this->actingAs($user)
        ->get(route('donations.create'))
        ->assertOk()
        ->assertSee('Registrar entrada')
        ->assertSee('donation-donor-create-dialog', false)
        ->assertSee('Cadastrar doador');

    $this->actingAs($user)
        ->from(route('donations.create'))
        ->post(route('donations.donors.store'), [
            'nome' => 'Doador Modal',
            'telefone' => '(47) 99999-3333',
            'email' => 'modal@example.com',
        ])
        ->assertRedirect(route('donations.create'));

    $this->assertDatabaseHas('doadores', ['nome' => 'Doador Modal']);

    $this->actingAs($user)
        ->post(route('donations.materials.store'), [
            'nome' => 'Lenço umedecido',
            'id_categoria' => $category->id,
            'unidade_medida' => 'pacote',
            'estoque_minimo' => 5,
        ])
        ->assertRedirect();

    $material = Material::where('nome', 'Lenço umedecido')->firstOrFail();

    $this->actingAs($user)
        ->post(route('donations.store'), [
            'id_doador' => $donor->id,
            'data_doacao' => '2026-08-20 10:00:00',
            'situacao' => 'recebida',
            'observacao' => 'Entrada de campanha.',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 12, 'observacao' => 'Lacrado.'],
            ],
        ])
        ->assertRedirect(route('donations.index'));

    $this->assertDatabaseHas('doacoes', ['id_doador' => $donor->id, 'situacao' => 'recebida']);
    $this->assertDatabaseHas('doacoes_itens', ['id_material' => $material->id, 'quantidade' => 12]);
    $this->assertDatabaseHas('estoque_movimentacoes', ['id_material' => $material->id, 'tipo' => 'entrada', 'quantidade' => 12]);

    $this->actingAs($user)
        ->get(route('donations.show', $material))
        ->assertOk()
        ->assertSee('12 pacotes')
        ->assertSee('Normal');
});

it('creates distributions and prevents stock from going negative', function () {
    $user = User::factory()->administrador()->create();
    $material = stockMaterial();
    $donor = stockDonor();
    $beneficiary = stockBeneficiary();

    $this->actingAs($user)
        ->get(route('donations.distributions.create'))
        ->assertOk()
        ->assertSee('Registrar saída')
        ->assertSee('Quantidade disponível')
        ->assertSee('data-add-distribution-item', false)
        ->assertDontSee('Até três');

    $this->actingAs($user)->post(route('donations.store'), [
        'id_doador' => $donor->id,
        'data_doacao' => '2026-08-20 10:00:00',
        'situacao' => 'recebida',
        'items' => [
            ['id_material' => $material->id, 'quantidade' => 8],
        ],
    ]);

    $this->actingAs($user)
        ->post(route('donations.distributions.store'), [
            'id_beneficiaria' => $beneficiary->id,
            'data_hora' => '2026-08-21 14:00:00',
            'situacao' => 'entregue',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 3],
            ],
        ])
        ->assertRedirect(route('donations.index'));

    $this->assertDatabaseHas('distribuicoes_itens', ['id_material' => $material->id, 'quantidade' => 3]);
    $this->assertDatabaseHas('estoque_movimentacoes', ['id_material' => $material->id, 'tipo' => 'saida', 'quantidade' => 3]);

    $this->actingAs($user)
        ->from(route('donations.distributions.create'))
        ->post(route('donations.distributions.store'), [
            'id_beneficiaria' => $beneficiary->id,
            'data_hora' => '2026-08-22 14:00:00',
            'situacao' => 'entregue',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 99],
            ],
        ])
        ->assertRedirect(route('donations.distributions.create'))
        ->assertSessionHasErrors('items');

    $this->actingAs($user)
        ->from(route('donations.distributions.create'))
        ->post(route('donations.distributions.store'), [
            'id_beneficiaria' => $beneficiary->id,
            'data_hora' => '2026-08-23 14:00:00',
            'situacao' => 'entregue',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 3],
                ['id_material' => $material->id, 'quantidade' => 3],
            ],
        ])
        ->assertRedirect(route('donations.distributions.create'))
        ->assertSessionHasErrors('items');
});

it('ignores canceled distributions in stock calculations', function () {
    $user = User::factory()->administrador()->create();
    $material = stockMaterial();
    $donor = stockDonor();
    $beneficiary = stockBeneficiary();

    $this->actingAs($user)->post(route('donations.store'), [
        'id_doador' => $donor->id,
        'data_doacao' => '2026-08-20 10:00:00',
        'situacao' => 'recebida',
        'items' => [
            ['id_material' => $material->id, 'quantidade' => 8],
        ],
    ]);

    $distribution = Distribuicao::create([
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario' => $user->id,
        'data_hora' => '2026-08-21 14:00:00',
        'situacao' => 'cancelada',
    ]);

    $item = $distribution->itens()->create([
        'id_material' => $material->id,
        'quantidade' => 8,
    ]);

    EstoqueMovimentacao::create([
        'id_material' => $material->id,
        'tipo' => 'saida',
        'quantidade' => 8,
        'data_hora' => '2026-08-21 14:00:00',
        'id_usuario' => $user->id,
        'id_distribuicao_item' => $item->id,
    ]);

    $this->actingAs($user)
        ->get(route('donations.show', $material))
        ->assertOk()
        ->assertSee('8 pacotes');

    $this->actingAs($user)
        ->post(route('donations.distributions.store'), [
            'id_beneficiaria' => $beneficiary->id,
            'data_hora' => '2026-08-22 14:00:00',
            'situacao' => 'entregue',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 8],
            ],
        ])
        ->assertRedirect(route('donations.index'));
});
