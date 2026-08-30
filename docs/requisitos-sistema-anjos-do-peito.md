# Requisitos do Sistema — ONG Anjos do Peito

Este documento consolida os **Requisitos Funcionais (RF)**, **Requisitos Não Funcionais (RNF)** e **Regras de Negócio (RN)** definidos para o sistema de informação desenvolvido para a ONG Anjos do Peito.

O sistema tem como objetivo apoiar e integrar os processos relacionados ao cadastro e acompanhamento de beneficiárias, atendimentos, gerenciamento de doações e estoque, aluguel e empréstimo de bombas de leite, geração de relatórios e administração de usuários internos.

---

# 1. Requisitos Funcionais

Os requisitos funcionais descrevem as funcionalidades que deverão ser disponibilizadas pelo sistema.

## 1.1 Autenticação

### RF01 — Realizar login
O sistema deve permitir ao usuário realizar o login.

### RF02 — Realizar logout
O sistema deve permitir ao usuário realizar o logout.

---

## 1.2 Beneficiárias

### RF03 — Manter beneficiária
O sistema deve permitir ao usuário manter beneficiárias, contemplando as operações de cadastro, consulta, atualização e exclusão (CRUD).

### RF04 — Pesquisar beneficiária
O sistema deve permitir ao usuário pesquisar uma beneficiária cadastrada.

---

## 1.3 Atendimentos

### RF05 — Manter atendimentos
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Enfermeira** manter atendimentos, contemplando as operações de cadastro, consulta, atualização e exclusão (CRUD).

### RF06 — Relacionar beneficiária ao atendimento
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Enfermeira** relacionar uma beneficiária a um atendimento.

### RF07 — Consultar atendimentos da beneficiária
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Enfermeira** consultar os atendimentos vinculados a uma beneficiária.

---

## 1.4 Doadores, doações e estoque

### RF08 — Manter doadores
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** manter doadores, contemplando as operações de cadastro, consulta, atualização e exclusão (CRUD).

### RF09 — Manter itens recebidos por doação
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** manter itens recebidos por doação, contemplando as operações de cadastro, consulta, atualização e exclusão (CRUD).

### RF10 — Registrar entrada de doações
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** registrar a entrada de doações.

### RF11 — Consultar estoque
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** consultar os itens disponíveis em estoque.

### RF12 — Registrar saída de itens
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** registrar a saída de itens do estoque.

### RF13 — Relacionar distribuição à beneficiária
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** relacionar a distribuição de itens a uma beneficiária cadastrada.

---

## 1.5 Bombas de leite

### RF14 — Manter bombas de leite
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** manter bombas de leite, contemplando as operações de cadastro, consulta, atualização e exclusão (CRUD).

### RF15 — Registrar empréstimo
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** registrar o empréstimo de uma bomba de leite.

### RF16 — Registrar aluguel
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** registrar o aluguel de uma bomba de leite.

### RF17 — Relacionar bomba de leite à beneficiária
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** relacionar uma bomba de leite a uma beneficiária cadastrada.

### RF18 — Registrar devolução
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** registrar a devolução de uma bomba de leite.

### RF19 — Consultar histórico da bomba
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** consultar o histórico de utilização de uma bomba de leite cadastrada.

---

## 1.6 Relatórios

### RF20 — Gerar relatório de beneficiárias
O sistema deve permitir ao usuário associado ao perfil de **Administrador** gerar relatórios predefinidos sobre as beneficiárias cadastradas.

### RF21 — Gerar relatório de atendimentos
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Enfermeira** gerar relatórios predefinidos sobre os atendimentos registrados.

### RF22 — Gerar relatório de doações
O sistema deve permitir ao usuário associado ao perfil de **Administrador** gerar relatórios predefinidos sobre as doações registradas.

### RF23 — Gerar relatório de estoque
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** gerar relatórios predefinidos sobre o estoque.

### RF24 — Gerar relatório de bombas de leite
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** gerar relatórios predefinidos sobre as bombas de leite.

### RF25 — Filtrar relatórios por período
O sistema deve permitir ao usuário filtrar relatórios por um período específico.

---

## 1.7 Administração de usuários

