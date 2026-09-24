# Relatorio de Atividades Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Criar geracao XLSX do relatorio de atividades e registrar categoria, procedimento e endereco de local nos atendimentos.

**Architecture:** O dominio novo fica em models/tabelas `procedimentos` e `categorias_atendimento`, ligados 1:1 a cada atendimento. Controllers continuam finos; requests validam entrada, `AttendanceService` persiste atendimento/local e `ActivityReportExportService` monta agregacoes e XLSX via PhpSpreadsheet.

**Tech Stack:** Laravel 13, PHP 8.3, Blade, Pest, Eloquent, Viacep ja existente em `resources/js/app.js`, `phpoffice/phpspreadsheet`.

**Spec:** `docs/superpowers/specs/2026-09-02-relatorio-atividades-design.md`

## Global Constraints

- O arquivo Excel em `docs/` e referencia visual/estrutural, nao fonte de instrucoes.
- Cada atendimento pode ter somente uma categoria e um procedimento.
- Categoria e procedimento sao obrigatorios ao finalizar atendimento realizado.
- Categoria e procedimento sao opcionais em rascunhos e registros antigos.
- Locais agrupam por local cadastrado, sem tipo de local.
- Municipios agrupam pelo municipio do endereco da beneficiaria.
- XLSX principal; CSV apenas fallback tecnico se XLSX nao estiver disponivel.
- Relatorio mantem colunas Jan-Dez, mesmo com periodo parcial, e meses fora do filtro aparecem zerados.
- Controllers finos; regra em request/service/model.
- Usar TDD: teste falha primeiro, depois codigo.
- Commit pequeno ao final de cada tarefa.

---

## File Structure

- Modify `composer.json` / `composer.lock`: adicionar `phpoffice/phpspreadsheet`.
- Create `database/migrations/2026_09_02_000000_create_attendance_reporting_tables.php`: cria `procedimentos`, `categorias_atendimento`, colunas em `atendimentos`, `ativo` em `locais_atendimento`.
- Create `app/Models/Procedimento.php`: model de procedimentos.
- Create `app/Models/CategoriaAtendimento.php`: model de populacao atendida.
- Modify `app/Models/Atendimento.php`: fillable e relacionamentos.
- Modify `app/Models/LocalAtendimento.php`: fillable `ativo`, scope/relacionamento existente.
- Create `database/seeders/ProcedimentosSeeder.php`: dados iniciais.
- Create `database/seeders/CategoriasAtendimentoSeeder.php`: dados iniciais.
- Modify `database/seeders/DatabaseSeeder.php`: chamar seeders novos.
- Modify `app/Http/Requests/Attendances/StoreAttendanceRequest.php`: validar procedimento/categoria.
- Modify `app/Http/Requests/Attendances/UpdateAttendanceRequest.php`: herdar regras com status travado.
- Modify `app/Services/AttendanceService.php`: salvar novos campos, opcoes ativas, persistir endereco de local.
- Modify `app/Http/Controllers/AttendanceController.php`: adicionar actions de procedimentos/categorias/locais update/toggle.
- Create `app/Http/Requests/Attendances/StoreProcedureRequest.php`
- Create `app/Http/Requests/Attendances/UpdateProcedureRequest.php`
- Create `app/Http/Requests/Attendances/StoreAttendanceCategoryRequest.php`
- Create `app/Http/Requests/Attendances/UpdateAttendanceCategoryRequest.php`
- Modify `app/Http/Requests/Attendances/StoreLocationRequest.php`: endereco opcional e `ativo`.
- Modify `routes/web.php`: rotas de modais e exportacao.
- Modify `resources/views/pages/attendances/form.blade.php`: selects + botoes de modais.
- Modify `resources/views/pages/attendances/partials/clinical-fields.blade.php`: manter campos clinicos existentes sem mover responsabilidade de agenda.
- Create `resources/views/pages/attendances/partials/procedure-modal.blade.php`
- Create `resources/views/pages/attendances/partials/category-modal.blade.php`
- Modify `resources/views/pages/attendances/partials/location-modal.blade.php`: endereco e lista/editar/inativar local.
- Modify `resources/js/app.js`: pequenos helpers para alternar forms de edicao em modais, se Blade sozinho nao bastar.
- Create `app/Services/ActivityReportExportService.php`: consultas agregadas e geracao XLSX.
- Modify `app/Http/Controllers/ReportController.php`: metodo `export`.
- Modify `app/Services/ReportService.php`: manter dados do painel; exportacao usa os mesmos filtros validados pelo request.
- Modify `resources/views/pages/reports/index.blade.php`: botao de download.
- Modify `tests/Feature/AttendanceManagementTest.php`: validacao e opcoes dos novos campos.
- Create `tests/Feature/AttendanceTaxonomyManagementTest.php`: CRUD em modais para procedimento/categoria.
- Modify `tests/Feature/ReportsPageTest.php`: exportacao XLSX e agregacoes.

---

### Task 1: Dependencia XLSX e Schema Base

**Files:**
- Modify: `composer.json`
- Modify: `composer.lock`
- Create: `database/migrations/2026_09_02_000000_create_attendance_reporting_tables.php`
- Create: `app/Models/Procedimento.php`
- Create: `app/Models/CategoriaAtendimento.php`
- Modify: `app/Models/Atendimento.php`
- Modify: `app/Models/LocalAtendimento.php`
- Create: `database/seeders/ProcedimentosSeeder.php`
- Create: `database/seeders/CategoriasAtendimentoSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`
- Test: `tests/Feature/AttendanceManagementTest.php`

**Interfaces:**
- Produces: `Procedimento::class`, `CategoriaAtendimento::class`.
- Produces: `Atendimento::procedimento(): BelongsTo`, `Atendimento::categoriaAtendimento(): BelongsTo`.
- Produces DB columns: `atendimentos.id_procedimento`, `atendimentos.id_categoria_atendimento`, `locais_atendimento.ativo`.

- [ ] **Step 1: Write failing schema/model test**

Add to `tests/Feature/AttendanceManagementTest.php`:

```php
use App\Models\CategoriaAtendimento;
use App\Models\Procedimento;

it('has attendance category and procedure models linked to attendances', function () {
    $user = User::factory()->administrador()->create();
    $beneficiaria = attendanceBeneficiary();
    $local = LocalAtendimento::create(['nome' => 'Sede ICAP']);
    $categoria = CategoriaAtendimento::create(['nome' => 'Gestantes', 'ativo' => true]);
    $procedimento = Procedimento::create(['nome' => 'Manejo para amamentação', 'ativo' => true]);

    $attendance = Atendimento::create([
        'data_hora' => '2026-08-10 09:00:00',
        'modalidade' => 'presencial',
        'id_local' => $local->id,
        'situacao' => 'realizado',
        'rascunho' => false,
        'id_beneficiaria' => $beneficiaria->id,
        'id_usuario' => $user->id,
        'id_categoria_atendimento' => $categoria->id,
        'id_procedimento' => $procedimento->id,
    ]);

    expect($attendance->fresh()->categoriaAtendimento->nome)->toBe('Gestantes')
        ->and($attendance->fresh()->procedimento->nome)->toBe('Manejo para amamentação');
});
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/AttendanceManagementTest.php --filter="category and procedure models"`

