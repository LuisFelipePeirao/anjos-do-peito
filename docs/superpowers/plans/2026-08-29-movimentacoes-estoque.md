# Movimentacoes de Estoque Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Separar itens de estoque de movimentacoes e criar fluxo unificado para entrada, saida e ajuste.

**Architecture:** O modulo de itens continua em `DonationStockController` e `DonationStockService`, reaproveitando `resources/views/pages/donations`. O novo `StockMovementController` delega listagem, detalhe e criacao para `StockMovementService`; `StoreStockMovementRequest` valida campos condicionais por tipo.

**Tech Stack:** Laravel 13, PHP 8.3, Blade, Pest, Eloquent, componentes Blade existentes.

**Spec:** `docs/superpowers/specs/2026-08-29-movimentacoes-estoque-design.md`

## Global Constraints

- Nao criar tabela nova.
- Controllers devem ficar finos; regra de estoque fica em service/request/model.
- Reaproveitar `resources/views/pages/donations/distributions/create.blade.php` como formulario unificado.
- Manter rotas antigas de distribuicao funcionando como alias ou redirecionamento.
- Usar TDD: teste falha primeiro, depois producao.

---

## File Structure

- Modify `routes/web.php`: adicionar rotas `movements.*`, importar controller novo e manter aliases antigos.
- Modify `resources/views/components/app/sidebar.blade.php`: trocar `Doacoes e estoque` por `Itens de estoque` e adicionar `Movimentacoes`.
- Modify `app/Http/Controllers/DonationStockController.php`: alterar textos/redirects de itens, redirecionar ou delegar rotas antigas de distribuicao.
- Create `app/Http/Controllers/StockMovementController.php`: index, create, store e show.
- Create `app/Http/Requests/StoreStockMovementRequest.php`: validacao condicional de entrada, saida e ajuste.
- Modify `app/Services/DonationStockService.php`: expor helpers de saldo/opcoes e ajustar textos de materiais para movimentacoes.
- Create `app/Services/StockMovementService.php`: dados de index/show/create e store unificado.
- Modify `app/Models/EstoqueMovimentacao.php`: helpers de label quando necessario.
- Modify `resources/views/pages/donations/index.blade.php`: virar `Itens de estoque`.
- Modify `resources/views/pages/donations/show.blade.php`: textos e links para movimentacoes.
- Modify `resources/views/pages/donations/distributions/create.blade.php`: escolha de tipo e formularios condicionais.
- Create `resources/views/pages/movements/index.blade.php`: DataTable de lancamentos.
- Create `resources/views/pages/movements/show.blade.php`: detalhe do lancamento.
- Modify `tests/Feature/DonationStockManagementTest.php`: atualizar expectativa de itens e aliases antigos.
- Create `tests/Feature/StockMovementManagementTest.php`: cobertura principal de movimentacoes.

---

### Task 1: Rotas, menu e tela de itens

**Files:**
- Modify: `routes/web.php`
- Modify: `resources/views/components/app/sidebar.blade.php`
- Modify: `resources/views/pages/donations/index.blade.php`
- Modify: `resources/views/pages/donations/show.blade.php`
- Modify: `app/Services/DonationStockService.php`
- Test: `tests/Feature/DonationStockManagementTest.php`

**Interfaces:**
- Consumes: rotas atuais `donations.index`, `donations.show`, `donations.materials.create`.
- Produces: links para `movements.create`; textos de itens de estoque; alias antigo `donations.distributions.create`.

- [ ] **Step 1: Write failing test for renamed stock item surface**

Add/adjust in `tests/Feature/DonationStockManagementTest.php`:

```php
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
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/DonationStockManagementTest.php --filter="stock items as a separate"`
Expected: FAIL because old text still says `Doações e estoque` and route/link still uses distributions/create.

- [ ] **Step 3: Implement menu and item text changes**

Update `resources/views/components/app/sidebar.blade.php`:

```php
['label' => 'Itens de estoque', 'route' => 'donations.index', 'icon' => 'gmdi-inventory-2-o'],
['label' => 'Movimentações', 'route' => 'movements.index', 'icon' => 'gmdi-swap-horiz-o'],
```

Update `resources/views/pages/donations/index.blade.php`:

```php
@section('title', 'Itens de estoque')
@section('breadcrumb', 'Itens de estoque')
@section('page-title', 'Itens de estoque')
```

Use page-info:

