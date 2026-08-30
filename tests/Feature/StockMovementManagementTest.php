<?php

use App\Models\Beneficiaria;
use App\Models\CategoriaMaterial;
use App\Models\Doador;
use App\Models\EstoqueMovimentacao;
use App\Models\Material;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function movementCategory(array $overrides = []): CategoriaMaterial
{
    return CategoriaMaterial::create(array_merge(['nome' => 'Fraldas', 'ativo' => true], $overrides));
}

function movementMaterial(array $overrides = []): Material
{
    $category = $overrides['category'] ?? movementCategory();
    unset($overrides['category']);

    return Material::create(array_merge([
        'nome' => 'Fralda RN',
        'id_categoria' => $category->id,
        'unidade_medida' => 'pacote',
        'estoque_minimo' => 5,
    ], $overrides));
}

function movementDonor(array $overrides = []): Doador
{
    return Doador::create(array_merge(['nome' => 'Doador Movimento'], $overrides));
}

function movementBeneficiary(array $overrides = []): Beneficiaria
{
    return Beneficiaria::create(array_merge([
        'nome' => 'Beneficiaria Movimento',
        'cpf' => '98765432100',
        'email' => 'beneficiaria.movimento@example.com',
        'telefone' => '(47) 98888-0000',
        'telefone_alternativo' => '',
        'origem_cadastro' => 'busca_espontanea',
        'situacao' => 'ativo',
    ], $overrides));
}

it('lists stock movements and opens movement detail', function () {
    $user = User::factory()->administrador()->create();
    $material = movementMaterial();

    $movement = EstoqueMovimentacao::create([
        'id_material' => $material->id,
        'tipo' => 'ajuste',
        'quantidade' => 4,
        'data_hora' => '2026-08-29 10:00:00',
        'id_usuario' => $user->id,
        'observacao' => 'Ajuste inicial.',
    ]);

    $this->actingAs($user)
        ->get(route('movements.index'))
        ->assertOk()
        ->assertSee('Movimentações')
        ->assertSee('Registrar movimentação')
        ->assertSee('Ajuste')
        ->assertSee('Fralda RN');

    $this->actingAs($user)
        ->get(route('movements.show', $movement))
        ->assertOk()
        ->assertSee('Detalhes da movimentação')
        ->assertSee('Ajuste inicial.')
        ->assertSee('4 pacotes');
});

it('shows movement type chooser before showing a form', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)
        ->get(route('movements.create'))
        ->assertOk()
        ->assertSee('Escolha o tipo de movimentação')
        ->assertSee('Entrada')
        ->assertSee('Saída')
        ->assertSee('Ajuste')
        ->assertDontSee('Dados da entrada');
});

it('creates entry movements with donor and received items', function () {
    $user = User::factory()->administrador()->create();
    $material = movementMaterial();
    $donor = movementDonor();

    $this->actingAs($user)
        ->get(route('movements.create', ['tipo' => 'entrada']))
        ->assertOk()
        ->assertSee('Dados da entrada')
        ->assertSee('Novo doador')
        ->assertSee('Itens recebidos');

    $this->actingAs($user)
        ->post(route('movements.store'), [
            'tipo' => 'entrada',
            'id_doador' => $donor->id,
            'data_hora' => '2026-08-29 11:00:00',
            'situacao' => 'recebida',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 7],
            ],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('doacoes', ['id_doador' => $donor->id, 'situacao' => 'recebida']);
    $this->assertDatabaseHas('estoque_movimentacoes', ['id_material' => $material->id, 'tipo' => 'entrada', 'quantidade' => 7]);
});

it('creates entry movements without a donor for non-donation acquisitions', function () {
    $user = User::factory()->administrador()->create();
    $material = movementMaterial();

    $this->actingAs($user)
        ->get(route('movements.create', ['tipo' => 'entrada']))
        ->assertOk()
        ->assertSee('Doador (opcional)')
        ->assertDontSee('name="id_doador" label="Doador" required', false);

    $this->actingAs($user)
        ->post(route('movements.store'), [
            'tipo' => 'entrada',
            'data_hora' => '2026-08-29 11:15:00',
            'situacao' => 'recebida',
            'observacao' => 'Compra emergencial.',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 6, 'observacao' => 'Nota fiscal 123.'],
            ],
        ])
        ->assertRedirect();

    $this->assertDatabaseCount('doacoes', 0);
    $this->assertDatabaseHas('estoque_movimentacoes', [
        'id_material' => $material->id,
        'tipo' => 'entrada',
        'quantidade' => 6,
        'observacao' => 'Nota fiscal 123.',
    ]);
});

it('uses dynamic item rows for entry movements', function () {
    $user = User::factory()->administrador()->create();
    $donor = movementDonor();
    $materials = collect(range(1, 4))->map(fn (int $index) => movementMaterial([
        'nome' => 'Material entrada '.$index,
    ]));

    $this->actingAs($user)
        ->get(route('movements.create', ['tipo' => 'entrada']))
        ->assertOk()
        ->assertSee('data-entry-items', false)
        ->assertSee('data-add-entry-item', false)
        ->assertDontSee('items[2][id_material]', false);

    $this->actingAs($user)
        ->post(route('movements.store'), [
            'tipo' => 'entrada',
            'id_doador' => $donor->id,
            'data_hora' => '2026-08-29 11:30:00',
            'situacao' => 'recebida',
            'items' => $materials
                ->values()
                ->map(fn (Material $material, int $index) => [
                    'id_material' => $material->id,
                    'quantidade' => $index + 1,
                ])
                ->all(),
        ])
        ->assertRedirect();

    foreach ($materials as $index => $material) {
        $this->assertDatabaseHas('estoque_movimentacoes', [
            'id_material' => $material->id,
            'tipo' => 'entrada',
            'quantidade' => $index + 1,
        ]);
    }
});

