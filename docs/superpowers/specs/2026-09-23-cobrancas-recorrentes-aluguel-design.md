# Design: cobranças recorrentes de aluguel de bombas

## Objetivo

Controlar internamente as mensalidades de cessões de bombas do tipo aluguel. O sistema deve gerar parcelas recorrentes, indicar atraso, permitir baixa manual e manter histórico financeiro. Não há integração com Pix, boleto, e-mail ou WhatsApp nesta etapa.

## Contexto atual

O formulário de registro de cessão já coleta mensalidade, dia de vencimento, forma de cobrança, primeira cobrança e observações. Atualmente, `PumpLoanService` cria somente uma linha em `pagamentos_alugueis` e grava dia/forma de cobrança como texto em observação. Não existe comando agendado.

## Decisões

- O modelo adotado é parcelas mensais geradas por tarefa diária.
- `cessoes_bombas` armazena regra contratual e cursor da próxima cobrança.
- `pagamentos_alugueis` armazena cada parcela e seu resultado de pagamento.
- O primeiro pagamento é criado no registro da cessão; a tarefa cria os seguintes.
- A tarefa pode executar repetidamente sem duplicar registros, protegida por índice único em cessão e competência.
- Depois da devolução, parcelas existentes ficam abertas para decisão manual entre baixa e cancelamento; novas parcelas não são criadas.

## Banco de dados

`cessoes_bombas` receberá `dia_vencimento`, `forma_cobranca`, `primeira_cobranca_em` e `proxima_cobranca_em`. Os campos serão nulos para cessões gratuitas e obrigatórios pela validação para aluguéis.

`pagamentos_alugueis` receberá índice único em `id_cessao` e `competencia`. Não requer tabela nova, porque já representa uma parcela individual e possui valor, vencimento, pagamento, situação e observação.

O dicionário objetivo das alterações fica em `docs/Alterações_underline BD.md` e deverá ser atualizado junto de cada migration deste recurso.

## Formulário e persistência

`resources/views/pages/pumps/loans/create.blade.php` mantém os cinco campos financeiros, exibidos somente para aluguel. A interface deverá explicar que as parcelas são geradas automaticamente e baixadas pela equipe.

`StorePumpLoanRequest` valida mensalidade, vencimento, forma e primeira cobrança para aluguel. O serviço passa a armazenar esses valores em colunas próprias. A observação financeira permanece como observação da primeira parcela, sem carregar dados estruturais duplicados.

## Geração recorrente

Um comando Artisan, executado diariamente pelo Laravel Scheduler, processa cessões ativas de aluguel cuja `proxima_cobranca_em` seja hoje ou anterior. Para cada competência em aberto, ele cria parcela somente quando seu vencimento chegou e está dentro da `data_prevista_devolucao`; então avança `proxima_cobranca_em` em um mês. Competência bloqueada pelo fim previsto permanece no cursor, sem ser descartada.

O cálculo usa o último dia do mês quando o dia contratado não existir. Antes ou depois da geração, parcelas `pendente` com vencimento anterior a hoje passam para `atrasado`, enumeração já existente na tabela. Se renovação manual ampliar a data prevista, a próxima execução recupera competências bloqueadas cujo vencimento agora caiba no novo prazo; elas já nascem `atrasado` quando vencidas. Parcelas pagas ou canceladas nunca são modificadas por essa rotina.

## Operação financeira

Uma tela de cobranças lista parcelas por situação, competência e beneficiária. A equipe poderá registrar baixa manual, definindo data de pagamento e observação, ou cancelar parcela aberta com justificativa. Não haverá exclusão de parcelas, preservando trilha histórica.

## Erros e integridade

- A transação de criação grava cessão, primeira parcela e cursor de próxima cobrança de forma consistente.
- O índice único é proteção final contra dupla execução do comando.
- Se uma parcela já existir, a rotina a preserva e avança o cursor adequadamente.
- Campos financeiros permanecem nulos para empréstimos gratuitos.

## Testes

- Cria aluguel com regra contratual e primeira parcela.
- Cria empréstimo gratuito sem dados financeiros.
- Gera competências em atraso sem duplicar parcelas.
- Calcula corretamente fevereiro e meses sem dia 29, 30 ou 31.
- Marca pendente vencido como `atrasado`.
- Não gera parcelas depois da devolução.
- Registra pagamento e cancelamento manual sem apagar histórico.
