# Cobranças recorrentes de aluguel Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Gerar e controlar internamente parcelas mensais de aluguéis de bombas, com baixa manual e histórico auditável.

**Architecture:** Cessão guarda regra e cursor da próxima cobrança. `RentalBillingService`, acionado por comando diário, cria parcelas idempotentes e marca atrasos. Aba Pagamentos permite baixa e cancelamento manual.

**Tech Stack:** PHP 8.3, Laravel 13, Eloquent, Laravel Scheduler, Blade, Pest 5 e MySQL.

**Spec:** `docs/superpowers/specs/2026-09-23-cobrancas-recorrentes-aluguel-design.md`

## Global Constraints

- Sem integração externa de pagamento ou comunicação.
- Usar enum existente `atrasado` para parcela vencida.
- Cessões gratuitas mantêm dados financeiros nulos.
- Dias 29–31 usam último dia de meses menores.
- Atualizar `docs/Alterações_underline BD.md` junto de toda migration/índice.
- Nunca excluir parcela; somente `pago` ou `cancelado`.

## Review Focus

- Execução repetida não duplica `id_cessao` + `competencia`.
- Fevereiro e meses curtos respeitam vencimento 29–31.
- Devolução não cria parcela futura.
- Parcela fechada não recebe nova baixa/cancelamento.
- Empréstimo gratuito persiste campos financeiros como nulos.

---

## File Structure

- Create: migration `add_recurring_billing_fields_to_cessoes_bombas_table`, `RentalBillingService`, `GenerateRentalPayments`, request/controlador de pagamento e dois testes feature.
- Modify: `CessaoBomba`, `routes/console.php`, `routes/web.php`, `StorePumpLoanRequest`, `PumpLoanService`, `PumpService`, `create.blade.php`, `show.blade.php`, teste de empréstimo e documento BD.

### Task 1: Estrutura de banco e modelo

**Files:**
- Create: `database/migrations/<timestamp>_add_recurring_billing_fields_to_cessoes_bombas_table.php`
- Modify: `app/Models/CessaoBomba.php`, `docs/Alterações_underline BD.md`
- Test: `tests/Feature/PumpLoanManagementTest.php`

**Interfaces:** Produz `dia_vencimento: ?int`, `forma_cobranca: ?string`, `primeira_cobranca_em: ?Carbon`, `proxima_cobranca_em: ?Carbon`; cria índice único por cessão e competência.

- [ ] **Step 1: Escrever teste falho de regra estruturada**

```php
$this->assertDatabaseHas('cessoes_bombas', [
    'id' => $loan->id,
    'dia_vencimento' => 10,
    'forma_cobranca' => 'pix',
    'primeira_cobranca_em' => '2026-08-25',
    'proxima_cobranca_em' => '2026-09-01',
]);
```

- [ ] **Step 2: Confirmar falha** — rodar `php artisan test tests/Feature/PumpLoanManagementTest.php --filter="registers a rental"`; esperar falha por colunas inexistentes.

- [ ] **Step 3: Criar migration, casts e documentação**

```php
Schema::table('cessoes_bombas', function (Blueprint $table) {
    $table->unsignedTinyInteger('dia_vencimento')->nullable()->after('valor_mensalidade');
    $table->string('forma_cobranca', 20)->nullable()->after('dia_vencimento');
    $table->date('primeira_cobranca_em')->nullable()->after('forma_cobranca');
    $table->date('proxima_cobranca_em')->nullable()->after('primeira_cobranca_em');
});
Schema::table('pagamentos_alugueis', fn (Blueprint $table) => $table->unique(['id_cessao', 'competencia'], 'pagamentos_alugueis_cessao_competencia_unique'));
```

Adicionar atributos a `$fillable`, datas aos casts. `down` remove índice pelo nome e depois quatro campos. Atualizar documento TCC com nome real da migration.