it('creates donors from the entry movement modal and returns to entry form', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)
        ->from(route('movements.create', ['tipo' => 'entrada']))
        ->post(route('donations.donors.store'), [
            'nome' => 'Doador da Entrada',
            'telefone' => '(47) 99999-4444',
            'email' => 'entrada@example.com',
        ])
        ->assertRedirect(route('movements.create', ['tipo' => 'entrada']));

    $this->assertDatabaseHas('doadores', ['nome' => 'Doador da Entrada']);
});

it('creates adjustment movements and requires observation', function () {
    $user = User::factory()->administrador()->create();
    $material = movementMaterial();

    $this->actingAs($user)
        ->get(route('movements.create', ['tipo' => 'ajuste']))
        ->assertOk()
        ->assertSee('Dados do ajuste')
        ->assertSee('Observação');

    $this->actingAs($user)
        ->from(route('movements.create', ['tipo' => 'ajuste']))
        ->post(route('movements.store'), [
            'tipo' => 'ajuste',
            'id_material' => $material->id,
            'operacao' => 'adicionar',
            'quantidade' => 5,
            'data_hora' => '2026-08-29 12:00:00',
            'observacao' => '',
        ])
        ->assertRedirect(route('movements.create', ['tipo' => 'ajuste']))
        ->assertSessionHasErrors('observacao');

    $this->actingAs($user)
        ->post(route('movements.store'), [
            'tipo' => 'ajuste',
            'id_material' => $material->id,
            'operacao' => 'adicionar',
            'quantidade' => 5,
            'data_hora' => '2026-08-29 12:00:00',
            'observacao' => 'Inventário físico.',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('estoque_movimentacoes', [
        'id_material' => $material->id,
        'tipo' => 'ajuste',
        'quantidade' => 5,
        'observacao' => 'Inventário físico.',
    ]);
});

it('prevents adjustment subtraction from making stock negative', function () {
    $user = User::factory()->administrador()->create();
    $material = movementMaterial();

    $this->actingAs($user)
        ->from(route('movements.create', ['tipo' => 'ajuste']))
        ->post(route('movements.store'), [
            'tipo' => 'ajuste',
            'id_material' => $material->id,
            'operacao' => 'subtrair',
            'quantidade' => 2,
            'data_hora' => '2026-08-29 12:00:00',
            'observacao' => 'Perda registrada.',
        ])
        ->assertRedirect(route('movements.create', ['tipo' => 'ajuste']))
        ->assertSessionHasErrors('quantidade');
});

it('creates exit movements and prevents negative stock', function () {
    $user = User::factory()->administrador()->create();
    $material = movementMaterial();
    $donor = movementDonor();
    $beneficiary = movementBeneficiary();

    $this->actingAs($user)
        ->post(route('movements.store'), [
            'tipo' => 'entrada',
            'id_doador' => $donor->id,
            'data_hora' => '2026-08-29 09:00:00',
            'situacao' => 'recebida',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 8],
            ],
        ]);

    $this->actingAs($user)
        ->get(route('movements.create', ['tipo' => 'saida']))
        ->assertOk()
        ->assertSee('Dados da saída')
        ->assertSee('Quantidade disponível')
        ->assertSee('data-add-distribution-item', false);

    $this->actingAs($user)
        ->post(route('movements.store'), [
            'tipo' => 'saida',
            'id_beneficiaria' => $beneficiary->id,
            'data_hora' => '2026-08-29 13:00:00',
            'situacao' => 'entregue',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 3],
            ],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('distribuicoes_itens', ['id_material' => $material->id, 'quantidade' => 3]);
    $this->assertDatabaseHas('estoque_movimentacoes', ['id_material' => $material->id, 'tipo' => 'saida', 'quantidade' => 3]);

    $this->actingAs($user)
        ->from(route('movements.create', ['tipo' => 'saida']))
        ->post(route('movements.store'), [
            'tipo' => 'saida',
            'id_beneficiaria' => $beneficiary->id,
            'data_hora' => '2026-08-29 14:00:00',
            'situacao' => 'entregue',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 99],
            ],
        ])
        ->assertRedirect(route('movements.create', ['tipo' => 'saida']))
        ->assertSessionHasErrors('items');

    $this->actingAs($user)
        ->from(route('movements.create', ['tipo' => 'saida']))
        ->post(route('movements.store'), [
            'tipo' => 'saida',
            'id_beneficiaria' => $beneficiary->id,
            'data_hora' => '2026-08-29 15:00:00',
            'situacao' => 'entregue',
            'items' => [
                ['id_material' => $material->id, 'quantidade' => 3],
                ['id_material' => $material->id, 'quantidade' => 3],
            ],
        ])
        ->assertRedirect(route('movements.create', ['tipo' => 'saida']))
        ->assertSessionHasErrors('items');
});