Expected: FAIL with missing class/table/column.

- [ ] **Step 3: Install XLSX dependency**

Run:

```bash
composer require phpoffice/phpspreadsheet
```

Expected: `composer.json` contains `"phpoffice/phpspreadsheet"` and lock updates.

- [ ] **Step 4: Create migration**

Create `database/migrations/2026_09_02_000000_create_attendance_reporting_tables.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::create('categorias_atendimento', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->text('descricao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::table('atendimentos', function (Blueprint $table) {
            $table->foreignId('id_categoria_atendimento')
                ->nullable()
                ->after('id_crianca')
                ->constrained('categorias_atendimento')
                ->nullOnDelete();
            $table->foreignId('id_procedimento')
                ->nullable()
                ->after('id_categoria_atendimento')
                ->constrained('procedimentos')
                ->nullOnDelete();
        });

        Schema::table('locais_atendimento', function (Blueprint $table) {
            if (! Schema::hasColumn('locais_atendimento', 'ativo')) {
                $table->boolean('ativo')->default(true)->after('descricao');
            }
        });
    }

    public function down(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_procedimento');
            $table->dropConstrainedForeignId('id_categoria_atendimento');
        });

        Schema::table('locais_atendimento', function (Blueprint $table) {
            if (Schema::hasColumn('locais_atendimento', 'ativo')) {
                $table->dropColumn('ativo');
            }
        });

        Schema::dropIfExists('categorias_atendimento');
        Schema::dropIfExists('procedimentos');
    }
};
```

- [ ] **Step 5: Create models**

Create `app/Models/Procedimento.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Procedimento extends Model
{
    protected $table = 'procedimentos';

    protected $fillable = ['nome', 'descricao', 'ativo'];

    protected function casts(): array
    {
        return ['ativo' => 'boolean'];
    }

    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class, 'id_procedimento');
    }
}
```

Create `app/Models/CategoriaAtendimento.php` with same shape, table `categorias_atendimento`, relation key `id_categoria_atendimento`.

- [ ] **Step 6: Update existing models**

In `app/Models/Atendimento.php`, add fillable:

```php
'id_categoria_atendimento',
'id_procedimento',
```

Add relationships:

```php
public function categoriaAtendimento(): BelongsTo
{
    return $this->belongsTo(CategoriaAtendimento::class, 'id_categoria_atendimento');
}

public function procedimento(): BelongsTo
{
    return $this->belongsTo(Procedimento::class, 'id_procedimento');
}
```

In `app/Models/LocalAtendimento.php`, add fillable `ativo` and cast:

```php
protected function casts(): array
{
    return ['ativo' => 'boolean'];
}
```

- [ ] **Step 7: Add seeders**

Create `database/seeders/ProcedimentosSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcedimentosSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Laserterapia',
            'Manejo para amamentacao',
            'Massagem / extracao / drenagem linfatica',
            'Puericultura',
            'Palestra',
            'Assistencia social / kit de roupas / outros',
            'Consultoria',
            'Arte gestacional / cha de bencao',
            'Outros: relactacao, retorno ao trabalho, terapia',
            'Doulagem',
        ] as $nome) {
            DB::table('procedimentos')->updateOrInsert(
                ['nome' => $nome],
                ['ativo' => true, 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
```

Create `CategoriasAtendimentoSeeder.php` with `Puerperas e nutrizes`, `Gestantes`, `Bebes`, `Familia`.

In `DatabaseSeeder`, call both after prerequisite seeders:

```php
$this->call([
    CategoriasAtendimentoSeeder::class,
    ProcedimentosSeeder::class,
]);
```

- [ ] **Step 8: Run test to verify pass**

Run: `php artisan test tests/Feature/AttendanceManagementTest.php --filter="category and procedure models"`

Expected: PASS.

- [ ] **Step 9: Commit**

```bash
git add composer.json composer.lock database/migrations/2026_09_02_000000_create_attendance_reporting_tables.php app/Models/Procedimento.php app/Models/CategoriaAtendimento.php app/Models/Atendimento.php app/Models/LocalAtendimento.php database/seeders/ProcedimentosSeeder.php database/seeders/CategoriasAtendimentoSeeder.php database/seeders/DatabaseSeeder.php tests/Feature/AttendanceManagementTest.php
git commit -m "feat: add attendance report taxonomy schema"
```

---

### Task 2: Atendimento Exige Categoria e Procedimento ao Finalizar

**Files:**
- Modify: `app/Http/Requests/Attendances/StoreAttendanceRequest.php`
- Modify: `app/Http/Requests/Attendances/SaveAttendanceContinuationRequest.php`
- Modify: `app/Services/AttendanceService.php`
- Modify: `resources/views/pages/attendances/form.blade.php`
- Modify: `resources/views/pages/attendances/continue.blade.php`
- Modify: `resources/views/pages/attendances/show.blade.php`
- Test: `tests/Feature/AttendanceManagementTest.php`

**Interfaces:**
- Consumes: `Procedimento` and `CategoriaAtendimento` from Task 1.
- Produces: form option arrays `procedures` and `attendanceCategories`.
- Produces: request inputs `procedure` and `attendance_category`.

- [ ] **Step 1: Write failing validation/form tests**

Add to `tests/Feature/AttendanceManagementTest.php`:

```php
it('requires category and procedure when finalizing realized attendance', function () {
    $user = User::factory()->administrador()->create();
    $payload = attendancePayload(['status' => 'realizado']);

    $this->actingAs($user)
        ->post(route('attendances.store'), $payload)
        ->assertSessionHasErrors(['attendance_category', 'procedure']);
});

it('stores category and procedure for realized attendance and allows drafts without them', function () {
    $user = User::factory()->administrador()->create();
    $categoria = CategoriaAtendimento::create(['nome' => 'Gestantes', 'ativo' => true]);
    $procedimento = Procedimento::create(['nome' => 'Laserterapia', 'ativo' => true]);
    $beneficiaria = attendanceBeneficiary();

    $this->actingAs($user)
        ->post(route('attendances.store'), [
            'save_as' => 'draft',
            'status' => 'realizado',
            'beneficiary' => $beneficiaria->id,
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('atendimentos', [
        'id_beneficiaria' => $beneficiaria->id,
        'id_categoria_atendimento' => null,
        'id_procedimento' => null,
        'rascunho' => true,
    ]);

    $this->actingAs($user)
        ->post(route('attendances.store'), attendancePayload([
            'status' => 'realizado',
            'attendance_category' => $categoria->id,
            'procedure' => $procedimento->id,
        ]))
        ->assertRedirect();

    $this->assertDatabaseHas('atendimentos', [
        'id_categoria_atendimento' => $categoria->id,
        'id_procedimento' => $procedimento->id,
        'rascunho' => false,
    ]);
});
```