- [ ] **Step 4: Verificar migration** — rodar `php artisan migrate:fresh --seed`; esperar sucesso.
- [ ] **Step 5: Commit** — `feat: armazena regras de cobrança de aluguel`.

### Task 2: Motor de recorrência e comando diário

**Files:**
- Create: `app/Services/RentalBillingService.php`, `app/Console/Commands/GenerateRentalPayments.php`
- Modify: `routes/console.php`
- Test: `tests/Feature/RentalBillingCommandTest.php`

**Interfaces:** `RentalBillingService::process(Carbon $today): int`; comando `rentals:generate-payments {--date=}`. Consome aluguel ativo/atrasado sem devolução e com cursor até hoje.

- [ ] **Step 1: Escrever testes falhos de geração**

```php
travelTo('2026-02-28');
Artisan::call('rentals:generate-payments');
$this->assertDatabaseHas('pagamentos_alugueis', [
    'id_cessao' => $loan->id,
    'competencia' => '2026-02-01',
    'data_vencimento' => '2026-02-28',
    'situacao' => 'pendente',
]);
Artisan::call('rentals:generate-payments');
expect(PagamentoAluguel::where('id_cessao', $loan->id)->whereDate('competencia', '2026-02-01')->count())->toBe(1);
```

Adicionar casos: pendente vira `atrasado`; cessão finalizada não cria parcela.

- [ ] **Step 2: Confirmar falha** — rodar `php artisan test tests/Feature/RentalBillingCommandTest.php`; esperar comando inexistente.

- [ ] **Step 3: Implementar rotina**

```php
PagamentoAluguel::query()->where('situacao', 'pendente')
    ->whereDate('data_vencimento', '<', $today->toDateString())
    ->update(['situacao' => 'atrasado']);
```

Em transação, gerar até cursor ficar futuro usando `firstOrCreate` por cessão/competência. Calcular vencimento com `min($dia, $competence->daysInMonth)`; avançar cursor para primeiro dia do mês seguinte. Agendar `Schedule::command('rentals:generate-payments')->daily()->withoutOverlapping()`.

- [ ] **Step 4: Rodar testes** — `php artisan test tests/Feature/RentalBillingCommandTest.php`; esperar PASS.
- [ ] **Step 5: Commit** — `feat: gera cobranças recorrentes de aluguel`.

### Task 3: Cadastro inicial e formulário

**Files:**
- Modify: `app/Http/Requests/Pumps/StorePumpLoanRequest.php`, `app/Services/PumpLoanService.php`, `resources/views/pages/pumps/loans/create.blade.php`
- Test: `tests/Feature/PumpLoanManagementTest.php`

**Interfaces:** POST de aluguel cria primeira parcela em `first_billing_at`, vencimento pelo `due_day`, cursor no primeiro dia do mês posterior. Empréstimo gratuito resulta em quatro nulos.

- [ ] **Step 1: Criar testes falhos de aluguel e gratuidade**

```php
$this->assertDatabaseHas('cessoes_bombas', [
    'tipo' => 'gratuita',
    'dia_vencimento' => null,
    'forma_cobranca' => null,
    'primeira_cobranca_em' => null,
    'proxima_cobranca_em' => null,
]);
```

- [ ] **Step 2: Confirmar falha** — `php artisan test tests/Feature/PumpLoanManagementTest.php`; esperar campos não persistidos.

- [ ] **Step 3: Persistir regra e atualizar Blade**

```php
'dia_vencimento' => $isRental ? $data['due_day'] : null,
'forma_cobranca' => $isRental ? $data['billing_method'] : null,
'primeira_cobranca_em' => $isRental ? $data['first_billing_at'] : null,
'proxima_cobranca_em' => $isRental ? Carbon::parse($data['first_billing_at'])->startOfMonth()->addMonth() : null,
```

