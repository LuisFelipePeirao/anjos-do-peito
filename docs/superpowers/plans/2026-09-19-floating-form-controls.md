# Floating Form Controls Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Padronizar controles CRUD Blade com labels flutuantes.

**Architecture:** Reutilizar `x-material.floating-input` e `x-material.select`; criar `x-material.floating-textarea`. Migrar Blade por domínio, preservando atributos, erros e JavaScript existente.

**Tech Stack:** Laravel 13, Blade, Pest 5, Tailwind CSS 4, Material Web.

**Spec:** `docs/superpowers/specs/2026-09-19-floating-form-controls-design.md`

## Global Constraints

- Não alterar login, senha, filtros/relatórios, hidden, rádio ou checkbox.
- Preservar `name`, `old()`, valores editáveis, `data-*`, máscaras, limites e `disabled`.
- Campos HTML `required` usam prop `required` e asterisco vermelho.
- Named error bags permanecem externos.
- Não alterar rotas, payloads, validação ou JavaScript de negócio.

## Review Focus

- Textarea preenchido eleva label sem esconder conteúdo; testar Task 1.
- Required mantém atributo e asterisco; testar Tasks 1-5.
- CPF, telefone e CEP preservam máscaras; testar Task 2.
- Cobrança preserva `disabled` e `data-pump-billing-field`; testar Task 3.
- Modais com named bag mostram erro correto; testar Tasks 4-5.

---

### Task 1: Componente Floating Textarea

**Files:**
- Create: `resources/views/components/material/floating-textarea.blade.php`
- Create: `tests/Feature/MaterialFloatingTextareaTest.php`

**Interfaces:**
- Produces: `<x-material.floating-textarea name label value placeholder required wrapper-class ... />`.
- Consumes: visual, erro e props do `floating-input.blade.php`.

- [ ] **Step 1: Escrever teste falho**

```php
$html = Blade::render('<x-material.floating-textarea name="notes" label="Observações" value="Texto" required />');
expect($html)->toContain('name="notes"')->toContain('peer-focus:-top-2.5')
    ->toContain('peer-not-placeholder-shown:-top-2.5')->toContain('required');
```

- [ ] **Step 2: Rodar teste vermelho**

Run: `php artisan test tests/Feature/MaterialFloatingTextareaTest.php`
Expected: FAIL; componente não existe.

- [ ] **Step 3: Criar implementação mínima**

Criar wrapper relativo, `textarea.peer` com `placeholder=" "`, label elevado por `peer-focus` e `peer-not-placeholder-shown`, asterisco `ml-0.5 text-[#c2414b]`, `@error($name)`, e forwarding de atributos/classes. Manter `min-h-28`, padding e resize atuais.

- [ ] **Step 4: Rodar teste verde**

