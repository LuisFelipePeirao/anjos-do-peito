# Spec de Design: Movimentacoes de Estoque

Data: 2026-08-29

## Contexto

O modulo atual de `doacoes-e-estoque` mistura cadastro de materiais, doadores, doacoes, distribuicoes e saldo em uma unica area. A mudanca separa a experiencia em duas superficies: itens de estoque para cadastro e consulta de materiais, e movimentacoes para registros operacionais de entrada, saida e ajuste.

As tabelas existentes ja representam o dominio necessario: `materiais`, `doadores`, `doacoes`, `doacoes_itens`, `distribuicoes`, `distribuicoes_itens` e `estoque_movimentacoes`. A implementacao deve reaproveitar essa base, evitar tabela nova e manter controllers finos, com regras em request/service/model.

## Escopo

- Renomear a experiencia de listagem atual para itens de estoque, mantendo as views existentes em `resources/views/pages/donations`.
- Reaproveitar `resources/views/pages/donations/distributions/create.blade.php` como tela unificada de registro de movimentacao.
- Criar listagem propria de movimentacoes com DataTable.
- Criar tela show propria para detalhe de uma movimentacao/lancamento.
- Manter cadastro de novo doador dentro do fluxo de entrada.
- Registrar entrada, saida e ajuste de estoque.
- Validar ajuste com observacao obrigatoria.
- Validar saida e ajuste de subtracao para nao deixar saldo negativo.

Nao inclui edicao/exclusao de movimentacoes, novas tabelas, API publica, consulta externa de doadores ou refatoracao visual ampla fora do modulo de estoque.

## Navegacao e Rotas

- Menu lateral deve mostrar `Itens de estoque` apontando para a listagem atual de materiais.
- Menu lateral deve mostrar `Movimentacoes` apontando para a nova listagem de movimentacoes.
- A listagem de itens usa `GET /doacoes-e-estoque` e continua nomeada como `donations.index` para reduzir impacto.
- O detalhe de item usa `GET /doacoes-e-estoque/{material}` e continua nomeado como `donations.show`.
- O cadastro de item usa as rotas atuais `donations.materials.create` e `donations.materials.store`.
- A nova listagem de movimentacoes usa `GET /movimentacoes` com rota `movements.index`.
- O formulario unificado usa `GET /movimentacoes/nova` com rota `movements.create`.
- O envio unificado usa `POST /movimentacoes` com rota `movements.store`.
- O detalhe de movimentacao usa `GET /movimentacoes/{movement}` com rota `movements.show`.
- As rotas antigas `donations.distributions.create` e `donations.distributions.store` devem continuar funcionando como alias ou redirecionamento para evitar quebra de links internos existentes.

## Fluxos

### Itens de estoque

A tela atual `pages.donations.index` passa a apresentar o texto de itens de estoque, com DataTable de materiais, categoria, saldo, situacao e ultima movimentacao. Seus botoes principais sao `Registrar movimentacao` e `Novo item`.

O show de material continua mostrando saldo, indicadores e historico do material, mas os textos devem usar `movimentacoes` em vez de `distribuicoes` quando o conceito for geral.

### Movimentacoes index

A tela `pages.movements.index` lista registros operacionais. Cada linha representa um lancamento de estoque: doacao de entrada, distribuicao de saida ou ajuste manual. A DataTable deve mostrar data, tipo, origem/destino, materiais, responsavel e situacao.

Filtros esperados: busca textual, tipo (`todos`, `entrada`, `saida`, `ajuste`) e situacao/origem quando aplicavel. A primeira coluna deve linkar para o show do lancamento.

### Movimentacoes show

A tela `pages.movements.show` mostra tipo, data, responsavel, origem/destino, situacao, observacao e itens envolvidos. Para entrada, origem e doador. Para saida, destino e beneficiaria. Para ajuste, material, operacao de adicionar ou subtrair, quantidade e observacao.

### Registrar movimentacao

Ao abrir `movements.create` sem tipo, a tela mostra escolha entre `Entrada`, `Saida` e `Ajuste`. Ao escolher, navega para a mesma tela com `?tipo=entrada`, `?tipo=saida` ou `?tipo=ajuste`.

Entrada:
- Exibe doador, botao `Novo doador`, data e hora, situacao, observacao e itens recebidos.
- Permite cadastrar quantidade por item.
- Quando situacao for `recebida`, cria `doacoes`, `doacoes_itens` e `estoque_movimentacoes` com tipo `entrada`.

Saida:
- Exibe beneficiaria, data e hora, situacao, observacao e itens entregues.
- Usuario informa quantidade por item; o sistema baixa estoque automaticamente.
- Nao permite saldo negativo, inclusive quando o mesmo material aparece em mais de uma linha.
- Quando situacao for diferente de `cancelada`, cria `distribuicoes`, `distribuicoes_itens` e `estoque_movimentacoes` com tipo `saida`.

Ajuste:
- Exibe material, operacao (`adicionar` ou `subtrair`), quantidade, data e hora e observacao.
- Observacao e obrigatoria.
- `Adicionar` cria `estoque_movimentacoes` com tipo `ajuste` e quantidade positiva.
- `Subtrair` cria `estoque_movimentacoes` com tipo `ajuste` e quantidade negativa.
- Subtracao nao permite saldo negativo.

## Arquitetura

Controllers devem apenas receber request validado, chamar service e escolher view/redirect. A regra de negocio fica em service. Requests validam os campos comuns e condicionais por tipo.

`DonationStockService` pode continuar responsavel por dados e operacoes de itens de estoque. Um novo service, `StockMovementService`, deve concentrar index/show de movimentacoes e o store unificado. Ele pode reaproveitar metodos publicos de saldo/opcoes do service atual quando fizer sentido; se um metodo privado precisar ser compartilhado, deve virar metodo publico pequeno e nomeado pelo comportamento.

O model `EstoqueMovimentacao` deve expor helpers de apresentacao quando isso reduzir duplicacao nas telas, por exemplo labels de tipo ou origem. Helpers nao devem executar regra transacional.

## Validacao e Autorizacao

- Criacao de materiais, doadores e movimentacoes continua restrita a usuarios que podem gerenciar atendimentos.
- Entrada exige `tipo=entrada`, doador, data, situacao valida, pelo menos um item e quantidade positiva.
- Saida exige `tipo=saida`, beneficiaria, data, situacao valida, pelo menos um item e quantidade positiva.
- Ajuste exige `tipo=ajuste`, material, operacao valida, quantidade positiva, data e observacao preenchida.
- Saida e ajuste de subtracao fazem validacao de saldo no service para evitar corrida entre linhas repetidas e garantir regra no servidor.

## Critérios de Aceite

- A tela de itens nao apresenta mais o modulo como `Doacoes e estoque`; ela apresenta `Itens de estoque`.
- Existe menu e tela de `Movimentacoes` com index e show.
- O botao `Registrar movimentacao` abre escolha de tipo antes do preenchimento.
- Entrada reaproveita fluxo de doacao e permite criar doador.
- Saida reaproveita fluxo de distribuicao, permite informar quantidades por item e bloqueia saldo negativo.
- Ajuste permite adicionar ou subtrair estoque de um material e exige observacao.
- Nenhuma regra nova de estoque fica implementada diretamente em controller.
- Testes de feature cobrem index/show de movimentacoes, escolha de tipo, entrada, saida e ajuste.
