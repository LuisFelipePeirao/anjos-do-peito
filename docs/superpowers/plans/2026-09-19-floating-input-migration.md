# Floating Input Migration Implementation Plan

> For agentic workers: REQUIRED SUB-SKILL: Use superpowers:executing-plans task-by-task. Steps use checkbox syntax.

**Goal:** Migrate scoped creation, editing and modal native inputs to x-material.floating-input.

**Architecture:** Preserve values, validation and browser attributes. Controls outside scope remain native.

**Tech Stack:** Laravel 13, Blade, Tailwind CSS 4, Pest 5, Vite.

**Spec:** docs/superpowers/specs/2026-09-19-floating-input-migration-design.md

## Global Constraints

- Migrate text, email, tel, number, date, time and datetime-local fields only.
- Preserve old values, edit values, data attributes, masks, limits, inputmode, disabled and grid classes.
- Required fields use component prop required, native HTML validation and red marker.
- Do not change selects, textareas, radios, hidden inputs, passwords/login, filters or JavaScript templates.

## Review Focus

- Required field emits HTML validation and red asterisk.
- Optional field emits no asterisk.
- Masked fields retain data-mask, data-cep-input and inputmode.
- Disabled rental fields retain disabled and data-pump-billing-field.
- Named modal error bags retain external error markup.

---

### Task 1: Migrate beneficiary and user fields

**Files:**
- Modify: resources/views/pages/beneficiaries/partials/form.blade.php
- Modify: resources/views/pages/beneficiaries/partials/child-modal.blade.php
- Modify: resources/views/pages/users/partials/form.blade.php
- Test: tests/Feature/BeneficiaryManagementTest.php
- Test: tests/Feature/Admin/UserManagementTest.php

**Interfaces:**
- Consumes: floating component props and attribute forwarding.
- Produces: floating beneficiary/user identity fields; native password toggles remain.

- [ ] **Step 1: Write failing render test**

~~~php
it('renders floating required beneficiary inputs', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('beneficiaries.create'))
        ->assertOk()
        ->assertSee('name="cpf"', false)
        ->assertSee('data-mask="cpf"', false)
        ->assertSee('<span aria-hidden="true" class="ml-0.5 text-[#c2414b]">*</span>', false);
});
~~~

- [ ] **Step 2: Run failing test**

Run: php artisan test tests/Feature/BeneficiaryManagementTest.php tests/Feature/Admin/UserManagementTest.php

Expected: FAIL because remaining scoped inputs are native.

- [ ] **Step 3: Migrate fields**

Replace scoped native inputs with the component. Preserve CPF, CEP and phone masks, error output, values and grid spans. Convert user name/e-mail only; leave password wrappers and toggles native.

- [ ] **Step 4: Run focused tests**

Run: php artisan test tests/Feature/BeneficiaryManagementTest.php tests/Feature/Admin/UserManagementTest.php

Expected: PASS.

- [ ] **Step 5: Commit**

~~~bash
git add resources/views/pages/beneficiaries resources/views/pages/users tests/Feature/BeneficiaryManagementTest.php tests/Feature/Admin/UserManagementTest.php
git commit -m "feat: migrate beneficiary and user inputs"
~~~

### Task 2: Migrate pump, loan and renewal fields

**Files:**
- Modify: resources/views/pages/pumps/partials/form.blade.php
- Modify: resources/views/pages/pumps/loans/create.blade.php
- Modify: resources/views/pages/pumps/show.blade.php
- Test: tests/Feature/PumpManagementTest.php
- Test: tests/Feature/PumpLoanManagementTest.php

**Interfaces:**
- Consumes: component forwarding for min, max, disabled, inputmode and data-pump-billing-field.
- Produces: floating pump inputs; radios, selects and textareas remain unchanged.

- [ ] **Step 1: Write failing render test**

~~~php
it('renders required floating pump code input', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('pumps.create'))
        ->assertOk()
        ->assertSee('name="codigo"', false)
        ->assertSee('<span aria-hidden="true" class="ml-0.5 text-[#c2414b]">*</span>', false);
});
~~~

- [ ] **Step 2: Run failing test**

Run: php artisan test tests/Feature/PumpManagementTest.php tests/Feature/PumpLoanManagementTest.php

Expected: FAIL because scoped fields remain native.

- [ ] **Step 3: Migrate fields**

Convert pump identity/date, loan date, rental billing and renewal expiry. Preserve disabled billing attributes, range limits, radios, selects and textareas.

- [ ] **Step 4: Run focused tests**

Run: php artisan test tests/Feature/PumpManagementTest.php tests/Feature/PumpLoanManagementTest.php

Expected: PASS.

- [ ] **Step 5: Commit**

