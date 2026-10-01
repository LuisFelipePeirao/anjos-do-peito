# Design: manutenção de bombas de leite

## Objetivo

Permitir que a equipe registre, acompanhe e encerre manutenções de bombas de leite, preservando a disponibilidade correta do equipamento para empréstimo ou aluguel.

## Escopo

A manutenção usa a tabela existente `manutencoes_bombas`. Não haverá migration nem alteração no banco nesta entrega. O formulário será acessível a partir da tela de detalhes da bomba.

## Regras operacionais

- Somente bomba com situação `disponivel` pode abrir manutenção.
- Ao abrir manutenção, a bomba muda para `manutencao`.
- Bomba em `manutencao` não pode receber empréstimo ou aluguel; a validação existente de empréstimo exige bomba disponível.
- Bomba `alugada` ou emprestada não pode abrir manutenção. A ação aparece desabilitada com explicação acessível ao passar o mouse.
- Abertura aceita situação inicial `aberta` ou `em_andamento`.
- Conclusão exige data e hora final e muda a bomba para `disponivel`.
- Cancelamento registra observação opcional, marca a manutenção como `cancelada` e muda a bomba para `disponivel`.

## Formulário

Campos persistidos em `manutencoes_bombas`:

- `tipo`: obrigatório; preventiva, corretiva ou higienização.
- `data_inicio`: obrigatório; preenchido com data/hora atual por padrão.
- `situacao`: obrigatório; aberta ou em andamento.
- `descricao`: obrigatória.
- `observacao`: opcional.

`id_bomba` vem da rota e `id_usuario` vem do usuário autenticado. `data_fim` permanece nula até a conclusão.

## Interface

O botão no cabeçalho da bomba abre formulário/modal para equipamento disponível. Para equipamento alugado, emprestado, em manutenção ou baixado, ele permanece desabilitado com `title` explicando a indisponibilidade.

A aba Manutenções lista registros. Registros abertos ou em andamento oferecem ações para concluir e cancelar; concluídos e cancelados permanecem somente como histórico.

## Histórico operacional

A aba Histórico combina tabela existente de manutenção e dados da bomba. Mostra abertura, conclusão e cancelamento de manutenção, além de cadastro, saída, devolução e higienização. Nenhuma tabela adicional de auditoria será criada nesta fase.

## Testes

- Usuário autorizado abre manutenção de bomba disponível e bomba passa a manutenção.
- Abertura é rejeitada para bomba alugada, emprestada, em manutenção ou baixada.
- Conclusão exige data final, registra fim e libera bomba.
- Cancelamento libera bomba e preserva observação.
- Empréstimo é rejeitado enquanto bomba estiver em manutenção.
- Tela exibe ação desabilitada e informação para bomba indisponível.
