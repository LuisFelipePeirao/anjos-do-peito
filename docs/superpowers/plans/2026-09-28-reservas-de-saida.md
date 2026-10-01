# Reservas de Saída Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Registrar saídas pendentes como reservas, confirmar ou cancelar reservas no detalhe e separar saldo reservável de estoque e relatórios reais.

**Architecture:** `Distribuicao.situacao` segue como fonte de verdade. Serviços passam a calcular saldo reservável (`pendente` e `entregue`) separado de saldo real (`entregue`). Baixa atualiza distribuição e movimentações vinculadas para horário atual.

**Tech Stack:** Laravel 13, PHP 8.3, Eloquent, Blade, Pest 5.

**Spec:** `docs/superpowers/specs/2026-09-28-reservas-de-saida-design.md`

## Global Constraints

- Não criar migration, coluna ou tabela; sobrescrever `data_hora` na baixa.
- Pendente bloqueia nova saída, mas não entra em estoque real, consumo, indicadores ou relatórios.
- Cancelada não bloqueia saldo e não entra em estoque real ou relatórios.
- Baixa/cancelamento válidos somente uma vez, enquanto estado for `pendente`.
- Preservar mudanças não relacionadas já presentes no diretório de trabalho.

## Review Focus

- Duas reservas não podem superar entrada disponível; teste Task 1.
- Pendência reduz saldo disponível de nova saída, mas não estoque real; teste Task 1.
- Baixa atualiza data de distribuição e movimentações vinculadas; teste Task 2.
- Segunda baixa/cancelamento ou combinação dos dois responde conflito; teste Task 2.
- Filtros de período excluem pendente; teste Task 3.

---

## File Structure

- `app/Services/StockMovementService.php`: saldos de nova saída, dados do detalhe e transições.
- `app/Services/DonationStockService.php`: estoque real, consumo e demanda mensal; saldo do fluxo legado.
- `app/Http/Controllers/StockMovementController.php` e `routes/web.php`: endpoints PATCH autorizados.
- `resources/views/pages/movements/show.blade.php`: situação, observação da distribuição e ações.
- `app/Services/ReportService.php`: consultas baseadas somente em entregas.
- `tests/Feature/StockMovementManagementTest.php`, `DonationStockManagementTest.php`, `ReportsPageTest.php`: cobertura.

### Task 1: Separar saldo reservável de estoque real

**Files:**

- Modify: `app/Services/StockMovementService.php`
- Modify: `app/Services/DonationStockService.php`
- Test: `tests/Feature/StockMovementManagementTest.php`
- Test: `tests/Feature/DonationStockManagementTest.php`

**Interfaces:**

- Consumes: `EstoqueMovimentacao::distribuicaoItem.distribuicao.situacao`.
- Produces: saldo em `formOptions()`/`createData()` que desconta `pendente` e `entregue`; saldo, uso e demanda de estoque que descontam somente `entregue`.

- [ ] **Step 1: Escrever testes de saldo de reserva e saldo real**

Criar entrada de 8 e saída pendente de 5. Nova saída de 4 deve falhar em `items`; saída de 3 deve ser aceita. Página de estoque deve mostrar 8 como estoque real e demanda mensal não incluir 5 pendentes.

- [ ] **Step 2: Rodar teste para verificar falha**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php tests/Feature/DonationStockManagementTest.php`

Expected: FAIL; implementação atual considera pendência como saída efetiva nas telas de estoque ou não cobre cenário.

- [ ] **Step 3: Implementar predicados separados de impacto**

Nos dois serviços, criar métodos privados para saída que bloqueia reserva (situação diferente de `cancelada`) e saída efetivada (situação igual a `entregue`). Usar bloqueio em validação e `materialBalances`; usar efetivação em `DonationStockService::balance`, `used` e `monthlyDemand`.

- [ ] **Step 4: Rodar teste para verificar aprovação**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php tests/Feature/DonationStockManagementTest.php`

Expected: PASS.

- [ ] **Step 5: Commit**

```powershell
git add app/Services/StockMovementService.php app/Services/DonationStockService.php tests/Feature/StockMovementManagementTest.php tests/Feature/DonationStockManagementTest.php
git commit -m "fix: separa reservas de estoque real"
```

### Task 2: Baixa/cancelamento e detalhe de pendências

**Files:**

- Modify: `routes/web.php`
- Modify: `app/Http/Controllers/StockMovementController.php`
- Modify: `app/Services/StockMovementService.php`
- Modify: `resources/views/pages/movements/show.blade.php`
- Test: `tests/Feature/StockMovementManagementTest.php`

**Interfaces:**

