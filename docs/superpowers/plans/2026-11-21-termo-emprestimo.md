# Plano de implementação do termo de empréstimo

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Gerar e reemitir termo com dados congelados, somente mediante opção Sim.

**Architecture:** Snapshot JSON na cessão dentro da transação existente. Endpoint autenticado renderiza exclusivamente snapshot em Blade/Dompdf. Modal usa endpoint e histórico oferece emissão.

**Tech Stack:** Laravel, Blade, Dompdf, JavaScript existente.

**Spec:** docs/superpowers/specs/2026-11-21-termo-emprestimo-design.md

## Restrições

Sem PDF armazenado, sem assinatura automática, sem reconstruir dados históricos ausentes. Preservar contratos de cadastro e permissões de gestão.

## Pontos de revisão

Opção Não; registros anteriores sem snapshot; acesso indevido; alterações posteriores de dados/pagamentos; falha de geração sem perda do cadastro.

## Tarefa 1: Snapshot e emissão

Arquivos: migration de cessoes_bombas, CessaoBomba, PumpLoanService, PumpLoanController, routes/web.php, view do PDF e PumpLoanManagementTest.

- [x] Escrever e executar testes para snapshot opt-in, congelamento, PDF e autorização; confirmar falhas antes da implementação.
- [x] Salvar termo_dados nullable na transação; criar endpoint pumps.loans.term que retorna application/pdf exclusivamente do snapshot.
- [x] Executar testes e confirmar aprovação.

## Tarefa 2: Modal e histórico

Arquivos: PumpService, show.blade.php, create.blade.php, componente de modal e resources/js/app.js.

- [x] Testar abertura automática apenas com Sim e botão apenas para snapshot existente.
- [x] Flash do identificador do termo após cadastro; incluir modal com iframe, fechar, abrir e baixar. Histórico usa ações existentes para emissão.
- [x] Rodar testes relacionados, build, Pint e verificação visual/detector.

## Validação

19 testes relacionados aprovados. Suíte geral: 155/157; falhas em AccessibilityContrastTest (paleta de floating-input) e BeneficiaryManagementTest (indicador obrigatório de nome), sem alterações nesses arquivos. Build e Pint aprovados; detector sem achados. PDF A4 renderizado e inspecionado, modal verificado em desktop e 375px com fixture sintética. Revisão independente sem achados. Migração aditiva aplicada no banco local. Não houve deploy nem reconstrução de termos antigos.