### RF26 — Manter usuários internos
O sistema deve permitir ao usuário associado ao perfil de **Administrador** manter os usuários internos do sistema, contemplando as operações de cadastro, consulta, atualização e exclusão (CRUD).

### RF27 — Definir perfil de acesso
O sistema deve permitir ao usuário associado ao perfil de **Administrador** definir o perfil de acesso dos usuários internos.

---

## 1.8 Solicitações

### RF28 — Registrar solicitações
O sistema deve permitir aos usuários associados aos perfis de **Administrador** ou **Atendente** registrar solicitações de atendimento, doação ou empréstimo de bomba de leite.

---

# 2. Requisitos Não Funcionais

Os requisitos não funcionais estabelecem restrições técnicas, arquiteturais, de segurança, desempenho, compatibilidade, usabilidade e acessibilidade aplicáveis ao sistema.

## 2.1 Tecnologias e arquitetura

### RNF01 — Backend
O sistema deverá utilizar a linguagem **PHP** e o framework **Laravel** para o desenvolvimento do back-end.

### RNF02 — Arquitetura MVC
O sistema deverá utilizar a arquitetura **Model-View-Controller (MVC)** para separar as responsabilidades entre modelos, visões e controladores.

### RNF03 — Banco de dados
O sistema deverá utilizar **MySQL** como banco de dados relacional.

### RNF04 — Tecnologias de interface
O sistema deverá utilizar **Blade, HTML, CSS, JavaScript e Bootstrap** para o desenvolvimento das interfaces.

### RNF05 — Migrations
O sistema deverá utilizar **migrations do Laravel** para criação e versionamento da estrutura do banco de dados.

### RNF06 — Eloquent ORM
O sistema deverá utilizar **Eloquent ORM** para realizar operações de cadastro, consulta, atualização e exclusão dos registros.

---

## 2.2 Segurança

### RNF07 — Restrição de acesso
O sistema deverá restringir o acesso às páginas internas apenas a usuários autenticados.

### RNF08 — Armazenamento de senhas
O sistema deverá armazenar as senhas dos usuários utilizando o algoritmo de hash criptográfico **bcrypt**, por meio dos recursos disponibilizados pelo Laravel.

---

## 2.3 Desempenho

### RNF09 — Tempo de resposta
O sistema deverá responder às operações de cadastro, consulta, atualização e exclusão em até **três segundos**, considerando ambiente com conexão estável à internet.

---

## 2.4 Compatibilidade

### RNF10 — Navegadores
O sistema deverá ser compatível com versões recentes dos navegadores:

- Google Chrome;
- Microsoft Edge;
- Mozilla Firefox;
- Brave.

---

## 2.5 Usabilidade e interface

### RNF11 — Heurísticas de Nielsen
O sistema deverá utilizar as **10 Heurísticas de Nielsen** como guia para organização e avaliação das interfaces.

### RNF12 — Material Design
O sistema deverá utilizar componentes do **Material Design (MD)** como referência para o desenvolvimento das interfaces.

### RNF13 — WCAG
O sistema deverá utilizar os critérios de acessibilidade da **Web Content Accessibility Guidelines (WCAG)** em nível **A** como referência para o desenvolvimento das interfaces.

### RNF14 — Feedback ao usuário
O sistema deverá apresentar mensagens de erro, alerta e confirmação nas operações de:

- login;
- logout;
- cadastro;
- atualização;
- exclusão.

### RNF15 — Avaliação de usabilidade
O sistema deverá utilizar o método **Relationship of M3C with User Requirements and Usability and Communicability Assessment in groupware (RURUCAg)** para avaliar a usabilidade do sistema web.

### RNF16 — Responsividade
O sistema deverá adaptar suas interfaces para visualização em:

- computadores;
- notebooks;
- tablets;
- celulares.

---

# 3. Regras de Negócio

As regras de negócio definem restrições e condições que deverão ser respeitadas durante a execução dos processos da ONG.

## 3.1 Acesso ao sistema

### RN01 — Autenticação obrigatória
Não é permitido realizar qualquer ação no sistema sem login.

---

## 3.2 Beneficiárias

### RN02 — Dados obrigatórios da beneficiária
Não é permitido cadastrar uma beneficiária sem informar:

- nome completo;
- CPF;
- telefone.

---