Reusar cálculo de vencimento da Task 2 para primeira parcela. Deixar `billing_notes` somente na observação; não duplicar dia/forma em texto. Atualizar ajuda da Blade: parcelas automáticas e baixa interna. Preservar desabilitação em empréstimo.

- [ ] **Step 4: Rodar testes** — `php artisan test tests/Feature/PumpLoanManagementTest.php`; esperar PASS.
- [ ] **Step 5: Commit** — `feat: registra primeira cobrança de aluguel`.

### Task 4: Baixa e cancelamento manual

**Files:**
- Create: `app/Http/Requests/Pumps/SetRentalPaymentStatusRequest.php`, `app/Http/Controllers/RentalPaymentController.php`
- Modify: `routes/web.php`, `app/Services/PumpService.php`, `resources/views/pages/pumps/show.blade.php`
- Test: `tests/Feature/RentalPaymentManagementTest.php`

**Interfaces:** PATCH `pumps.payments.pay`/`pumps.payments.cancel` recebe `PagamentoAluguel`; retorna para `pumps.show?tab=payments` com estado `pago` ou `cancelado`.

- [ ] **Step 1: Escrever testes falhos de operações**

```php
$this->actingAs($manager)->patch(route('pumps.payments.pay', $payment), [
    'paid_at' => '2026-09-12',
    'notes' => 'Recebido em dinheiro.',
]);
$this->assertDatabaseHas('pagamentos_alugueis', [
    'id' => $payment->id, 'situacao' => 'pago', 'data_pagamento' => '2026-09-12',
]);
```

Cobrir justificativa obrigatória para cancelamento, 403 para atendente e bloqueio de nova operação em parcela fechada.

- [ ] **Step 2: Confirmar falha** — `php artisan test tests/Feature/RentalPaymentManagementTest.php`; esperar rotas inexistentes.

- [ ] **Step 3: Implementar request, controlador e UI**

```php
PagamentoAluguel::query()->whereKey($payment)->whereIn('situacao', ['pendente', 'atrasado'])->update([
    'situacao' => 'pago',
    'data_pagamento' => $data['paid_at'],
    'observacao' => $data['notes'],
]);
```

Cancelamento limpa `data_pagamento` e exige justificativa. Expor id, vencimento e forma de cobrança em `PumpService::payments`; botões/modais aparecem só para pendente/atrasado.

- [ ] **Step 4: Rodar testes** — `php artisan test tests/Feature/RentalPaymentManagementTest.php tests/Feature/PumpManagementTest.php`; esperar PASS.
- [ ] **Step 5: Commit** — `feat: permite baixar cobranças de aluguel`.

### Task 5: Verificação ponta a ponta e documento TCC

**Files:**
- Modify: `docs/Alterações_underline BD.md`
- Test: três testes de recurso anteriores.

**Interfaces:** Confirma fluxo cadastro, cron, devolução e baixa; produz documento idêntico à migration final.

- [ ] **Step 1: Escrever cenário fim a fim**

```php
Artisan::call('rentals:generate-payments', ['--date' => '2026-10-01']);
$this->patch(route('pumps.loans.return', $pump), ['returned_at' => '2026-10-02']);
Artisan::call('rentals:generate-payments', ['--date' => '2026-11-01']);
expect(PagamentoAluguel::where('id_cessao', $loan->id)->count())->toBe(2);
```

- [ ] **Step 2: Rodar testes do recurso** — `php artisan test tests/Feature/PumpLoanManagementTest.php tests/Feature/RentalBillingCommandTest.php tests/Feature/RentalPaymentManagementTest.php`; esperar PASS.
- [ ] **Step 3: Conferir documento BD** — nome real da migration, quatro campos, tipos, nulidade, justificativas, índice único e nenhuma tabela nova.
- [ ] **Step 4: Formatar e rodar suíte** — `vendor/bin/pint --dirty && php artisan test`; esperar Pint limpo e PASS.
- [ ] **Step 5: Commit** — `test: cobre fluxo de cobranças recorrentes`.