- Consumes: `StockMovementController::confirm(EstoqueMovimentacao $movement): RedirectResponse` e `cancel(EstoqueMovimentacao $movement): RedirectResponse`.
- Produces: `StockMovementService::confirmPending(EstoqueMovimentacao $movement): void`, `cancelPending(EstoqueMovimentacao $movement): void`, e campos `distributionObservation` e `canResolvePending` em `showData()`.

- [ ] **Step 1: Escrever testes de detalhe e transições**

Criar saída pendente com observação `Retirada agendada`. Detalhe deve ver `Pendente`, observação padrão, observação registrada, `Dar baixa` e `Cancelar`. Com `Carbon::setTestNow('2026-09-28 15:30:00')`, PATCH de baixa deve persistir `entregue` e horário em `distribuicoes` e `estoque_movimentacoes`. PATCH de cancelamento em pendência separada deve persistir `cancelada`. Repetir ação em estado final responde 409.

- [ ] **Step 2: Rodar teste para verificar falha**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php`

Expected: FAIL; rotas, ações e métodos de transição inexistem.

- [ ] **Step 3: Adicionar endpoints e serviço transacional**

Adicionar `PATCH /movimentacoes/{movement}/dar-baixa` e `PATCH /movimentacoes/{movement}/cancelar` antes de `GET /movimentacoes/{movement}`. Controlador aplica mesma autorização da criação e redireciona ao detalhe. Serviço carrega distribuição por `distribuicaoItem`, aborta 409 se ausência/estado diferente de `pendente`; em transação atualiza situação. Baixa também atualiza `data_hora` da distribuição e todas as `EstoqueMovimentacao` dos itens dela com `now()`.

- [ ] **Step 4: Expor dados e ações no Blade**

Em `showData()`, obter situação e observação de `distribuicaoItem->distribuicao`. Blade exibe status e observação registrada somente quando presente; renderiza formulários PATCH com `@csrf` e `@method('PATCH')` somente em `canResolvePending`.

- [ ] **Step 5: Rodar teste para verificar aprovação**

Run: `php artisan test tests/Feature/StockMovementManagementTest.php`

Expected: PASS.

- [ ] **Step 6: Commit**

```powershell
git add routes/web.php app/Http/Controllers/StockMovementController.php app/Services/StockMovementService.php resources/views/pages/movements/show.blade.php tests/Feature/StockMovementManagementTest.php
git commit -m "feat: confirma ou cancela reservas de saída"
```

### Task 3: Excluir pendências dos relatórios

**Files:**

- Modify: `app/Services/ReportService.php`
- Test: `tests/Feature/ReportsPageTest.php`

**Interfaces:**

- Consumes: distribuição e movimentações com data atualizada por Task 2.
- Produces: KPIs, cobertura, consumo e distribuições por profissional somente com `distribuicoes.situacao = 'entregue'`.

- [ ] **Step 1: Escrever teste de relatório com pendência e entrega**

Criar entrada de 10, saída pendente de 4 e saída entregue de 2 no período. Relatório deve apresentar saldo 8 e consumo 2, nunca valores derivados de pendência. Profissional com uma pendência e uma entrega deve ter `Distribuições` igual a 1.

- [ ] **Step 2: Rodar teste para verificar falha**

Run: `php artisan test tests/Feature/ReportsPageTest.php`

Expected: FAIL; consultas atuais subtraem/somam qualquer `saida` e gráfico profissional não filtra situação.

- [ ] **Step 3: Filtrar consultas por distribuição entregue**

Preservar entradas e ajustes. Nas consultas Eloquent de saída, usar `whereHas('distribuicaoItem.distribuicao', fn ($query) => $query->where('situacao', 'entregue'))`. Na agregação SQL de cobertura, usar `leftJoin` em itens/distribuições e `CASE` que subtrai saída somente se distribuição estiver entregue. Adicionar filtro `situacao = entregue` à contagem profissional.

- [ ] **Step 4: Rodar teste para verificar aprovação**

Run: `php artisan test tests/Feature/ReportsPageTest.php`

Expected: PASS.

- [ ] **Step 5: Rodar suíte relevante e formatador**

Run: `vendor/bin/pint --dirty && php artisan test tests/Feature/StockMovementManagementTest.php tests/Feature/DonationStockManagementTest.php tests/Feature/ReportsPageTest.php`

Expected: Pint sem alterações pendentes e todos testes PASS.

- [ ] **Step 6: Commit**

```powershell
git add app/Services/ReportService.php tests/Feature/ReportsPageTest.php
git commit -m "fix: exclui reservas dos relatórios"
```