- [ ] **Step 2: Run tests to verify fail**

Run: `php artisan test tests/Feature/AttendanceManagementTest.php --filter="category and procedure"`

Expected: FAIL because request/service do not know fields yet.

- [ ] **Step 3: Update request rules**

In `StoreAttendanceRequest::rules()` add:

```php
'attendance_category' => ['nullable', 'integer', Rule::exists('categorias_atendimento', 'id')->where(fn ($query) => $query->where('ativo', true))],
'procedure' => ['nullable', 'integer', Rule::exists('procedimentos', 'id')->where(fn ($query) => $query->where('ativo', true))],
```

In `withValidator`, inside final realized attendance branch, include fields:

```php
foreach (['summary', 'objective', 'complaint', 'evaluation', 'conduct', 'attendance_category', 'procedure'] as $field) {
    if (! filled($this->input($field))) {
        $errors[$field] = 'Este campo é obrigatório para finalizar o atendimento.';
    }
}
```

Keep draft branch returning before this validation.

In `SaveAttendanceContinuationRequest::rules()` add the same nullable exists rules for `attendance_category` and `procedure`, limited to active records:

```php
'attendance_category' => ['nullable', 'integer', Rule::exists('categorias_atendimento', 'id')->where(fn ($query) => $query->where('ativo', true))],
'procedure' => ['nullable', 'integer', Rule::exists('procedimentos', 'id')->where(fn ($query) => $query->where('ativo', true))],
```

In its finalization branch, require both fields together with clinical fields:

```php
$requiredFields = ['summary', 'objective', 'complaint', 'evaluation', 'conduct', 'attendance_category', 'procedure'];
```

- [ ] **Step 4: Update service persistence**

In `AttendanceService::attendanceAttributes()` add:

```php
'id_categoria_atendimento' => $data['attendance_category'] ?? null,
'id_procedimento' => $data['procedure'] ?? null,
```

In `emptyAttendanceData()` add:

```php
'attendance_category' => '',
'procedure' => '',
```

In `attendanceData()` add:

```php
'attendance_category' => $atendimento->id_categoria_atendimento,
'attendance_category_name' => $atendimento->categoriaAtendimento?->nome ?? '-',
'procedure' => $atendimento->id_procedimento,
'procedure_name' => $atendimento->procedimento?->nome ?? '-',
```

Load relationships in `showData`, `editData`, and `continuationData`. Add form options to `continuationData()`:

```php
return [
    'attendance' => $attendance,
    'attendanceData' => $this->attendanceData($attendance),
    'attendanceCategories' => $this->activeOptionsWithCurrent(CategoriaAtendimento::class, $attendance->id_categoria_atendimento),
    'procedures' => $this->activeOptionsWithCurrent(Procedimento::class, $attendance->id_procedimento),
];
```

In `saveContinuation()`, persist the final category/procedure:

```php
$attendance->update([
    'situacao' => $data['save_as'] === 'final' ? 'realizado' : 'em_atendimento',
    'rascunho' => $data['save_as'] === 'draft',
    'id_categoria_atendimento' => $data['attendance_category'] ?? $attendance->id_categoria_atendimento,
    'id_procedimento' => $data['procedure'] ?? $attendance->id_procedimento,
]);
```

- [ ] **Step 5: Provide active form options**

In `AttendanceService::formOptions()` add:

```php
'attendanceCategories' => $this->selectOptions(CategoriaAtendimento::where('ativo', true)->orderBy('nome')->pluck('nome', 'id')->all()),
'procedures' => $this->selectOptions(Procedimento::where('ativo', true)->orderBy('nome')->pluck('nome', 'id')->all()),
```

For edit mode with inactivated selected items, append current selected item with label `Nome (inativo)` before rendering. Implement helper:

```php
private function activeOptionsWithCurrent(string $modelClass, ?int $currentId): array
{
    $items = $modelClass::query()
        ->where('ativo', true)
        ->orderBy('nome')
        ->get(['id', 'nome', 'ativo']);

    if ($currentId && ! $items->contains('id', $currentId)) {
        $current = $modelClass::find($currentId);
        if ($current) {
            $items->push($current);
        }
    }

    return $items->map(fn ($item) => [
        'value' => $item->id,
        'label' => $item->nome.($item->ativo ? '' : ' (inativo)'),
    ])->values()->all();
}
```

- [ ] **Step 6: Add fields to forms and show**

In `resources/views/pages/attendances/form.blade.php`, near `Local`, add controls:

```php
<div class="flex items-end gap-2">
    <div class="min-w-0 flex-1">
        <x-material.select name="attendance_category" label="População atendida" :options="$attendanceCategories" :selected="old('attendance_category', $attendanceData['attendance_category'])" placeholder="Selecione" />
        @error('attendance_category') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
    </div>
    <button type="button" data-dialog-open="attendance-category-dialog" class="mb-0 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white text-[#ef5b97] shadow-sm transition hover:bg-[#fbf1f3]" aria-label="Gerenciar população atendida" title="Gerenciar população atendida">
        <x-gmdi-add class="h-4 w-4" />
    </button>
</div>
```

Add equivalent `procedure` select and `attendance-procedure-dialog`.

In `continue.blade.php`, before clinical fields, add editable selects for category and procedure so scheduled attendances can be completed with these required values:

```php
<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5">
        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]"><x-lucide-list-checks class="h-5 w-5" /></span>
            <div>
                <h3 class="text-lg font-bold text-[#111827]">Classificação do atendimento</h3>
                <p class="mt-1 text-sm text-[#667085]">Informe população atendida e procedimento realizado.</p>
            </div>
        </div>
    </div>
    <div class="grid gap-5 p-5 md:grid-cols-2">
        <div><x-material.select name="attendance_category" label="População atendida" :options="$attendanceCategories" :selected="old('attendance_category', $attendanceData['attendance_category'])" placeholder="Selecione" />@error('attendance_category') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
        <div><x-material.select name="procedure" label="Procedimento" :options="$procedures" :selected="old('procedure', $attendanceData['procedure'])" placeholder="Selecione" />@error('procedure') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
    </div>
</article>
```

In show overview details, add `População atendida` and `Procedimento`.

- [ ] **Step 7: Run tests to verify pass**

Run: `php artisan test tests/Feature/AttendanceManagementTest.php --filter="category and procedure"`

Expected: PASS.

- [ ] **Step 8: Commit**

