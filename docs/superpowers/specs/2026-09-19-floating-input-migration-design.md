# Migração de Floating Input

## Objetivo

Substituir os inputs nativos de criação, edição e modais pelo componente
`x-material.floating-input`. O componente mantém label flutuante, posição
vertical centralizada do texto e marcador vermelho para campos obrigatórios.

## Escopo

Migrar inputs Blade dos tipos `text`, `email`, `tel`, `number`, `date`,
`time` e `datetime-local` usados nos formulários de:

- beneficiárias e modal de crianças;
- usuários, exceto os campos de senha;
- bombas e renovação de empréstimo;
- registro de empréstimos;
- atendimentos e modais de local, categoria e procedimento;
- materiais, doadores e distribuições de estoque.

Ficam fora do escopo: selects, textareas, rádio, hidden inputs, autenticação,
senhas, filtros/relatórios e inputs adicionados por JavaScript.

## Componente e integração

Cada campo migrado informa `name`, `label`, `value`, `placeholder`, `type` e
`wrapper-class` quando houver coluna responsiva. Os atributos restantes passam
inalterados para o elemento HTML, incluindo `data-*`, `inputmode`, `min`,
`max`, `maxlength`, `disabled` e máscaras.

O parâmetro `required` mantém a validação nativa e exibe o asterisco vermelho.
Os demais campos não exibem marcador.

Erros continuam no componente para o error bag padrão. Campos de modais com
error bag nomeado mantêm sua mensagem externa até o componente receber suporte
explícito a esse caso.

## Compatibilidade

Valores de `old()` e valores de edição continuam sendo passados ao componente.
Campos condicionais de aluguel preservam `disabled` e seus seletores
`data-pump-billing-field`. Campos de endereço preservam as máscaras e seletores
usados no preenchimento por CEP.

Linhas de distribuição inseridas no navegador não serão alteradas: elas são
templates JavaScript, não campos Blade persistentes.

## Verificação

Adicionar ou ampliar testes de renderização para confirmar:

- uso do componente nas páginas principais;
- asterisco em campos obrigatórios;
- preservação de atributos críticos em campos com máscara, limites ou estado
  condicional.

Executar a suíte Pest completa, checagem de diff e build de produção Vite.
