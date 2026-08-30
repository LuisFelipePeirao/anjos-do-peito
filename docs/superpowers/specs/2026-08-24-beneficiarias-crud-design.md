# Spec de Design: CRUD de Beneficiárias e Bebês

Data: 2026-08-24

## Contexto

O módulo de beneficiárias existe apenas como protótipo Blade. Esta entrega o conecta às tabelas `beneficiarias`, `enderecos`, `cep` e `criancas`, preservando o padrão visual e os componentes reutilizáveis do sistema.

## Escopo

- CRUD persistente de beneficiárias para usuários autenticados.
- Endereço opcional, persistido pelas tabelas `cep` e `enderecos`.
- Listagem com busca por nome ou CPF e filtro de situação.
- Inativação no perfil da beneficiária, sem exclusão física.
- Seção de bebês no perfil, com criação, edição e exclusão por modal.

Não inclui consulta externa de CEP, atendimentos, empréstimos, doações ou campos que não tenham suporte nas migrations atuais.

## Dados e Regras

- A beneficiária armazena nome, CPF, e-mail, telefone principal, telefone alternativo, origem do cadastro e situação.
- Toda nova beneficiária será criada com situação `ativo`; somente a ação própria do perfil pode torná-la `inativo`.
- CPF deve ter 11 dígitos válidos e ser único no banco e na aplicação.
- E-mail, telefones e origem são obrigatórios, conforme a migration.
- Endereço é opcional. Quando iniciado, CEP, cidade e UF são obrigatórios; logradouro, bairro, número e complemento permanecem opcionais conforme o schema.
- Uma criança pertence a uma única beneficiária e exige nome, data de nascimento e sexo (`masculino`, `feminino` ou `indefinido`).

## Fluxos

1. A listagem mostra beneficiárias ativas por padrão, permite consultar todas e direciona ao perfil ou à edição.
2. Criação e edição reutilizam o mesmo formulário e usam `x-material.select` para origem do cadastro e UF.
3. O perfil mostra o cadastro, endereço e os bebês vinculados. A pessoa usuária cria ou altera um bebê em modal e confirma sua exclusão.
4. A inativação usa o `x-app.confirm-modal`, preserva os registros e altera apenas `situacao`.

## Rotas

- `GET /beneficiarias`, `GET /beneficiarias/nova`, `POST /beneficiarias`.
- `GET /beneficiarias/{beneficiaria}`, `GET /beneficiarias/{beneficiaria}/editar`, `PUT /beneficiarias/{beneficiaria}`.
- `PATCH /beneficiarias/{beneficiaria}/inativar`.
- `POST /beneficiarias/{beneficiaria}/criancas`, `PUT /beneficiarias/{beneficiaria}/criancas/{crianca}`, `DELETE /beneficiarias/{beneficiaria}/criancas/{crianca}`.

## Critérios de Aceite

- Dados simulados não são mais usados nas telas de beneficiárias.
- Campos do protótipo sem coluna persistente não aparecem na criação nem na edição.
- CPF duplicado ou inválido retorna erro ao formulário.
- A beneficiária pode ter vários bebês e as ações sempre respeitam o vínculo com o perfil atual.
- A suite cobre autorização, CRUD, filtro, endereço, inativação e crianças.