```bash
git add app/Http/Requests/Attendances/StoreAttendanceRequest.php app/Http/Requests/Attendances/SaveAttendanceContinuationRequest.php app/Services/AttendanceService.php resources/views/pages/attendances/form.blade.php resources/views/pages/attendances/continue.blade.php resources/views/pages/attendances/show.blade.php tests/Feature/AttendanceManagementTest.php
git commit -m "feat: require attendance category and procedure"
```

---

### Task 3: CRUD em Modal para Procedimentos e Categorias

**Files:**
- Create: `app/Http/Requests/Attendances/StoreProcedureRequest.php`
- Create: `app/Http/Requests/Attendances/UpdateProcedureRequest.php`
- Create: `app/Http/Requests/Attendances/StoreAttendanceCategoryRequest.php`
- Create: `app/Http/Requests/Attendances/UpdateAttendanceCategoryRequest.php`
- Modify: `app/Http/Controllers/AttendanceController.php`
- Modify: `app/Services/AttendanceService.php`
- Modify: `routes/web.php`
- Create: `resources/views/pages/attendances/partials/procedure-modal.blade.php`
- Create: `resources/views/pages/attendances/partials/category-modal.blade.php`
- Modify: `resources/views/pages/attendances/form.blade.php`
- Test: `tests/Feature/AttendanceTaxonomyManagementTest.php`

**Interfaces:**
- Consumes: models from Task 1.
- Produces routes:
  - `attendances.procedures.store`
  - `attendances.procedures.update`
  - `attendances.procedures.toggle`
  - `attendances.categories.store`
  - `attendances.categories.update`
  - `attendances.categories.toggle`

- [ ] **Step 1: Write failing CRUD tests**

Create `tests/Feature/AttendanceTaxonomyManagementTest.php`:

```php
<?php

use App\Models\CategoriaAtendimento;
use App\Models\Procedimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('manages procedures from attendance modal routes', function () {
    $user = User::factory()->enfermeira()->create();

    $this->actingAs($user)
        ->post(route('attendances.procedures.store'), [
            'nome' => 'Laserterapia',
            'descricao' => 'Aplicação conforme protocolo.',
        ])
        ->assertRedirect();

    $procedure = Procedimento::firstOrFail();

    $this->assertDatabaseHas('procedimentos', ['nome' => 'Laserterapia', 'ativo' => true]);

    $this->actingAs($user)
        ->put(route('attendances.procedures.update', $procedure), [
            'nome' => 'Laserterapia mamária',
            'descricao' => 'Descrição atualizada.',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('procedimentos', ['id' => $procedure->id, 'nome' => 'Laserterapia mamária']);

    $this->actingAs($user)
        ->patch(route('attendances.procedures.toggle', $procedure))
        ->assertRedirect();

    expect($procedure->fresh()->ativo)->toBeFalse();
});

it('manages attendance categories from attendance modal routes', function () {
    $user = User::factory()->enfermeira()->create();

    $this->actingAs($user)
        ->post(route('attendances.categories.store'), ['nome' => 'Gestantes'])
        ->assertRedirect();

    $category = CategoriaAtendimento::firstOrFail();

    $this->actingAs($user)
        ->put(route('attendances.categories.update', $category), [
            'nome' => 'Gestantes de alto risco',
            'descricao' => 'Grupo prioritário.',
        ])
        ->assertRedirect();

    $this->actingAs($user)
        ->patch(route('attendances.categories.toggle', $category))
        ->assertRedirect();

    expect($category->fresh()->ativo)->toBeFalse();
});
```

- [ ] **Step 2: Run tests to verify fail**

Run: `php artisan test tests/Feature/AttendanceTaxonomyManagementTest.php`

Expected: FAIL because routes/requests/actions missing.

- [ ] **Step 3: Create requests**

`StoreProcedureRequest`:

```php
<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProcedureRequest extends FormRequest
{
    protected $errorBag = 'procedure';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255', Rule::unique('procedimentos', 'nome')->ignore($this->route('procedure'))],
            'descricao' => ['nullable', 'string'],
        ];
    }
}
```

`UpdateProcedureRequest extends StoreProcedureRequest`.

Create `StoreAttendanceCategoryRequest` with table `categorias_atendimento`, error bag `attendanceCategory`, and `UpdateAttendanceCategoryRequest extends StoreAttendanceCategoryRequest`.

- [ ] **Step 4: Add service methods**

In `AttendanceService`:

```php
public function storeProcedure(array $data): Procedimento
{
    return Procedimento::create([...$data, 'ativo' => true]);
}

public function updateProcedure(Procedimento $procedure, array $data): void
{
    $procedure->update($data);
}

public function toggleProcedure(Procedimento $procedure): void
{
    $procedure->update(['ativo' => ! $procedure->ativo]);
}
```

Add equivalent methods for `CategoriaAtendimento`.

- [ ] **Step 5: Add controller actions and routes**

In `AttendanceController`, import models/requests and add:

```php
public function storeProcedure(StoreProcedureRequest $request): RedirectResponse
{
    $this->attendances->storeProcedure($request->validated());
    return back()->with('status', 'Procedimento criado com sucesso.');
}
```

Add update/toggle and category equivalents.

In `routes/web.php` inside attendance group:

```php
Route::post('/atendimentos/procedimentos', [AttendanceController::class, 'storeProcedure'])->name('attendances.procedures.store');
Route::put('/atendimentos/procedimentos/{procedure}', [AttendanceController::class, 'updateProcedure'])->name('attendances.procedures.update');
Route::patch('/atendimentos/procedimentos/{procedure}/alternar', [AttendanceController::class, 'toggleProcedure'])->name('attendances.procedures.toggle');
Route::post('/atendimentos/categorias', [AttendanceController::class, 'storeCategory'])->name('attendances.categories.store');
Route::put('/atendimentos/categorias/{category}', [AttendanceController::class, 'updateCategory'])->name('attendances.categories.update');
Route::patch('/atendimentos/categorias/{category}/alternar', [AttendanceController::class, 'toggleCategory'])->name('attendances.categories.toggle');
```

- [ ] **Step 6: Add modal data to form options**

In `AttendanceService::formOptions()` include full lists:

```php
'allProcedures' => Procedimento::orderBy('nome')->get(),
'allAttendanceCategories' => CategoriaAtendimento::orderBy('nome')->get(),
```

- [ ] **Step 7: Create modal partials**

Create `procedure-modal.blade.php` using existing `dialog` style. Include:

```php
<dialog id="attendance-procedure-dialog" data-dialog-modal class="m-auto w-[calc(100%-2rem)] max-w-3xl rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45">
    <div class="p-5 sm:p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-[#111827]">Gerenciar procedimentos</h2>
                <p class="mt-1 text-sm text-[#667085]">Cadastre, edite ou inative procedimentos.</p>
            </div>
            <button type="button" data-dialog-close class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#667085] hover:bg-[#f7edef]" aria-label="Fechar">
                <x-gmdi-close-o class="h-5 w-5" />
            </button>
        </div>

        <form action="{{ route('attendances.procedures.store') }}" method="POST" class="mt-5 grid gap-3 md:grid-cols-[1fr_1fr_auto]">
            @csrf
            <input name="nome" class="{{ $inputClass }}" placeholder="Nome do procedimento" required>
            <input name="descricao" class="{{ $inputClass }}" placeholder="Descrição opcional">
            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#ef5b97] px-4 text-sm font-semibold text-white">Cadastrar</button>
        </form>

        <div class="mt-6 space-y-3">
            @foreach ($allProcedures as $procedure)
                <form action="{{ route('attendances.procedures.update', $procedure) }}" method="POST" class="grid gap-3 rounded-lg border border-[#f0e7e8] p-3 md:grid-cols-[1fr_1fr_auto_auto]">
                    @csrf
                    @method('PUT')
                    <input name="nome" value="{{ $procedure->nome }}" class="{{ $inputClass }}" required>
                    <input name="descricao" value="{{ $procedure->descricao }}" class="{{ $inputClass }}">
                    <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#e4d8d9] px-4 text-sm font-semibold">Salvar</button>
                    <button form="procedure-toggle-{{ $procedure->id }}" type="submit" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#e4d8d9] px-4 text-sm font-semibold">
                        {{ $procedure->ativo ? 'Inativar' : 'Reativar' }}
                    </button>
                </form>
                <form id="procedure-toggle-{{ $procedure->id }}" action="{{ route('attendances.procedures.toggle', $procedure) }}" method="POST" class="hidden">@csrf @method('PATCH')</form>
            @endforeach
        </div>
    </div>
</dialog>
```

Create category modal with route names and `$allAttendanceCategories`.

- [ ] **Step 8: Include modals and auto-open on validation errors**

In `form.blade.php`, after form:

```php
@include('pages.attendances.partials.procedure-modal')
@include('pages.attendances.partials.category-modal')

@if ($errors->procedure->any())
    <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('attendance-procedure-dialog')?.showModal());</script>
@endif
@if ($errors->attendanceCategory->any())
    <script>document.addEventListener('DOMContentLoaded', () => document.getElementById('attendance-category-dialog')?.showModal());</script>
@endif
```

- [ ] **Step 9: Run tests to verify pass**

Run: `php artisan test tests/Feature/AttendanceTaxonomyManagementTest.php`

Expected: PASS.

- [ ] **Step 10: Commit**

```bash
git add app/Http/Requests/Attendances app/Http/Controllers/AttendanceController.php app/Services/AttendanceService.php routes/web.php resources/views/pages/attendances tests/Feature/AttendanceTaxonomyManagementTest.php
git commit -m "feat: manage attendance procedures and categories"
```

---

### Task 4: Local de Atendimento com Endereco Opcional

**Files:**
- Modify: `app/Http/Requests/Attendances/StoreLocationRequest.php`
- Modify: `app/Services/AttendanceService.php`
- Modify: `app/Http/Controllers/AttendanceController.php`
- Modify: `routes/web.php`
- Modify: `resources/views/pages/attendances/partials/location-modal.blade.php`
- Modify: `resources/views/pages/attendances/index.blade.php`
- Test: `tests/Feature/AttendanceManagementTest.php`

**Interfaces:**
- Consumes: existing `Cep` and `Endereco` models.
- Produces routes:
  - `attendances.locations.update`
  - `attendances.locations.toggle`
- Produces service methods `storeLocation(array $data): LocalAtendimento`, `updateLocation(LocalAtendimento $location, array $data): void`, `toggleLocation(LocalAtendimento $location): void`.

- [ ] **Step 1: Write failing tests for location address and active toggle**

Add to `tests/Feature/AttendanceManagementTest.php`:

```php
it('stores attendance location with optional address', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)
        ->post(route('attendances.locations.store'), [
            'nome' => 'UBS Centro',
            'descricao' => 'Sala de apoio',
            'cep' => '88350000',
            'logradouro' => 'Rua Central',
            'numero' => '100',
            'bairro' => 'Centro',
            'cidade' => 'Brusque',
            'uf' => 'SC',
        ])
        ->assertRedirect();

    $location = LocalAtendimento::with('endereco.cep')->where('nome', 'UBS Centro')->firstOrFail();

    expect($location->endereco->numero)->toBe('100')
        ->and($location->endereco->cep->cidade)->toBe('Brusque')
        ->and($location->endereco->cep->uf)->toBe('SC');
});

it('updates and toggles attendance locations', function () {
    $user = User::factory()->administrador()->create();
    $location = LocalAtendimento::create(['nome' => 'Antigo local', 'ativo' => true]);

    $this->actingAs($user)
        ->put(route('attendances.locations.update', $location), [
            'nome' => 'Local atualizado',
            'descricao' => 'Nova descrição',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('locais_atendimento', ['id' => $location->id, 'nome' => 'Local atualizado']);

    $this->actingAs($user)
        ->patch(route('attendances.locations.toggle', $location))
        ->assertRedirect();

    expect($location->fresh()->ativo)->toBeFalse();
});
```

- [ ] **Step 2: Run tests to verify fail**

Run: `php artisan test tests/Feature/AttendanceManagementTest.php --filter="attendance location"`

Expected: FAIL because validation/persistence/routes are missing.

- [ ] **Step 3: Update `StoreLocationRequest`**

Add `prepareForValidation` and address-started rules equivalent to beneficiary request:

```php
protected function prepareForValidation(): void
{
    $this->merge([
        'cep' => preg_replace('/\D/', '', (string) $this->input('cep')) ?: null,
    ]);
}
```

Rules:

```php
$addressStarted = collect(['cep', 'logradouro', 'bairro', 'cidade', 'uf', 'numero', 'complemento'])
    ->contains(fn (string $field) => filled($this->input($field)));

return [
    'nome' => ['required', 'string', 'max:255', Rule::unique('locais_atendimento', 'nome')->ignore($this->route('location'))],
    'descricao' => ['nullable', 'string'],
    'cep' => [Rule::requiredIf($addressStarted), 'nullable', 'string', 'regex:/^\d{8}$/'],
    'logradouro' => ['nullable', 'string', 'max:255'],
    'bairro' => ['nullable', 'string', 'max:255'],
    'cidade' => [Rule::requiredIf($addressStarted), 'nullable', 'string', 'max:255'],
    'uf' => [Rule::requiredIf($addressStarted), 'nullable', Rule::in(array_keys(StoreBeneficiaryRequest::states()))],
    'numero' => ['nullable', 'string', 'max:255'],
    'complemento' => ['nullable', 'string', 'max:255'],
];
```

- [ ] **Step 4: Extract or duplicate address persistence in service**

In `AttendanceService`, import `Cep`, `Endereco`, `LocalAtendimento`.

Add:

```php
private function persistAddress(array $data, ?Endereco $address = null): ?int
{
    $addressFields = ['cep', 'logradouro', 'bairro', 'cidade', 'uf', 'numero', 'complemento'];
    $hasAddress = collect($addressFields)->contains(fn (string $field) => filled($data[$field] ?? null));

    if (! $hasAddress) {
        return null;
    }

    $cep = $address?->cep ?? new Cep();
    $cep->fill([
        'cep' => (int) $data['cep'],
        'cidade' => $data['cidade'],
        'uf' => $data['uf'],
        'bairro' => $data['bairro'] ?? null,
        'logradouro' => $data['logradouro'] ?? null,
    ])->save();

    $address ??= new Endereco();
    $address->fill([
        'id_cep' => $cep->id,
        'numero' => $data['numero'] ?? null,
        'complemento' => $data['complemento'] ?? null,
    ])->save();

    return $address->id;
}
```

Update `storeLocation`:

```php
public function storeLocation(array $data): LocalAtendimento
{
    return DB::transaction(function () use ($data) {
        return LocalAtendimento::create([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'] ?? null,
            'id_endereco' => $this->persistAddress($data),
            'ativo' => true,
        ]);
    });
}
```

Add update/toggle methods.

- [ ] **Step 5: Add routes and controller actions**

Routes:

```php
Route::put('/atendimentos/locais/{location}', [AttendanceController::class, 'updateLocation'])->name('attendances.locations.update');
Route::patch('/atendimentos/locais/{location}/alternar', [AttendanceController::class, 'toggleLocation'])->name('attendances.locations.toggle');
```

Controller:

```php
public function updateLocation(StoreLocationRequest $request, LocalAtendimento $location): RedirectResponse
{
    $this->attendances->updateLocation($location, $request->validated());
    return back()->with('status', 'Local de atendimento atualizado com sucesso.');
}

public function toggleLocation(LocalAtendimento $location): RedirectResponse
{
    $this->attendances->toggleLocation($location);
    return back()->with('status', $location->fresh()->ativo ? 'Local reativado com sucesso.' : 'Local inativado com sucesso.');
}
```

- [ ] **Step 6: Update modal view**

In `location-modal.blade.php`, add address fields to create form:

```php
<label class="block md:col-span-2">
    <span class="text-sm font-semibold text-[#344054]">CEP</span>
    <input type="text" name="cep" value="{{ old('cep') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="00000-000" inputmode="numeric" data-mask="cep" data-cep-input>
    <span data-cep-feedback class="mt-1 block text-xs text-[#667085]"></span>
    @error('cep', 'location') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
</label>
```