## 3.3 Atendimentos

### RN03 — Vínculo obrigatório com beneficiária
Não é permitido cadastrar um atendimento sem relacioná-lo a uma beneficiária.

---

## 3.4 Doações e estoque

### RN04 — Vínculo da distribuição
Não é permitido registrar a distribuição de uma doação sem relacioná-la a uma beneficiária.

### RN05 — Controle de quantidade disponível
Não é permitido registrar a saída de um item do estoque quando a quantidade solicitada for maior que a quantidade disponível.

### RN06 — Dados obrigatórios da entrada
Não é permitido registrar a entrada de uma doação sem informar:

- tipo do item;
- quantidade recebida.

---

## 3.5 Bombas de leite

### RN07 — Vínculo obrigatório
Não é permitido registrar empréstimo ou aluguel de bomba de leite sem relacioná-lo a uma beneficiária.

### RN08 — Disponibilidade da bomba
Não é permitido registrar empréstimo ou aluguel de bomba de leite quando a bomba estiver com situação diferente de **“disponível”**.

### RN09 — Situação após retirada
A bomba de leite deverá ter sua situação alterada para **“emprestada”** ou **“alugada”** após o registro do empréstimo ou aluguel correspondente.

### RN10 — Situação após devolução
A bomba de leite deverá ter sua situação alterada para **“disponível”** após o registro da devolução, salvo quando houver indicação de manutenção.

### RN11 — Devolução somente para operação em aberto
Não é permitido registrar a devolução de uma bomba de leite sem que exista empréstimo ou aluguel em aberto.

---

## 3.6 Integridade e exclusão de registros

### RN12 — Exclusão de beneficiária com vínculos
Não é permitido excluir uma beneficiária que possua atendimentos, doações ou bombas de leite vinculadas.

### RN13 — Exclusão de beneficiária com vínculos
Não é permitido excluir uma beneficiária que possua atendimentos, doações ou bombas de leite vinculadas.

> **Observação:** RN12 e RN13 encontram-se com conteúdo idêntico na versão atual da especificação do TCC e precisam ser revisadas para verificar se houve duplicação ou omissão de uma regra distinta.

### RN14 — Exclusão de item com movimentações
Não é permitido excluir um item de estoque que possua movimentações de entrada ou saída vinculadas.

### RN15 — Exclusão de bomba com histórico
Não é permitido excluir uma bomba de leite que possua histórico de empréstimo, aluguel ou manutenção.

---

# 4. Resumo quantitativo

| Categoria | Quantidade |
|---|---:|
| Requisitos Funcionais (RF) | 28 |
| Requisitos Não Funcionais (RNF) | 16 |
| Regras de Negócio (RN) | 15 |
| **Total** | **59** |

---

# 5. Perfis de acesso

O sistema contempla três perfis principais de usuários internos:

| Perfil | Principais responsabilidades |
|---|---|
| **Administrador** | Administração geral, relatórios, usuários, beneficiárias, atendimentos, doações, estoque e bombas de leite |
| **Atendente** | Beneficiárias, doadores, doações, estoque, bombas de leite e solicitações |
| **Enfermeira** | Atendimentos, histórico das beneficiárias e relatórios relacionados aos atendimentos |

---

# 6. Módulos funcionais

Os requisitos encontram-se distribuídos principalmente entre os seguintes módulos:

### Beneficiárias
Centraliza os dados cadastrais das mães atendidas e permite que suas interações com a ONG sejam rastreadas.

### Atendimentos
Permite registrar e acompanhar os atendimentos realizados às beneficiárias, mantendo o histórico de acompanhamento.

### Doações e estoque
Permite administrar doadores, entradas de doações, itens disponíveis, movimentações de estoque e distribuições realizadas às beneficiárias.

### Bombas de leite
Permite administrar bombas de leite, empréstimos, aluguéis, devoluções, disponibilidade e histórico de utilização dos equipamentos.

### Relatórios
Permite consolidar informações dos diferentes processos da ONG e aplicar filtros temporais para apoio à gestão.

### Administração
Controla os usuários internos e os respectivos perfis de acesso ao sistema.

### Solicitações
Permite registrar demandas de atendimento, doação e empréstimo de bombas de leite recebidas pela ONG.