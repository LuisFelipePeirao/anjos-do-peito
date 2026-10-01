# Reservas de saída e baixa de movimentações

## Objetivo

Permitir registrar saídas como reservas pendentes sem consumi-las no estoque real ou nos relatórios, mas bloqueando os itens para novas saídas. Quando a beneficiária retirar os itens, a baixa confirma a saída. Quando não retirar, o cancelamento libera a reserva.

## Estados e transições

Distribuições de saída continuam usando `pendente`, `entregue` e `cancelada`.

- `pendente`: reserva ativa. Itens não podem ser usados por outra saída.
- `entregue`: retirada confirmada. Saída passa a compor estoque real e relatórios.
- `cancelada`: reserva desfeita. Itens não bloqueiam saldo e não compõem relatórios.

Somente distribuições pendentes podem receber baixa ou cancelamento. Repetir qualquer ação depois da primeira deve falhar sem mudança de dados.

## Datas

Não haverá coluna nem tabela nova. `distribuicoes.data_hora` guarda a data/hora da reserva enquanto pendente. Ao dar baixa, o sistema substitui esse valor pela data/hora atual da retirada. Relatórios de saída usam, portanto, a data/hora efetiva de retirada.

## Saldos

Existirão duas regras explícitas, aplicadas nos serviços de estoque:

- Saldo disponível para registrar nova saída: entradas + ajustes - saídas vinculadas a distribuições `pendente` ou `entregue`. Distribuições canceladas não têm impacto.
- Estoque real, consumo, indicadores e relatórios: entradas + ajustes - saídas vinculadas somente a distribuições `entregue`. Pendentes e canceladas não têm impacto.

Consultas SQL de relatórios devem relacionar movimentação, item de distribuição e distribuição para filtrar o status, em vez de considerar toda movimentação de tipo `saida` como efetivada.

## Tela de detalhes da movimentação

O detalhe exibe situação da distribuição. Para saída pendente, mostra também observação registrada na distribuição, preservando a observação padrão da movimentação (`Saída por movimentação.`).

Quando a situação for pendente, exibe ações:

- **Dar baixa**: confirma retirada, altera situação para `entregue` e substitui `data_hora` pelo horário atual.
- **Cancelar**: altera situação para `cancelada` e libera reserva.

Após qualquer transição, redireciona ao detalhe com mensagem de sucesso. Ações não aparecem para outros tipos de movimentação ou estados finais.

## Interface HTTP e autorização

Rotas protegidas de atualização recebem a movimentação exibida. Serviço localiza sua distribuição associada, exige que seja saída pendente e executa transição em transação. A mesma permissão atual para gerenciar movimentações controla as ações.

## Tratamento de erros

Movimentação sem distribuição, estado não pendente ou condição concorrente já alterada respondem com conflito e não alteram dados. A baixa usa horário do servidor no instante da transação.

## Testes

Testes de feature devem cobrir:

- criação pendente bloqueando uma segunda saída que exceda saldo;
- pendente ausente de estoque real e relatórios;
- baixa alterando situação, data/hora e inclusão em estoque real/relatórios;
- cancelamento liberando reserva e mantendo saída fora de relatórios;
- ações visíveis somente em pendências e rejeição de nova baixa/cancelamento após estado final.