```php
subheading="Estoque"
title="Itens de estoque"
description="Acompanhe saldo por material, categoria, situação e última movimentação."
:firstButton="[
    'label' => 'Registrar movimentação',
    'link' => route('movements.create'),
    'icon' => 'add',
]"
:secondButton="[
    'label' => 'Novo item',
    'link' => route('donations.materials.create'),
    'icon' => 'inventory-2-o',
]"
```

Update `resources/views/pages/donations/show.blade.php`:

```php
<a href="{{ route('movements.create', ['tipo' => 'saida', 'material' => $material->id]) }}">Registrar movimentação</a>
<a href="{{ route('movements.create', ['tipo' => 'entrada']) }}">Registrar entrada</a>
```

Change generic mentions of `distribuição` to `movimentação` where they describe stock generally.

Update `DonationStockService::materialRow()` action:

```php
['icon' => 'swap-horiz-o', 'route' => route('movements.create', ['tipo' => 'saida', 'material' => $material['id']]), 'title' => 'Registrar movimentação'],
```

- [ ] **Step 4: Add movement route stubs only enough for link generation**

In `routes/web.php`, import `StockMovementController` and add route declarations. Controller can be created in Task 2, but to pass route generation now create temporary routes only if needed by tests:

```php
Route::get('/movimentacoes', [StockMovementController::class, 'index'])->name('movements.index');
Route::get('/movimentacoes/nova', [StockMovementController::class, 'create'])->name('movements.create');
Route::post('/movimentacoes', [StockMovementController::class, 'store'])->name('movements.store');
Route::get('/movimentacoes/{movement}', [StockMovementController::class, 'show'])->name('movements.show');
```

- [ ] **Step 5: Run test to verify it passes**

Run: `php artisan test tests/Feature/DonationStockManagementTest.php --filter="stock items as a separate"`
Expected: PASS.

---

### Task 2: Movement index and show

**Files:**
- Create: `app/Http/Controllers/StockMovementController.php`
- Create: `app/Services/StockMovementService.php`
- Create: `resources/views/pages/movements/index.blade.php`
- Create: `resources/views/pages/movements/show.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/StockMovementManagementTest.php`

**Interfaces:**
- Consumes: models `Doacao`, `Distribuicao`, `EstoqueMovimentacao`.
- Produces: `StockMovementService::indexData(?string $search, string $type): array`, `StockMovementService::showData(string $kind, int $id): array` or equivalent route model approach.

- [ ] **Step 1: Write failing index/show tests**

Create `tests/Feature/StockMovementManagementTest.php` with helpers reused or duplicated from donation stock tests:

```php
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
```

- [ ] **Step 2: Run tests to verify fail**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php --filter="lists stock movements"`
Expected: FAIL because route/controller/view missing.

- [ ] **Step 3: Implement controller/service data**

Create `StockMovementController`:

```php
namespace App\Http\Controllers;

use App\Http\Requests\StoreStockMovementRequest;
use App\Models\EstoqueMovimentacao;
use App\Services\StockMovementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function __construct(private readonly StockMovementService $movements) {}

    public function index(Request $request): View
    {
        return view('pages.movements.index', $this->movements->indexData(
            $request->string('q')->trim()->toString(),
            $request->string('type', 'all')->toString(),
        ));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->canManageAttendances(), 403);

        return view('pages.donations.distributions.create', $this->movements->createData(
            $request->string('tipo')->toString(),
            $request->integer('material') ?: null,
        ));
    }

    public function store(StoreStockMovementRequest $request): RedirectResponse
    {
        $movement = $this->movements->create($request->validated(), $request->user()->id);

        return redirect()->route('movements.show', $movement)->with('status', 'Movimentação registrada com sucesso.');
    }

    public function show(EstoqueMovimentacao $movement): View
    {
        return view('pages.movements.show', $this->movements->showData($movement));
    }
}
```

Create `StockMovementService` methods:

```php
public function indexData(?string $search, string $type): array
{
    $query = EstoqueMovimentacao::with(['material', 'usuario', 'doacaoItem.doacao.doador', 'distribuicaoItem.distribuicao.beneficiaria'])
        ->latest('data_hora');

    if ($type !== 'all') {
        $query->where('tipo', $type);
    }

    $rows = $query->get()
        ->filter(fn (EstoqueMovimentacao $movement) => $search === '' || str_contains(mb_strtolower($this->rowSearchText($movement)), mb_strtolower($search)))
        ->map(fn (EstoqueMovimentacao $movement) => $this->movementRow($movement))
        ->values()
        ->all();

    return ['movements' => $rows, 'search' => $search, 'type' => $type];
}
```

Add row helpers with values:

```php
[
    'date' => $movement->data_hora?->format('d/m/Y H:i') ?? '-',
    'type' => $this->typeLabel($movement->tipo),
    'origin' => $this->originLabel($movement),
    'materials' => $movement->material?->nome ?? '-',
    'responsible' => $movement->usuario?->nome ?? '-',
    'status' => $this->statusLabel($movement),
    '_actions' => ['view' => route('movements.show', $movement), 'items' => [['icon' => 'visibility-o', 'route' => route('movements.show', $movement), 'title' => 'Visualizar movimentação']]],
]
```

Show data returns `movement`, `summary`, `items`.

- [ ] **Step 4: Implement index and show views**

Create `resources/views/pages/movements/index.blade.php` using `x-app.page-info` and `x-tables.datatable`.

Create `resources/views/pages/movements/show.blade.php` using same card and DataTable patterns from `donations.show`.

- [ ] **Step 5: Run tests to verify pass**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php --filter="lists stock movements"`
Expected: PASS.

