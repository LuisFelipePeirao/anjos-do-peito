# Testes automatizados — evidências para o TCC

## 1. Objetivo e escopo

Este documento registra a revisão e a execução dos testes automatizados do sistema VITA, destinado à ONG Anjos do Peito. O recorte priorizado contempla: atendimento às beneficiárias, gerenciamento de doações e estoque e empréstimos/alugueis de bombas de leite.

Foram inspecionados os diretórios `tests/Unit` e `tests/Feature`, o arquivo `tests/Pest.php`, `phpunit.xml`, Services, Controllers e Form Requests relacionados. A atividade não alterou regras de negócio, migrations, arquivos `.env` nem banco de dados de desenvolvimento/produção.

## 2. Tecnologias, ambiente e configuração de execução

| Item | Evidência |
| --- | --- |
| Data e horário da execução final | 06/10/2026, 18:16:31 a 18:16:57 (UTC-03:00) |
| PHP | 8.5.9 |
| Laravel | 13.24.0 |
| Pest | 5.1.0 (`pestphp/pest` bloqueado no Composer) |
| Commit analisado | `d9152b8ebd74172f7d5066fe6a7da7dd132e51e3` |
| Banco de testes | SQLite em memória (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`), definido em `phpunit.xml` |
| Isolamento | Os testes prioritários utilizam `RefreshDatabase`; portanto, tabelas e dados existem somente durante a execução no banco SQLite efêmero. |

O `.env` local aponta para MySQL (`anjos_do_peito`), mas não foi utilizado pela suíte: o `phpunit.xml` sobrescreve a conexão durante a inicialização do runner. Para evitar concorrência com processos Apache locais no cache de Blade, a execução definiu somente no processo de teste `VIEW_COMPILED_PATH=storage/framework/testing-views`; essa configuração não foi gravada em arquivos do projeto.

## 3. Inventário dos testes automatizados existentes

O projeto utiliza Pest, com `Tests\TestCase` como base para testes de funcionalidade. A suíte PHP contém 128 declarações diretas de testes Pest; datasets fazem a execução final alcançar 140 testes. Há ainda o arquivo JavaScript `tests/js/unsaved-form-guard.test.js`, que não integra o comando `php artisan test`.

| Área/arquivo | Declarações Pest |
| --- | ---: |
| `tests/Unit/ExampleTest.php` | 1 |
| Atendimento: `AttendanceManagementTest.php` e `AttendanceTaxonomyManagementTest.php` | 24 |
| Estoque e doações: `DonationStockManagementTest.php` e `StockMovementManagementTest.php` | 24 |
| Bombas, manutenção, cobrança e pagamento | 27 |
| Beneficiárias | 10 |
| Autenticação e usuários | 20 |
| Relatórios, dashboard, componentes, acessibilidade e demais telas | 22 |
| **Total de declarações PHP** | **128** |

## 4. Cenários revisados

### Atendimento

`AttendanceManagementTest.php` já cobria criação, rascunho, início, continuação, finalização e bloqueio de edição de atendimento realizado. O fluxo de continuação chama `AttendanceService::saveContinuation` e mantém o atendimento em `em_atendimento` para rascunhos, mudando para `realizado` somente na finalização. Foi acrescentada uma asserção de banco para demonstrar que o resumo clínico parcial é persistido durante a continuação.

### Doações e estoque

`DonationStockManagementTest.php` e `StockMovementManagementTest.php` já cobriam entradas, saídas, distribuição vinculada à beneficiária, saldo insuficiente, pendências e cancelamentos. O serviço `StockMovementService::createAdjustment` valida a disponibilidade para ajustes de subtração. Foi acrescentado um cenário que registra saldo 5, tenta subtrair 6 e confirma tanto a inexistência de movimento de ajuste quanto a preservação do saldo em 5 unidades.

### Bombas de leite

`PumpLoanManagementTest.php` e `PumpManagementTest.php` cobrem empréstimo gratuito, aluguel com cobrança pendente, vínculo com beneficiária, rejeição de equipamento indisponível, devolução, mudança de situação e preservação do registro de cessão. Não foi necessário acrescentar cenário de negócio neste fluxo.

## 5. Matriz de rastreabilidade para requisitos e regras de negócio

Não foram localizados identificadores formais de requisitos funcionais (RF) ou regras de negócio (RN) no repositório analisado. Para não criar correspondências presumidas, a coluna correspondente é registrada como **não identificada no repositório**. A rastreabilidade abaixo usa somente comportamentos observáveis nos testes e código.

| Regra/comportamento verificável | RF/RN formal | Testes relacionados |
| --- | --- | --- |
| Atendimento iniciado pode receber continuação em rascunho e ser finalizado | Não identificado no repositório | `AttendanceManagementTest.php` — continuação clínica |
| Atendimento realizado final não pode ser editado | Não identificado no repositório | `AttendanceManagementTest.php` — bloqueio de edição |
| Ajuste de saída não pode reduzir estoque abaixo de zero | Não identificado no repositório | `StockMovementManagementTest.php` — subtração inválida |
| Saída pendente não consome saldo; cancelamento e confirmação seguem estados próprios | Não identificado no repositório | `StockMovementManagementTest.php` — pendência, confirmação e cancelamento |
| Bomba disponível pode ser cedida à beneficiária; bomba indisponível é recusada | Não identificado no repositório | `PumpLoanManagementTest.php` — empréstimo e indisponibilidade |
| Devolução encerra cessão e devolve a bomba à situação disponível | Não identificado no repositório | `PumpManagementTest.php` — devolução |

## 6. Resultados dos cenários prioritários

| Cenário | Arquivo e método Pest | Comportamento esperado | Comportamento observado na execução final | Resultado |
| --- | --- | --- | --- | --- |
| Atendimento | `AttendanceManagementTest.php` — `starts an attendance and saves or finalizes its clinical continuation` | Iniciar, salvar rascunho, preservar resumo, exigir dados para finalizar e concluir atendimento | Situação e rascunho persistiram; resumo parcial foi encontrado em `atendimento_detalhes`; finalização exigiu categoria e procedimento | Aprovado |
| Atendimento | `AttendanceManagementTest.php` — `locks final realized attendances in the interface and backend` | Impedir edição posterior de atendimento realizado | Rotas de edição e atualização retornaram bloqueio | Aprovado |
| Estoque | `StockMovementManagementTest.php` — `keeps stock and movement history unchanged after an invalid adjustment subtraction` | Rejeitar retirada maior que saldo sem alterar estoque ou histórico | Erro de quantidade, zero movimentos de ajuste e saldo `5 pacotes` | Aprovado |
| Estoque | `StockMovementManagementTest.php` — cenários de saídas pendentes/canceladas | Não consumir pendências e tratar confirmação/cancelamento conforme estado | Os cenários prioritários passaram | Aprovado |
| Bombas | `PumpLoanManagementTest.php` — `registers a free pump loan and marks pump as borrowed` | Criar cessão vinculada e atualizar situação | Cessão e situação `alugada` verificadas em banco | Aprovado |
| Bombas | `PumpLoanManagementTest.php` — `rejects unavailable pumps for new loans` | Impedir cessão de bomba indisponível | Validação retornada para o campo da bomba | Aprovado |
| Bombas | `PumpManagementTest.php` — `shows return action for borrowed pumps and finalizes their current loan` | Registrar devolução, preservar histórico e disponibilizar equipamento | Cessão finalizada, usuário/data de devolução registrados e bomba disponível | Aprovado |

## 7. Comandos e saídas reais

### Execução inicial dos cenários prioritários

```powershell
php artisan test tests/Feature/AttendanceManagementTest.php tests/Feature/StockMovementManagementTest.php tests/Feature/DonationStockManagementTest.php tests/Feature/PumpLoanManagementTest.php tests/Feature/PumpManagementTest.php
```

Saída: **60 testes, 57 aprovados, 3 falhos, 392 assertions**. As falhas foram uma expectativa de classe CSS desatualizada no atendimento e duas ocorrências de acesso negado ao cache compartilhado de views (`storage/framework/views`) durante renderização.

### Nova execução dos cenários prioritários

```powershell
$env:VIEW_COMPILED_PATH = (Join-Path (Get-Location) 'storage\framework\testing-views')
php artisan test --compact tests/Feature/AttendanceManagementTest.php tests/Feature/StockMovementManagementTest.php tests/Feature/DonationStockManagementTest.php tests/Feature/PumpLoanManagementTest.php tests/Feature/PumpManagementTest.php
```

Saída: **61 testes aprovados, 405 assertions, 0 falhas**, em 12,194 s.

### Execução final da suíte completa

```powershell
$env:VIEW_COMPILED_PATH = (Join-Path (Get-Location) 'storage\framework\testing-views')
php artisan test --compact
```

Saída: **140 testes aprovados, 1.313 assertions, 0 falhas**, em 24,200 s. O comando `php artisan test` também foi executado antes da versão compacta; a opção `--compact` foi usada na evidência final para obter a contagem estruturada do Pest.

Não foram reportados testes ignorados ou pendentes na saída final do Pest.

## 8. Falhas encontradas e correções implementadas

Foram encontradas expectativas de apresentação desatualizadas, sem efeito nas regras de negócio. O código renderiza o indicador obrigatório com `text-[#b42336]`, enquanto cinco testes esperavam `text-[#c2414b]`. Foram atualizadas somente as expectativas em:

- `tests/Feature/AttendanceManagementTest.php`;
- `tests/Feature/PumpManagementTest.php`;
- `tests/Feature/BeneficiaryManagementTest.php`;
- `tests/Feature/MaterialFloatingTextareaTest.php`;
- `tests/Feature/MaterialSelectTest.php`.

Também foi identificada concorrência eventual no diretório compartilhado de views compiladas, com erro `rename(...): Acesso negado (code: 5)`. A execução foi isolada com diretório de cache exclusivo apenas no processo de teste; nenhuma configuração persistente foi alterada.

Além disso, foram implementadas duas verificações de cobertura: persistência do resumo parcial de continuação de atendimento e preservação do estoque/histórico após ajuste inválido. Não houve alteração em Services, Models, Controllers ou Form Requests.

## 9. Síntese quantitativa

| Execução | Testes | Assertions | Aprovados | Falhos | Ignorados/pendentes |
| --- | ---: | ---: | ---: | ---: | ---: |
| Prioritária inicial | 60 | 392 | 57 | 3 | Não reportados |
| Prioritária após correções | 61 | 405 | 61 | 0 | Não reportados |
| Completa final | 140 | 1.313 | 140 | 0 | Não reportados |

## 10. Trechos representativos para quadros de código no TCC

Os seguintes trechos podem ser usados como quadros, citando arquivo e linha da revisão documentada:

| Finalidade | Referência |
| --- | --- |
| Início, rascunho e finalização da continuação de atendimento | `tests/Feature/AttendanceManagementTest.php`, linha 252 |
| Bloqueio de alteração em atendimento finalizado | `tests/Feature/AttendanceManagementTest.php`, linha 213 |
| Ajuste inválido preservando saldo e histórico | `tests/Feature/StockMovementManagementTest.php`, linha 318 |
| Ajuste de estoque no serviço | `app/Services/StockMovementService.php`, linha 290 |
| Empréstimo de bomba | `tests/Feature/PumpLoanManagementTest.php`, linha 72 |
| Devolução e preservação da cessão | `tests/Feature/PumpManagementTest.php`, linha 229 |
| Continuação no serviço | `app/Services/AttendanceService.php`, linha 152 |

## 11. Limitações e funcionalidades não cobertas

- A evidência se limita à suíte automatizada local e ao banco SQLite em memória; não substitui testes de aceitação com usuários da ONG.
- Não foram produzidas métricas percentuais de cobertura de código, pois não há ferramenta de cobertura configurada e executada nesta atividade.
- O teste JavaScript de proteção contra perda de formulário não é executado por `php artisan test`; seu runner não foi acionado nesta atividade.
- Não foi possível relacionar os testes a RFs/RNs formais, porque tais identificadores não foram encontrados no repositório.
- Testes visuais de Blade verificam estrutura HTML e classes, não a renderização em navegadores reais.

## 12. Texto sugerido para o TCC

Os testes automatizados do sistema VITA foram implementados com o framework Pest sobre a infraestrutura de testes do Laravel. A execução foi realizada em ambiente isolado, configurado com banco SQLite em memória, o que permitiu recriar os dados necessários a cada cenário sem utilizar a base MySQL local do sistema. Na execução final, a suíte apresentou 140 testes aprovados e 1.313 assertions, sem falhas reportadas.

Nos processos prioritários, os testes confirmaram o ciclo de atendimento, incluindo início, salvamento parcial da continuação, persistência do resumo clínico, finalização e bloqueio de alterações posteriores. No controle de estoque, foram verificadas entradas, saídas, distribuições pendentes e canceladas, além da rejeição de ajustes que excedem o saldo disponível sem criação indevida de movimentação. Para bombas de leite, os testes validaram empréstimo, associação com beneficiária, indisponibilidade de equipamento, devolução, atualização de situação e preservação do histórico de cessão.

Durante a revisão, foram identificadas expectativas visuais desatualizadas em testes de componentes, corrigidas sem modificar regras de negócio. Também foi adotado um diretório exclusivo para views compiladas durante a execução, evitando interferência de processos locais no cache compartilhado. Assim, os resultados documentados correspondem às execuções efetivamente realizadas no commit informado neste documento.
