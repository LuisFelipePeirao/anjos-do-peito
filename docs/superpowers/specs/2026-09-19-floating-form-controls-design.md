# Padronização de controles flutuantes em formulários

## Objetivo

Padronizar todos os formulários CRUD Blade em `resources/views` com labels
flutuantes: `x-material.floating-input`, `x-material.select` e um novo
`x-material.floating-textarea`.

O resultado deve manter a aparência atual dos controles, com label centralizado
quando vazio e label elevado quando houver foco ou valor. Campos obrigatórios
devem manter a validação nativa e o asterisco vermelho.

## Escopo

Migrar formulários de criação, edição, continuação e modais CRUD de:

- beneficiárias e crianças;
- usuários, exceto senha;
- bombas, empréstimos e renovações;
- atendimentos, campos clínicos e modais de local, categoria e procedimento;
- materiais, doadores e distribuições de estoque, incluindo templates Blade
  usados para linhas dinâmicas.

Também migrar o componente compartilhado `x-app.entity-manager-modal`.

Ficam fora do escopo:

- autenticação e campos de senha;
- filtros e relatórios;
- `hidden`, rádio, checkbox e controles sem label de formulário;
- templates de HTML criados exclusivamente por JavaScript, salvo quando já
  renderizam um componente Blade no template inicial.

## Componentes

### Floating Input

Reutilizar o componente existente para `text`, `email`, `tel`, `number`,
`date`, `time` e `datetime-local`. Cada migração preserva `name`, `id`,
`old()`, valor de edição, placeholder de exemplo, máscara, `data-*`,
`inputmode`, `min`, `max`, `maxlength`, `disabled` e classes de grid.

### Select

Reutilizar o componente existente. O label interno substitui label externo e
placeholder genérico. O select preserva opções, valor selecionado, atributos
de integração e estado `required`.

### Floating Textarea

Criar componente com interface paralela ao Floating Input: `name`, `label`,
`value`, `placeholder`, `required`, `wrapperClass` e atributos adicionais.
O label fica elevado quando houver foco ou conteúdo. A altura e redimensionamento
atuais são preservados.

## Validação e compatibilidade

`required` continua chegando ao controle HTML e exibe asterisco vermelho.
Erros do error bag padrão são renderizados pelos novos componentes. Campos de
modais que usam named error bag mantêm mensagem externa para não alterar o
contrato de validação atual.

Não alterar regras de back-end, rotas, payloads ou JavaScript de negócio.
Campos condicionais, máscaras e preenchimento por CEP continuam usando seus
mesmos seletores e atributos.

## Verificação

Adicionar testes de renderização para Floating Textarea e ampliar testes de
telas principais para confirmar componentes, atributos críticos, `required` e
valores selecionados. Executar Pest completo, `git diff --check` e build Vite.