---

### Task 3: Unified create screen type chooser and entrada/saida forms

**Files:**
- Modify: `resources/views/pages/donations/distributions/create.blade.php`
- Create: `app/Http/Requests/StoreStockMovementRequest.php`
- Modify: `app/Services/StockMovementService.php`
- Modify: `app/Http/Controllers/DonationStockController.php`
- Test: `tests/Feature/StockMovementManagementTest.php`
- Test: `tests/Feature/DonationStockManagementTest.php`

**Interfaces:**
- Consumes: `StockMovementController::create()` passes `movementType`, `selectedMaterial`, form options.
- Produces: `StockMovementService::create(array $data, int $userId): EstoqueMovimentacao`.

- [ ] **Step 1: Write failing tests for chooser and entrada**

Add:

```php
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
```

- [ ] **Step 2: Run tests to verify fail**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php --filter="chooser|entry movements"`
Expected: FAIL because request/store/form not implemented.

- [ ] **Step 3: Implement `StoreStockMovementRequest`**

Rules:

```php
'tipo' => ['required', Rule::in(['entrada', 'saida', 'ajuste'])],
'id_doador' => [Rule::requiredIf($this->input('tipo') === 'entrada'), 'nullable', 'integer', 'exists:doadores,id'],
'id_beneficiaria' => [Rule::requiredIf($this->input('tipo') === 'saida'), 'nullable', 'integer', 'exists:beneficiarias,id'],
'id_material' => [Rule::requiredIf($this->input('tipo') === 'ajuste'), 'nullable', 'integer', 'exists:materiais,id'],
'operacao' => [Rule::requiredIf($this->input('tipo') === 'ajuste'), 'nullable', Rule::in(['adicionar', 'subtrair'])],
'data_hora' => ['required', 'date'],
'situacao' => ['nullable', 'string'],
'observacao' => [Rule::requiredIf($this->input('tipo') === 'ajuste'), 'nullable', 'string'],
'items' => [Rule::requiredIf(in_array($this->input('tipo'), ['entrada', 'saida'], true)), 'array'],
'items.*.id_material' => ['required_with:items', 'integer', 'exists:materiais,id'],
'items.*.quantidade' => ['required_with:items', 'integer', 'min:1'],
'quantidade' => [Rule::requiredIf($this->input('tipo') === 'ajuste'), 'nullable', 'integer', 'min:1'],
```

In `prepareForValidation`, filter empty `items` as current donation/distribution requests do.

- [ ] **Step 4: Implement service create for entrada and saida**

In `StockMovementService::create`, dispatch by `tipo`.

For entrada, create `Doacao`, itens, and `EstoqueMovimentacao` as `DonationStockService::createDonation` does. Return first created stock movement.

For saida, create `Distribuicao`, itens, validate stock with grouped item totals, create `EstoqueMovimentacao` as `DonationStockService::createDistribution` does. Return first created stock movement.

- [ ] **Step 5: Implement unified create view chooser/entrada/saida**

At top of `create.blade.php`, use `$movementType`.

When no `$movementType`, show three cards/buttons linking to `route('movements.create', ['tipo' => 'entrada'])`, `saida`, `ajuste`.

When `entrada`, render fields from old donation create, include donor modal, action `route('movements.store')`, hidden `tipo=entrada`, and use `data_hora` input name.

When `saida`, render existing distribution form, action `route('movements.store')`, hidden `tipo=saida`, existing dynamic item rows and stock validation.

- [ ] **Step 6: Keep old distribution routes working**

In `DonationStockController::createDistribution`, return redirect:

```php
return redirect()->route('movements.create', array_filter([
    'tipo' => 'saida',
    'material' => $request->integer('material') ?: null,
]));
```

In `DonationStockController::storeDistribution`, delegate or redirect by using `StockMovementService` if injected, or leave existing behavior until all links are changed. Existing tests should still pass for old route.

- [ ] **Step 7: Run tests to verify pass**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php --filter="chooser|entry movements"`
Expected: PASS.