Run: `php artisan test tests/Feature/MaterialFloatingTextareaTest.php`
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add resources/views/components/material/floating-textarea.blade.php tests/Feature/MaterialFloatingTextareaTest.php
git commit -m "feat: add floating textarea component"
```

### Task 2: Beneficiárias e usuários

**Files:**
- Modify: `resources/views/pages/beneficiaries/partials/form.blade.php`
- Modify: `resources/views/pages/beneficiaries/partials/child-modal.blade.php`
- Modify: `resources/views/pages/users/partials/form.blade.php`
- Test: `tests/Feature/BeneficiaryManagementTest.php`
- Test: `tests/Feature/Admin/UserManagementTest.php`

**Interfaces:** Usa três controles material; produz CRUD de beneficiária/usuário padronizado.

- [ ] **Step 1: Escrever testes falhos** para nome de edição, CPF com `data-mask="cpf"`, criança required e senha ainda nativa.
- [ ] **Step 2: Rodar** `php artisan test tests/Feature/BeneficiaryManagementTest.php tests/Feature/Admin/UserManagementTest.php`; expected FAIL.
- [ ] **Step 3: Migrar** nome de edição, modal criança (`nome`, `data_nascimento`, `sexo`) e campos de usuário; manter `old()`, wrappers, máscaras, selects e erros externos.
- [ ] **Step 4: Rodar testes**; expected PASS.
- [ ] **Step 5: Commit** `git add resources/views/pages/beneficiaries resources/views/pages/users tests/Feature/BeneficiaryManagementTest.php tests/Feature/Admin/UserManagementTest.php && git commit -m "feat: standardize beneficiary and user forms"`.

### Task 3: Bombas e empréstimos

**Files:**
- Modify: `resources/views/pages/pumps/partials/form.blade.php`
- Modify: `resources/views/pages/pumps/loans/create.blade.php`
- Test: `tests/Feature/PumpManagementTest.php`
- Test: `tests/Feature/PumpLoanManagementTest.php`

**Interfaces:** Usa três controles e preserva `data-pump-billing-field`.

- [ ] **Step 1: Escrever testes falhos** para código required, acessórios textarea e cobrança desabilitada.
- [ ] **Step 2: Rodar** `php artisan test tests/Feature/PumpManagementTest.php tests/Feature/PumpLoanManagementTest.php`; expected FAIL.
- [ ] **Step 3: Migrar** código, série, aquisição, acessórios, campos de empréstimo e renovação; remover placeholders de select, manter datas, limites, `disabled` e required.
- [ ] **Step 4: Rodar testes**; expected PASS.
- [ ] **Step 5: Commit** `git add resources/views/pages/pumps tests/Feature/PumpManagementTest.php tests/Feature/PumpLoanManagementTest.php && git commit -m "feat: standardize pump forms"`.

### Task 4: Estoque, doadores e distribuições

**Files:**
- Modify: `resources/views/pages/donations/materials/create.blade.php`
- Modify: `resources/views/pages/donations/partials/donor-modal.blade.php`
- Modify: `resources/views/pages/donations/distributions/create.blade.php`
- Test: `tests/Feature/DonationStockManagementTest.php`

**Interfaces:** Usa três controles; erros `donor` continuam externos.

- [ ] **Step 1: Escrever teste falho** para material required, textarea de doador e item Blade de distribuição.
- [ ] **Step 2: Rodar** `php artisan test tests/Feature/DonationStockManagementTest.php`; expected FAIL.
- [ ] **Step 3: Migrar** material, doador, cabeçalhos e linhas Blade de distribuição. Não alterar HTML criado exclusivamente por JavaScript.
- [ ] **Step 4: Rodar teste**; expected PASS.
- [ ] **Step 5: Commit** `git add resources/views/pages/donations tests/Feature/DonationStockManagementTest.php && git commit -m "feat: standardize donation forms"`.

### Task 5: Atendimentos e modais compartilhados

**Files:**
- Modify: `resources/views/pages/attendances/form.blade.php`
- Modify: `resources/views/pages/attendances/continue.blade.php`
- Modify: `resources/views/pages/attendances/partials/clinical-fields.blade.php`
- Modify: `resources/views/pages/attendances/partials/location-modal.blade.php`
- Modify: `resources/views/components/app/entity-manager-modal.blade.php`
- Test: `tests/Feature/AttendanceManagementTest.php`
- Test: `tests/Feature/AttendanceTaxonomyManagementTest.php`

**Interfaces:** Usa três controles; preserva `data-attendance-*`, status hidden e named bags.

- [ ] **Step 1: Escrever testes falhos** para data/hora, resumo, textarea clínico, beneficiária required e modal taxonômico.
- [ ] **Step 2: Rodar** `php artisan test tests/Feature/AttendanceManagementTest.php tests/Feature/AttendanceTaxonomyManagementTest.php`; expected FAIL.
- [ ] **Step 3: Migrar** data, hora, resumo, textareas clínicos, modal local e Entity Manager; manter status hidden, CEP, seletores, selects desabilitados e named bags.
- [ ] **Step 4: Rodar testes**; expected PASS.
- [ ] **Step 5: Commit** `git add resources/views/pages/attendances resources/views/components/app/entity-manager-modal.blade.php tests/Feature/AttendanceManagementTest.php tests/Feature/AttendanceTaxonomyManagementTest.php && git commit -m "feat: standardize attendance forms"`.

### Task 6: Auditoria e verificação final

**Files:** testes alterados somente se auditoria identificar contrato sem cobertura.

**Interfaces:** Consome todos componentes/migrações anteriores.

- [ ] **Step 1: Auditar escopo**

Run: `rg -n --glob '*.blade.php' '<(input|textarea)\\b' resources/views/pages resources/views/components/app`

Expected: CRUD compatível usa componentes; somente exclusões documentadas ficam nativas.

- [ ] **Step 2: Rodar verificações**

Run: `php artisan test && npm run build && git diff --check`

Expected: Pest e build passam; diff limpo.

- [ ] **Step 3: Inspeção visual**

Abrir criação de beneficiária, material, empréstimo e atendimento; conferir vazio, preenchido, textarea, select required e modal.

- [ ] **Step 4: Commit final**

```bash
git add tests
git commit -m "test: cover floating form controls"
```

