# Manutenções de Bombas de Leite Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (\`- [ ]\`) syntax for tracking.

**Goal:** Registrar, acompanhar e encerrar manutenções, bloqueando saída de bombas indisponíveis.

**Architecture:** O \`PumpController\` recebe três operações autenticadas e delega transações ao \`PumpService\`. Form requests normalizam e validam dados; a tela usa modais e dados mapeados pelo serviço. A tabela existente \`manutencoes_bombas\` é a fonte de verdade, sem migration.

**Tech Stack:** Laravel 12, PHP, Eloquent, Form Requests, Blade, Pest e Tailwind/Vite.

**Spec:** \`docs/superpowers/specs/2026-09-24-manutencoes-bombas-design.md\`

## Global Constraints

- Não criar migration nem alterar banco; portanto \`docs/Alterações_underline BD.md\` não muda.
- Somente perfil que pode gerenciar atendimentos executa mutações.
- Só bomba \`disponivel\` abre manutenção; abertura muda para \`manutencao\`.
- Bomba em manutenção, alugada/emprestada ou baixada não abre manutenção.
- Conclusão exige data/hora final; conclusão ou cancelamento libera bomba.
- Não criar nova tabela de histórico nesta fase.

## Review Focus

- Duas requisições simultâneas de abertura: só uma pode mudar bomba disponível para manutenção; teste deve impedir a segunda.
- URL com manutenção de outra bomba: finalizar/cancelar responde 404 e não muda equipamento.
- Data final anterior ao início: validação rejeita.
- Bomba alugada via URL direta: abertura responde 409 e não cria manutenção.
- Modal com erro: reabre e preserva valores; teste garante marcadores/campos.

---

## File Structure

- \`app/Http/Requests/Pumps/StorePumpMaintenanceRequest.php\`: valida abertura.
- \`app/Http/Requests/Pumps/FinishPumpMaintenanceRequest.php\`: valida conclusão.
- \`app/Http/Requests/Pumps/CancelPumpMaintenanceRequest.php\`: valida cancelamento.
- \`app/Http/Controllers/PumpController.php\`: endpoints.
- \`app/Services/PumpService.php\`: transações, bloqueios e dados de tela.
- \`routes/web.php\`: rotas POST/PATCH aninhadas em bomba.
- \`resources/views/pages/pumps/show.blade.php\`: ação, modais e tabela.
- \`tests/Feature/PumpMaintenanceManagementTest.php\`: comportamento HTTP, persistência e interface.

### Task 1: Abrir manutenção com regras de disponibilidade

**Files:**

- Create: \`app/Http/Requests/Pumps/StorePumpMaintenanceRequest.php\`
- Modify: \`app/Http/Controllers/PumpController.php\`
- Modify: \`app/Services/PumpService.php\`
- Modify: \`routes/web.php\`
- Test: \`tests/Feature/PumpMaintenanceManagementTest.php\`

**Interfaces:**

- Consumes: \`PumpService::openMaintenance(BombaLeite $pump, array $data, int $userId): ManutencaoBomba\`.
- Produces: \`POST pumps.maintenance.store\`, com \`type\`, \`started_at\`, \`status\`, \`description\`, \`notes\`.

- [ ] **Step 1: Write the failing test**

\`\`\`php
it('opens maintenance only for an available pump', function () {
    $user = User::factory()->administrador()->create();
    $pump = BombaLeite::create(pumpPayload(['codigo' => 'BL-MAINT']));

    $this->actingAs($user)->post(route('pumps.maintenance.store', $pump), [
        'type' => 'corretiva', 'started_at' => '2026-09-24T09:30',
        'status' => 'em_andamento', 'description' => 'Fonte sem energia.',
        'notes' => 'Aguardar peça.',
    ])->assertRedirect(route('pumps.show', ['pump' => $pump, 'tab' => 'maintenance']));

    $this->assertDatabaseHas('manutencoes_bombas', ['id_bomba' => $pump->id, 'id_usuario' => $user->id, 'tipo' => 'corretiva', 'situacao' => 'em_andamento']);
    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'situacao' => 'manutencao']);
});
\`\`\`

- [ ] **Step 2: Run test to verify it fails**

Run: \`php artisan test tests/Feature/PumpMaintenanceManagementTest.php --filter="opens maintenance"\`

Expected: FAIL; rota ou classe inexistente.

- [ ] **Step 3: Write minimal implementation**

\`\`\`php
// StorePumpMaintenanceRequest::rules()
return [
    'type' => ['required', Rule::in(['preventiva', 'corretiva', 'higienizacao'])],
    'started_at' => ['required', 'date'],
    'status' => ['required', Rule::in(['aberta', 'em_andamento'])],
    'description' => ['required', 'string'],
    'notes' => ['nullable', 'string'],
];

// PumpService::openMaintenance()
return DB::transaction(function () use ($pump, $data, $userId) {
    abort_unless($pump->fresh()->situacao === 'disponivel', 409);
    $maintenance = $pump->manutencoes()->create([
        'id_usuario' => $userId, 'tipo' => $data['type'],
        'data_inicio' => $data['started_at'], 'situacao' => $data['status'],
        'descricao' => $data['description'], 'observacao' => $data['notes'] ?? null,
    ]);
    $pump->update(['situacao' => 'manutencao']);
    return $maintenance;
});
\`\`\`

Criar \`StorePumpMaintenanceRequest::authorize()\` com \`canManageAttendances()\`, rota POST e action do controller que redireciona à aba \`maintenance\`.

- [ ] **Step 4: Add critical-input tests**

\`\`\`php
dataset('unavailablePumpStatuses', ['alugada', 'manutencao', 'baixada']);

it('does not open maintenance for unavailable pumps', function (string $status) {
    $pump = BombaLeite::create(pumpPayload(['codigo' => "BL-$status", 'situacao' => $status]));
    $this->actingAs(User::factory()->administrador()->create())
        ->post(route('pumps.maintenance.store', $pump), validMaintenancePayload())
        ->assertStatus(409);
    $this->assertDatabaseMissing('manutencoes_bombas', ['id_bomba' => $pump->id]);
})->with('unavailablePumpStatuses');
\`\`\`

- [ ] **Step 5: Run test to verify it passes**

Run: \`php artisan test tests/Feature/PumpMaintenanceManagementTest.php\`

Expected: PASS.

- [ ] **Step 6: Commit**

\`\`\`powershell
git add app/Http/Requests/Pumps/StorePumpMaintenanceRequest.php app/Http/Controllers/PumpController.php app/Services/PumpService.php routes/web.php tests/Feature/PumpMaintenanceManagementTest.php
git commit -m "feat: abre manutenções de bombas"
\`\`\`

### Task 2: Concluir e cancelar manutenção

**Files:**

- Create: \`app/Http/Requests/Pumps/FinishPumpMaintenanceRequest.php\`
- Create: \`app/Http/Requests/Pumps/CancelPumpMaintenanceRequest.php\`
- Modify: \`app/Http/Controllers/PumpController.php\`
- Modify: \`app/Services/PumpService.php\`
- Modify: \`routes/web.php\`
- Test: \`tests/Feature/PumpMaintenanceManagementTest.php\`

**Interfaces:**

- Consumes: rota com \`BombaLeite $pump\` e \`ManutencaoBomba $maintenance\`.
- Produces: \`finishMaintenance(...): ManutencaoBomba\` e \`cancelMaintenance(...): ManutencaoBomba\`; ambos liberam a bomba somente se manutenção pertence a ela e está ativa.

- [ ] **Step 1: Write the failing tests**

\`\`\`php
it('finishes maintenance and releases the pump', function () {
    [$user, $pump, $maintenance] = maintenanceInProgress();
    $this->actingAs($user)->patch(route('pumps.maintenance.finish', [$pump, $maintenance]), [
        'finished_at' => '2026-09-24T17:00', 'notes' => 'Teste final aprovado.',
    ])->assertRedirect(route('pumps.show', ['pump' => $pump, 'tab' => 'maintenance']));
    $this->assertDatabaseHas('manutencoes_bombas', ['id' => $maintenance->id, 'situacao' => 'concluida', 'data_fim' => '2026-09-24 17:00:00']);
    $this->assertDatabaseHas('bomba_leite', ['id' => $pump->id, 'situacao' => 'disponivel']);
});

it('cancels maintenance and releases the pump', function () {
    [$user, $pump, $maintenance] = maintenanceInProgress();
    $this->actingAs($user)->patch(route('pumps.maintenance.cancel', [$pump, $maintenance]), ['notes' => 'Peça não necessária.']);
    $this->assertDatabaseHas('manutencoes_bombas', ['id' => $maintenance->id, 'situacao' => 'cancelada', 'observacao' => 'Peça não necessária.']);
});
\`\`\`

- [ ] **Step 2: Run tests to verify they fail**

Run: \`php artisan test tests/Feature/PumpMaintenanceManagementTest.php --filter="finishes|cancels"\`

Expected: FAIL; rotas inexistentes.

- [ ] **Step 3: Write minimal implementation**

\`\`\`php
// FinishPumpMaintenanceRequest::rules()
return ['finished_at' => ['required', 'date', 'after_or_equal:maintenance_started_at'], 'notes' => ['nullable', 'string']];

// PumpService::finishMaintenance()
abort_unless($maintenance->id_bomba === $pump->id && in_array($maintenance->situacao, ['aberta', 'em_andamento'], true), 404);
$maintenance->update(['situacao' => 'concluida', 'data_fim' => $data['finished_at'], 'observacao' => $data['notes'] ?? $maintenance->observacao]);
$pump->update(['situacao' => 'disponivel']);
\`\`\`

No request de conclusão, \`prepareForValidation()\` injeta \`maintenance_started_at\` do route model, para \`after_or_equal\` comparar término e início. O cancelamento aceita \`notes\` opcional e preserva observação anterior quando vazio. Ambas operações usam \`DB::transaction\`.

- [ ] **Step 4: Add critical-input tests**

\`\`\`php
$this->actingAs($user)->patch(route('pumps.maintenance.finish', [$pump, $maintenance]), [
    'finished_at' => $maintenance->data_inicio->copy()->subMinute()->format('Y-m-d\\TH:i'),
])->assertSessionHasErrors('finished_at');

$this->actingAs($user)->patch(route('pumps.maintenance.finish', [$otherPump, $maintenance]), [
    'finished_at' => now()->format('Y-m-d\\TH:i'),
])->assertNotFound();
\`\`\`

- [ ] **Step 5: Run test to verify it passes**

Run: \`php artisan test tests/Feature/PumpMaintenanceManagementTest.php\`

Expected: PASS.

- [ ] **Step 6: Commit**

\`\`\`powershell
git add app/Http/Requests/Pumps/FinishPumpMaintenanceRequest.php app/Http/Requests/Pumps/CancelPumpMaintenanceRequest.php app/Http/Controllers/PumpController.php app/Services/PumpService.php routes/web.php tests/Feature/PumpMaintenanceManagementTest.php
git commit -m "feat: encerra manutenções de bombas"
\`\`\`

### Task 3: Mostrar fluxo na tela da bomba

**Files:**

- Modify: \`app/Services/PumpService.php\`
- Modify: \`resources/views/pages/pumps/show.blade.php\`
- Test: \`tests/Feature/PumpMaintenanceManagementTest.php\`

**Interfaces:**

- Consumes: \`maintenanceAction\` (\`enabled\`, \`reason\`) e linhas de manutenção com \`id\`, \`is_open\` e status.
- Produces: botão de abertura, modais de abertura/conclusão/cancelamento e ações da aba Manutenções.

- [ ] **Step 1: Write the failing interface test**

\`\`\`php
it('shows enabled maintenance action only for available pumps', function () {
    $user = User::factory()->administrador()->create();
    $available = BombaLeite::create(pumpPayload(['codigo' => 'BL-FREE']));
    $borrowed = BombaLeite::create(pumpPayload(['codigo' => 'BL-LOAN', 'situacao' => 'alugada']));

    $this->actingAs($user)->get(route('pumps.show', $available))
        ->assertSee('data-dialog-open="pump-maintenance-modal"', false);
    $this->actingAs($user)->get(route('pumps.show', $borrowed))
        ->assertSee('disabled', false)
        ->assertSee('Esta bomba está emprestada ou alugada.', false);
});
\`\`\`

- [ ] **Step 2: Run test to verify it fails**

Run: \`php artisan test tests/Feature/PumpMaintenanceManagementTest.php --filter="shows enabled maintenance"\`

Expected: FAIL; botão atual usa \`href="#"\` e não expõe estado.

- [ ] **Step 3: Write minimal implementation**

\`\`\`php
// PumpService::showData()
'maintenanceAction' => [
    'enabled' => $pump->situacao === 'disponivel',
    'reason' => $this->maintenanceUnavailableReason($pump->situacao),
],

// Blade, caso indisponível
<span title="{{ $maintenanceAction['reason'] }}">
    <button type="button" disabled aria-disabled="true">Registrar manutenção</button>
</span>
\`\`\`

O modal de abertura terá selects para tipo/situação inicial, \`datetime-local\`, textarea para descrição/observação e abrirá com \`@error\`. A tabela terá ações \`Concluir\` e \`Cancelar\` apenas para \`aberta\`/ \`em_andamento\`, com modais que postam nas novas rotas.

- [ ] **Step 4: Add UI/history tests**

\`\`\`php
$this->actingAs($user)->get(route('pumps.show', ['pump' => $pump, 'tab' => 'maintenance']))
    ->assertSee('name="type"', false)
    ->assertSee('name="finished_at"', false)
    ->assertSee('Concluir')
    ->assertSee('Cancelar');
\`\`\`

Atualizar \`maintenanceHistory()\` com ID e \`is_open\`. Manter \`history()\` limitado aos fatos suportados pela tabela; não inventar data de cancelamento, pois ela não existe no banco.

- [ ] **Step 5: Run tests and build**

Run: \`php artisan test tests/Feature/PumpMaintenanceManagementTest.php && npm run build\`

Expected: testes PASS e build Vite concluído.

- [ ] **Step 6: Commit**

\`\`\`powershell
git add app/Services/PumpService.php resources/views/pages/pumps/show.blade.php tests/Feature/PumpMaintenanceManagementTest.php
git commit -m "feat: exibe gestão de manutenções na bomba"
\`\`\`

### Task 4: Verificação integrada

**Files:**

- Modify: \`tests/Feature/PumpLoanManagementTest.php\` (somente se cobertura atual não for explícita)
- Test: \`tests/Feature/PumpMaintenanceManagementTest.php\`

**Interfaces:**

- Consumes: \`StorePumpLoanRequest\`, que exige \`bomba_leite.situacao = disponivel\`.
- Produces: regressão que impede empréstimo/aluguel durante manutenção.

- [ ] **Step 1: Check or add regression test**

\`\`\`php
it('rejects a new loan after maintenance is opened', function () {
    $user = User::factory()->administrador()->create();
    $pump = BombaLeite::create(pumpPayload(['codigo' => 'BL-BLOCKED', 'situacao' => 'manutencao']));
    $this->actingAs($user)->post(route('pumps.loans.store'), validLoanPayload($pump))
        ->assertSessionHasErrors('pump');
});
\`\`\`

A cobertura já existe em \`PumpLoanManagementTest.php\` para situação \`manutencao\`; manter teste existente e não duplicar caso ainda cubra o fluxo.

- [ ] **Step 2: Run focused regression suite**

Run: \`php artisan test tests/Feature/PumpLoanManagementTest.php tests/Feature/PumpMaintenanceManagementTest.php\`

Expected: PASS.

- [ ] **Step 3: Run final verification**

Run: \`php artisan test && npm run build && git diff --check\`

Expected: testes PASS, build concluído e nenhum erro de whitespace.

- [ ] **Step 4: Commit final if test changed**

\`\`\`powershell
git add tests/Feature/PumpLoanManagementTest.php tests/Feature/PumpMaintenanceManagementTest.php
git commit -m "test: protege empréstimos durante manutenção"
\`\`\`