~~~bash
git add resources/views/pages/pumps tests/Feature/PumpManagementTest.php tests/Feature/PumpLoanManagementTest.php
git commit -m "feat: migrate pump form inputs"
~~~

### Task 3: Migrate attendance and modal fields

**Files:**
- Modify: resources/views/pages/attendances/form.blade.php
- Modify: resources/views/pages/attendances/partials/clinical-fields.blade.php
- Modify: resources/views/pages/attendances/partials/location-modal.blade.php
- Modify: resources/views/components/app/entity-manager-modal.blade.php
- Test: tests/Feature/AttendanceManagementTest.php

**Interfaces:**
- Consumes: component with named error-bag messages retained outside component.
- Produces: floating agenda, clinical, location and entity fields.

- [ ] **Step 1: Write failing render test**

~~~php
it('renders floating attendance and location fields', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('attendances.create'))
        ->assertOk()
        ->assertSee('name="date"', false)
        ->assertSee('name="summary"', false)
        ->assertSee('data-cep-input', false);
});
~~~

- [ ] **Step 2: Run failing test**

Run: php artisan test tests/Feature/AttendanceManagementTest.php

Expected: FAIL because component markup is absent.

- [ ] **Step 3: Migrate fields**

Convert agenda date/time, clinical summary, location address and entity name/description. Keep hidden fields, selects, textareas and named error bag calls unchanged.

- [ ] **Step 4: Run focused test**

Run: php artisan test tests/Feature/AttendanceManagementTest.php

Expected: PASS.

- [ ] **Step 5: Commit**

~~~bash
git add resources/views/pages/attendances resources/views/components/app/entity-manager-modal.blade.php tests/Feature/AttendanceManagementTest.php
git commit -m "feat: migrate attendance form inputs"
~~~

### Task 4: Migrate donation and stock fields

**Files:**
- Modify: resources/views/pages/donations/materials/create.blade.php
- Modify: resources/views/pages/donations/partials/donor-modal.blade.php
- Modify: resources/views/pages/donations/distributions/create.blade.php
- Test: tests/Feature/DonationStockManagementTest.php
- Test: tests/Feature/StockMovementManagementTest.php

**Interfaces:**
- Consumes: forwarding for quantity limits and entry/distribution selectors.
- Produces: floating server-rendered donation inputs; JavaScript templates remain native.

- [ ] **Step 1: Write failing render test**

~~~php
it('renders required floating material inputs', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('donations.materials.create'))
        ->assertOk()
        ->assertSee('name="estoque_minimo"', false)
        ->assertSee('<span aria-hidden="true" class="ml-0.5 text-[#c2414b]">*</span>', false);
});
~~~

- [ ] **Step 2: Run failing test**

Run: php artisan test tests/Feature/DonationStockManagementTest.php tests/Feature/StockMovementManagementTest.php

Expected: FAIL because material inputs remain native.

- [ ] **Step 3: Migrate fields**

Convert material, donor and server-rendered distribution fields. Preserve min, names, date-time values and data-entry/data-distribution attributes. Do not alter JavaScript templates.

- [ ] **Step 4: Run focused tests**

Run: php artisan test tests/Feature/DonationStockManagementTest.php tests/Feature/StockMovementManagementTest.php

Expected: PASS.

- [ ] **Step 5: Commit**

~~~bash
git add resources/views/pages/donations tests/Feature/DonationStockManagementTest.php tests/Feature/StockMovementManagementTest.php
git commit -m "feat: migrate donation form inputs"
~~~

### Task 5: Verify component contract and full migration

**Files:**
- Modify: resources/views/components/material/floating-input.blade.php
- Modify: tests/Feature/BeneficiaryManagementTest.php

**Interfaces:**
- Consumes: all migrated field calls.
- Produces: final required/optional component contract.

- [ ] **Step 1: Write optional-field test**

~~~php
it('does not render marker for optional floating field', function () {
    $html = Blade::render('<x-material.floating-input name="optional" label="Opcional" />');

    expect($html)->not->toContain('aria-hidden="true"');
});
~~~

- [ ] **Step 2: Run test and verify behavior**

Run: php artisan test tests/Feature/BeneficiaryManagementTest.php

Expected: PASS if component already satisfies contract; record a ruling. Otherwise FAIL and continue.

- [ ] **Step 3: Correct component only if test fails**

Condition native required and marker on component prop; make no unrelated change.

- [ ] **Step 4: Run complete verification**

Run: composer test && git diff --check && npm run build

Expected: Pest passes, diff check is clean and Vite succeeds.

- [ ] **Step 5: Commit**

~~~bash
git add resources/views/components/material/floating-input.blade.php tests/Feature/BeneficiaryManagementTest.php
git commit -m "test: cover floating input migration"
~~~