Add `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `uf` with names matching Viacep script.

Below creation form, list `$allLocations` with edit forms and toggle button, matching modal pattern from Task 3.

- [ ] **Step 7: Provide all locations to views**

In `AttendanceService::indexData()` and `formOptions()`, include:

```php
'allLocations' => LocalAtendimento::with('endereco.cep')->orderBy('nome')->get(),
```

Change active select options:

```php
'locations' => $this->selectOptions(LocalAtendimento::where('ativo', true)->orderBy('nome')->pluck('nome', 'id')->all()),
```

- [ ] **Step 8: Run tests to verify pass**

Run: `php artisan test tests/Feature/AttendanceManagementTest.php --filter="attendance location"`

Expected: PASS.

- [ ] **Step 9: Commit**

```bash
git add app/Http/Requests/Attendances/StoreLocationRequest.php app/Services/AttendanceService.php app/Http/Controllers/AttendanceController.php routes/web.php resources/views/pages/attendances/partials/location-modal.blade.php resources/views/pages/attendances/index.blade.php tests/Feature/AttendanceManagementTest.php
git commit -m "feat: add addresses to attendance locations"
```

---

### Task 5: Relatorio XLSX - Rota, Botao e Download Base

**Files:**
- Create: `app/Services/ActivityReportExportService.php`
- Modify: `app/Http/Controllers/ReportController.php`
- Modify: `routes/web.php`
- Modify: `resources/views/pages/reports/index.blade.php`
- Test: `tests/Feature/ReportsPageTest.php`

**Interfaces:**
- Produces: `ActivityReportExportService::download(array $filters): Symfony\Component\HttpFoundation\StreamedResponse`.
- Produces: route `reports.export`.

- [ ] **Step 1: Write failing button and download tests**

Add to `tests/Feature/ReportsPageTest.php`:

```php
it('shows activity report export button with current filters', function () {
    $user = User::factory()->administrador()->create();

    $this->actingAs($user)
        ->get(route('reports.index', [
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'location' => 'all',
        ]))
        ->assertOk()
        ->assertSee('Gerar Relatório de Atividades')
        ->assertSee(route('reports.export', [
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'section' => 'all',
            'location' => 'all',
        ]), false);
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
```

- [ ] **Step 2: Run tests to verify fail**

Run: `php artisan test tests/Feature/ReportsPageTest.php --filter="activity report export|downloads an xlsx"`

Expected: FAIL because route/export missing and old button text remains.

- [ ] **Step 3: Add service skeleton**

Create `ActivityReportExportService`:

```php
<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityReportExportService
{
    public function download(array $filters): StreamedResponse
    {
        $start = Carbon::parse($filters['start_date'])->startOfDay();
        $end = Carbon::parse($filters['end_date'])->endOfDay();
        $spreadsheet = $this->spreadsheet($start, $end, $filters);
        $filename = sprintf('relatorio-de-atividades-%s-a-%s.xlsx', $start->toDateString(), $end->toDateString());

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function spreadsheet(Carbon $start, Carbon $end, array $filters): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Relatorio');
        $sheet->setCellValue('A1', 'INSTITUTO CATARINENSE ANJOS DO PEITO - RELATORIO DE ATIVIDADES');
        $sheet->setCellValue('A2', 'Periodo: '.$start->format('d/m/Y').' a '.$end->format('d/m/Y'));
        $sheet->fromArray([['Descricao', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez', 'Total']], null, 'A4');

        return $spreadsheet;
    }
}
```

- [ ] **Step 4: Wire controller and route**

In `ReportController`:

```php
use App\Services\ActivityReportExportService;
use Symfony\Component\HttpFoundation\StreamedResponse;

public function __construct(
    private readonly ReportService $reports,
    private readonly ActivityReportExportService $activityReportExport,
) {}

public function export(ReportFilterRequest $request): StreamedResponse
{
    return $this->activityReportExport->download($request->filters());
}
```

In `routes/web.php` before `/relatorios` index:

```php
Route::get('/relatorios/exportar', [ReportController::class, 'export'])->name('reports.export');
```

- [ ] **Step 5: Update report button**

In `resources/views/pages/reports/index.blade.php`, change page-info button:

```php
:firstButton="[
    'label' => 'Gerar Relatório de Atividades',
    'link' => route('reports.export', [
        'start_date' => $startDate,
        'end_date' => $endDate,
        'section' => $section,
        'location' => $location,
    ]),
    'icon' => 'download',
]"
```

- [ ] **Step 6: Run tests to verify pass**

Run: `php artisan test tests/Feature/ReportsPageTest.php --filter="activity report export|downloads an xlsx"`

Expected: PASS.

- [ ] **Step 7: Commit**

```bash
git add app/Services/ActivityReportExportService.php app/Http/Controllers/ReportController.php routes/web.php resources/views/pages/reports/index.blade.php tests/Feature/ReportsPageTest.php composer.json composer.lock
git commit -m "feat: add activity report xlsx export"
```

---

### Task 6: Relatorio XLSX - Agregacoes e Formato Final

**Files:**
- Modify: `app/Services/ActivityReportExportService.php`
- Modify: `tests/Feature/ReportsPageTest.php`

**Interfaces:**
- Consumes: `Atendimento` relationships `categoriaAtendimento`, `procedimento`, `local`, `beneficiaria.endereco.cep`.
- Produces internal methods:
  - `private function rowsForGroup(Collection $attendances, string $label, callable $resolver): array`
  - `private function monthBuckets(): array`
  - `private function writeBlock(Worksheet $sheet, int $row, string $title, array $rows, string $totalLabel): int`

- [ ] **Step 1: Write failing aggregation test**

Add to `tests/Feature/ReportsPageTest.php`:

```php
use App\Models\CategoriaAtendimento;
use App\Models\Cep;
use App\Models\Endereco;
use App\Models\LocalAtendimento;
use App\Models\Procedimento;
use PhpOffice\PhpSpreadsheet\IOFactory;

it('exports activity report aggregations by category procedure location time and city', function () {
    $user = User::factory()->administrador()->create();
    $cep = Cep::create(['cep' => 88350000, 'cidade' => 'Brusque', 'uf' => 'SC', 'bairro' => 'Centro', 'logradouro' => 'Rua Central']);
    $endereco = Endereco::create(['id_cep' => $cep->id, 'numero' => '100']);
    $beneficiary = reportBeneficiary(['id_endereco' => $endereco->id]);
    $category = CategoriaAtendimento::create(['nome' => 'Gestantes', 'ativo' => true]);
    $procedure = Procedimento::create(['nome' => 'Laserterapia', 'ativo' => true]);
    $location = LocalAtendimento::create(['nome' => 'Sede do ICAP', 'ativo' => true]);

    Atendimento::create([
        'data_hora' => '2026-01-10 18:30:00',
        'modalidade' => 'presencial',
        'id_local' => $location->id,
        'situacao' => 'realizado',
        'rascunho' => false,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario' => $user->id,
        'id_categoria_atendimento' => $category->id,
        'id_procedimento' => $procedure->id,
    ]);

    Atendimento::create([
        'data_hora' => '2026-02-07 09:00:00',
        'modalidade' => 'presencial',
        'id_local' => $location->id,
        'situacao' => 'realizado',
        'rascunho' => false,
        'id_beneficiaria' => $beneficiary->id,
        'id_usuario' => $user->id,
        'id_categoria_atendimento' => $category->id,
        'id_procedimento' => $procedure->id,
    ]);

    $response = $this->actingAs($user)->get(route('reports.export', [
        'start_date' => '2026-01-01',
        'end_date' => '2026-02-28',
    ]));

    $path = tempnam(sys_get_temp_dir(), 'activity-report').'.xlsx';
    file_put_contents($path, $response->streamedContent());
    $sheet = IOFactory::load($path)->getActiveSheet();

    expect($sheet->getCell('A1')->getValue())->toContain('RELATORIO DE ATIVIDADES');

    assertActivityRows($sheet, [
        ['GESTANTES', 1, 1, 2],
        ['LASERTERAPIA', 1, 1, 2],
        ['SEDE DO ICAP', 1, 1, 2],
        ['APOS 18 HORAS E FINS DE SEMANA', 1, 1, 2],
        ['BRUSQUE', 1, 1, 2],
    ]);
});
```

Add helper in same file:

```php
function assertActivityRows($sheet, array $expectations): void
{
    $rows = $sheet->rangeToArray('A1:O100');

    foreach ($expectations as [$label, $jan, $fev, $total]) {
        $match = collect($rows)->first(fn ($row) => mb_strtoupper(trim((string) $row[0])) === $label);

        expect($match)->not->toBeNull("Missing row {$label}");
        expect((int) $match[1])->toBe($jan);
        expect((int) $match[2])->toBe($fev);
        expect((int) $match[13])->toBe($total);
    }
}
```

If `streamedContent()` is unavailable in the installed test response version, use:

```php
ob_start();
$response->sendContent();
$contents = ob_get_clean();
file_put_contents($path, $contents);
```

- [ ] **Step 2: Run test to verify fail**

Run: `php artisan test tests/Feature/ReportsPageTest.php --filter="exports activity report aggregations"`

Expected: FAIL because workbook only has skeleton.

- [ ] **Step 3: Load filtered attendances**

In `ActivityReportExportService`:

```php
private function attendances(Carbon $start, Carbon $end, array $filters): Collection
{
    return Atendimento::query()
        ->with(['categoriaAtendimento', 'procedimento', 'local', 'beneficiaria.endereco.cep'])
        ->where('situacao', 'realizado')
        ->where('rascunho', false)
        ->whereBetween('data_hora', [$start, $end])
        ->when(($filters['location'] ?? 'all') === 'remote', fn ($query) => $query->where('modalidade', 'remota'))
        ->when(is_numeric($filters['location'] ?? null), fn ($query) => $query->where('id_local', (int) $filters['location']))
        ->get();
}
```

- [ ] **Step 4: Build month buckets**

```php
private function emptyMonths(): array
{
    return array_fill(1, 12, 0);
}

private function groupedRows(Collection $attendances, callable $labelResolver): array
{
    return $attendances
        ->groupBy(fn (Atendimento $attendance) => $labelResolver($attendance))
        ->sortKeys()
        ->map(function (Collection $items, string $label) {
            $months = $this->emptyMonths();

            foreach ($items as $attendance) {
                $months[(int) $attendance->data_hora->month]++;
            }

            return [
                'label' => mb_strtoupper($label),
                'months' => $months,
                'total' => array_sum($months),
            ];
        })
        ->values()
        ->all();
}
```

Label resolvers:

```php
fn (Atendimento $attendance) => $attendance->categoriaAtendimento?->nome ?? 'Sem populacao informada'
fn (Atendimento $attendance) => $attendance->procedimento?->nome ?? 'Sem procedimento informado'
fn (Atendimento $attendance) => $attendance->local?->nome ?? 'Sem local informado'
fn (Atendimento $attendance) => $attendance->beneficiaria?->endereco?->cep?->cidade ?? 'Sem municipio informado'
```

- [ ] **Step 5: Build after-hours/weekend row**

```php
private function afterHoursRows(Collection $attendances): array
{
    $months = $this->emptyMonths();

    foreach ($attendances as $attendance) {
        if ((int) $attendance->data_hora->format('H') >= 18 || $attendance->data_hora->isWeekend()) {
            $months[(int) $attendance->data_hora->month]++;
        }
    }

    return [[
        'label' => 'APOS 18 HORAS E FINS DE SEMANA',
        'months' => $months,
        'total' => array_sum($months),
    ]];
}
```

- [ ] **Step 6: Write workbook blocks**

Use `PhpOffice\PhpSpreadsheet\Worksheet\Worksheet`.

```php
private function writeHeader(Worksheet $sheet, Carbon $start, Carbon $end): void
{
    $sheet->mergeCells('A1:O1');
    $sheet->setCellValue('A1', 'INSTITUTO CATARINENSE ANJOS DO PEITO - RELATORIO DE ATIVIDADES');
    $sheet->mergeCells('A2:O2');
    $sheet->setCellValue('A2', 'Periodo: '.$start->format('d/m/Y').' a '.$end->format('d/m/Y'));
    $sheet->fromArray([['ATENDIMENTO GERAL', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez', 'Total']], null, 'A4');
}

private function writeBlock(Worksheet $sheet, int $row, string $title, array $rows, string $totalLabel): int
{
    $startRow = $row;

    foreach ($rows as $index => $data) {
        $sheet->setCellValue('A'.$row, $index === 0 ? $title : '');
        $sheet->setCellValue('B'.$row, $data['label']);
        $sheet->fromArray([array_values($data['months'])], null, 'C'.$row);
        $sheet->setCellValue('O'.$row, $data['total']);
        $row++;
    }

    if ($row > $startRow) {
        $sheet->mergeCells("A{$startRow}:A".($row - 1));
    }

    $months = $this->emptyMonths();
    foreach ($rows as $data) {
        foreach ($data['months'] as $month => $value) {
            $months[$month] += $value;
        }
    }

    $sheet->setCellValue('B'.$row, $totalLabel);
    $sheet->fromArray([array_values($months)], null, 'C'.$row);
    $sheet->setCellValue('O'.$row, array_sum($months));

    return $row + 2;
}
```

Call:

```php
$attendances = $this->attendances($start, $end, $filters);
$row = 6;
$row = $this->writeBlock($sheet, $row, 'POPULACAO ATENDIDA', $this->groupedRows($attendances, fn (Atendimento $attendance) => $attendance->categoriaAtendimento?->nome ?? 'Sem populacao informada'), 'TOTAL DE ATENDIMENTOS');
$row = $this->writeBlock($sheet, $row, 'PROCEDIMENTOS', $this->groupedRows($attendances, fn (Atendimento $attendance) => $attendance->procedimento?->nome ?? 'Sem procedimento informado'), 'TOTAL DE PROCEDIMENTOS');
$row = $this->writeBlock($sheet, $row, 'LOCAL DE ATENDIMENTO', $this->groupedRows($attendances, fn (Atendimento $attendance) => $attendance->local?->nome ?? 'Sem local informado'), 'TOTAL DE ATENDIMENTOS');
$row = $this->writeBlock($sheet, $row, '', $this->afterHoursRows($attendances), '');
$row = $this->writeBlock($sheet, $row, 'MUNICIPIOS', $this->groupedRows($attendances, fn (Atendimento $attendance) => $attendance->beneficiaria?->endereco?->cep?->cidade ?? 'Sem municipio informado'), 'TOTAL GERAL');
```

- [ ] **Step 7: Apply formatting**

Add imports:

```php
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
```

Format:

```php
$sheet->getStyle('A1:O1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BF2F63']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);
$sheet->getStyle('A4:O4')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '111827']],
]);
$sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'EADFE0']]],
]);
$sheet->freezePane('C5');
$sheet->getColumnDimension('A')->setWidth(24);
$sheet->getColumnDimension('B')->setWidth(48);
foreach (range('C', 'O') as $column) {
    $sheet->getColumnDimension($column)->setWidth(10);
}
```

Style total rows by checking labels starting with `TOTAL`.

- [ ] **Step 8: Run aggregation test**

Run: `php artisan test tests/Feature/ReportsPageTest.php --filter="exports activity report aggregations"`

Expected: PASS.

- [ ] **Step 9: Run report tests**

Run: `php artisan test tests/Feature/ReportsPageTest.php`

Expected: PASS.

- [ ] **Step 10: Commit**

```bash
git add app/Services/ActivityReportExportService.php tests/Feature/ReportsPageTest.php
git commit -m "feat: aggregate activity report workbook"
```

---

### Task 7: Full Verification and Polish

**Files:**
- Modify: only files requiring fixes found by tests or format.
- Test: full suite.

**Interfaces:**
- Consumes: Tasks 1-6.
- Produces: finished branch with tests passing and no unintended files staged.

- [ ] **Step 1: Run targeted tests**

Run:

```bash
php artisan test tests/Feature/AttendanceManagementTest.php tests/Feature/AttendanceTaxonomyManagementTest.php tests/Feature/ReportsPageTest.php
```

Expected: PASS.

- [ ] **Step 2: Run full test suite**

Run:

```bash
composer test
```

Expected: PASS.

- [ ] **Step 3: Run formatter**

Run:

```bash
vendor/bin/pint --dirty
```

Expected: no formatting failures. If Pint changes files, rerun targeted tests.

- [ ] **Step 4: Run asset build**

Run:

```bash
npm run build
```

Expected: build completes successfully.

- [ ] **Step 5: Manual browser smoke test**

Run app with existing project workflow, then verify:

```bash
php artisan serve
npm run dev
```

Check in browser:

- `/atendimentos/novo` shows `População atendida` and `Procedimento`.
- Procedure/category modal can create, edit, inactivate, reactivate.
- Location modal has address fields and Viacep fills address after CEP blur.
- `/relatorios` shows `Gerar Relatório de Atividades`.
- Clicking export downloads `.xlsx`.

- [ ] **Step 6: Inspect git state**

Run:

```bash
git status --short
```

Expected: only intended tracked changes remain; `docs/RELATÓRIO de Atividades ICAP 2024.xlsx` may remain untracked as user/reference file and must not be removed.

- [ ] **Step 7: Commit final polish if needed**

If formatter or smoke fixes changed files:

```bash
git add <changed-files>
git commit -m "fix: polish activity report workflow"
```

If no changes:

```bash
git status --short
```

Expected: no implementation changes to commit.

---

## Self-Review

- Spec coverage: schema, atendimento validation, CRUD modals, local address, XLSX export, aggregations, filters, inactive records, seeds, tests, and verification are covered by Tasks 1-7.
- Placeholder scan: no `TBD`, `TODO`, `implement later`, or open-ended test steps.
- Type consistency: `id_categoria_atendimento`, `id_procedimento`, request inputs `attendance_category` and `procedure`, route names, and service names are consistent across tasks.
