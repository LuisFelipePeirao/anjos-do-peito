# Alterações no banco de dados — Cobranças recorrentes de aluguel

## Registro da alteração

- Data: 23/09/2026
- Funcionalidade: controle interno de cobranças recorrentes para aluguéis de bombas de leite.
- Migration prevista: `add_recurring_billing_fields_to_cessoes_bombas_table`.
- Tabelas criadas: nenhuma.
- Tabelas alteradas: `cessoes_bombas` e `pagamentos_alugueis`.

## Tabela `cessoes_bombas`

| Campo incluído | Tipo de dado | Aceita nulo | Descrição prática / justificativa |
| --- | --- | --- | --- |
| `dia_vencimento` | `TINYINT UNSIGNED` | Sim | Armazena o dia mensal combinado para vencimento, de 1 a 31. Permite calcular o vencimento de cada parcela futura, respeitando o último dia de meses menores. É nulo em cessões gratuitas. |
| `forma_cobranca` | `VARCHAR(20)` | Sim | Armazena a modalidade de cobrança interna: `pix`, `dinheiro` ou `boleto`. Permite informar a equipe sobre o meio acordado, sem integração externa de pagamento. É nulo em cessões gratuitas. |
| `primeira_cobranca_em` | `DATE` | Sim | Data da primeira parcela do aluguel. Registra o marco inicial da recorrência e preserva a regra contratual original. É nulo em cessões gratuitas. |
| `proxima_cobranca_em` | `DATE` | Sim | Data de controle para o gerador de parcelas. Aponta a próxima competência a ser criada e evita depender de texto em observações. É nulo em cessões gratuitas ou contratos encerrados. |

Os campos são opcionais para preservar as cessões gratuitas e os registros históricos existentes. A aplicação exigirá os quatro campos quando o tipo da cessão for `aluguel`.

## Tabela `pagamentos_alugueis`

| Alteração | Elementos envolvidos | Descrição prática / justificativa |
| --- | --- | --- |
| Inclusão de índice único | `id_cessao`, `competencia` | Impede que a tarefa agendada crie duas parcelas para a mesma cessão e mesma competência mensal. Garante idempotência caso o agendador seja executado mais de uma vez ou seja reprocessado. |

Não serão criados novos campos nesta tabela. Campos existentes usados pelo controle: `competencia` identifica o mês da parcela; `valor` preserva o valor cobrado naquele mês; `data_vencimento` guarda a data limite; `data_pagamento` registra a baixa manual; `situacao` controla `pendente`, `vencido`, `pago` ou `cancelado`; e `observacao` guarda informações administrativas da parcela.

## Regras de integridade relacionadas

- Para aluguel, o sistema cria a primeira parcela pendente ao registrar a cessão.
- A tarefa agendada cria somente parcelas de cessões ativas e de tipo `aluguel`.
- Cessão devolvida não gera novas parcelas. Parcelas existentes permanecem para baixa ou cancelamento manual.
- Um vencimento no dia 29, 30 ou 31 usa o último dia quando o mês não possuir esse dia.