Run: `php artisan test tests/Feature/DonationStockManagementTest.php`
Expected: PASS.

---

### Task 4: Ajuste movements

**Files:**
- Modify: `resources/views/pages/donations/distributions/create.blade.php`
- Modify: `app/Http/Requests/StoreStockMovementRequest.php`
- Modify: `app/Services/StockMovementService.php`
- Test: `tests/Feature/StockMovementManagementTest.php`

**Interfaces:**
- Consumes: current balance helper.
- Produces: adjustment movement with `tipo=ajuste`, positive or negative quantity.

- [ ] **Step 1: Write failing tests for adjustment validation and persistence**

Add:

```php
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
```

- [ ] **Step 2: Run tests to verify fail**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php --filter="adjustment"`
Expected: FAIL because ajuste form/store missing.

- [ ] **Step 3: Implement adjustment service logic**

In `StockMovementService`:

```php
private function createAdjustment(array $data, int $userId): EstoqueMovimentacao
{
    $material = Material::with('movimentacoes.distribuicaoItem.distribuicao')->findOrFail($data['id_material']);
    $quantity = (int) $data['quantidade'];

    if ($data['operacao'] === 'subtrair') {
        $available = $this->balance($material);
        if ($available < $quantity) {
            throw ValidationException::withMessages([
                'quantidade' => 'Saldo insuficiente para '.$material->nome.'. Disponível: '.$available.', solicitado: '.$quantity.'.',
            ]);
        }
        $quantity *= -1;
    }

    return EstoqueMovimentacao::create([
        'id_material' => $material->id,
        'tipo' => 'ajuste',
        'quantidade' => $quantity,
        'data_hora' => $data['data_hora'],
        'id_usuario' => $userId,
        'observacao' => $data['observacao'],
    ]);
}
```

- [ ] **Step 4: Implement adjustment form**

In create view for `$movementType === 'ajuste'`, render:

```php
<input type="hidden" name="tipo" value="ajuste">
<x-material.select name="id_material" label="Material" :options="$materials" :selected="old('id_material', $selectedMaterial)" required />
<x-material.select name="operacao" label="Operação" :options="['adicionar' => 'Adicionar ao estoque', 'subtrair' => 'Subtrair do estoque']" :selected="old('operacao', 'adicionar')" required />
<input type="number" min="1" name="quantidade" value="{{ old('quantidade') }}" required>
<input type="datetime-local" name="data_hora" value="{{ old('data_hora', now()->format('Y-m-d\TH:i')) }}" required>
<textarea name="observacao" required>{{ old('observacao') }}</textarea>
```

- [ ] **Step 5: Run tests to verify pass**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php --filter="adjustment"`
Expected: PASS.

---

### Task 5: Full integration cleanup

**Files:**
- Modify: all files touched above
- Test: all relevant feature tests

**Interfaces:**
- Consumes: Tasks 1-4.
- Produces: passing module with no stale distribution labels except database/model names.

- [ ] **Step 1: Search stale copy and links**

Run: `rg "Registrar distribuição|Doações e estoque|donations\\.distributions\\.create|donations\\.distributions\\.store" app resources routes tests -n`

Expected remaining matches only for backward-compatible routes/tests or database terminology where appropriate.

- [ ] **Step 2: Run stock-related tests**

Run: `php artisan test tests/Feature/DonationStockManagementTest.php tests/Feature/StockMovementManagementTest.php`
Expected: PASS.

- [ ] **Step 3: Run full test suite**

Run: `composer test`
Expected: PASS.

- [ ] **Step 4: Format**

Run: `vendor/bin/pint --dirty`
Expected: no formatting errors.

- [ ] **Step 5: Final git check**

Run: `git status --short`
Expected: only intended implementation files changed.
