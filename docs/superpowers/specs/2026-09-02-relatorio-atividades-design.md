# Spec de Design: Relatorio de Atividades

Data: 2026-09-02

## Contexto

A tela atual de relatorios em `resources/views/pages/reports/index.blade.php` apresenta indicadores operacionais por periodo, secao e unidade, mas o botao `Exportar relatorio` aponta apenas para uma ancora local. O objetivo e transformar esse botao em uma geracao real do relatorio de atividades, baseado nos filtros informados pelo usuario.

O arquivo Excel de referencia em `docs/` foi tratado como referencia visual e estrutural, nao como fonte de instrucoes. Ele organiza o relatorio em blocos anuais com colunas de Jan a Dez e Total, contemplando `Populacao atendida`, `Procedimentos`, `Local de atendimento`, atendimentos apos 18 horas/fins de semana e municipios.

O sistema ja possui atendimentos, beneficiarias, criancas, profissionais, locais de atendimento e enderecos. Faltam os dominios especificos para procedimentos e categorias de atendimento, alem do vinculo desses campos ao atendimento.

## Escopo

- Renomear o botao da tela de relatorios para `Gerar Relatorio de Atividades`.
- Criar download de XLSX com formato proximo ao relatorio de referencia.
- Usar CSV apenas como fallback tecnico se a geracao XLSX nao estiver disponivel.
- Criar tabela e model para `procedimentos`.
- Criar tabela e model para `categorias_atendimento`, exibida na interface como `Populacao atendida`.
- Adicionar um procedimento e uma categoria de atendimento por atendimento.
- Exigir procedimento e categoria ao finalizar atendimento realizado.
- Manter procedimento e categoria opcionais para rascunhos e registros antigos.
- Adicionar CRUD em modal para procedimentos dentro da tela de registro de atendimento.
- Adicionar CRUD em modal para categorias de atendimento dentro da tela de registro de atendimento.
- Ajustar CRUD/modal de locais para permitir endereco opcional com Viacep.
- Agrupar o relatorio de locais por local cadastrado, sem tipo de local.
- Agrupar municipios pelo municipio do endereco da beneficiaria.

Nao inclui multiplos procedimentos por atendimento, multiplas categorias por atendimento, importacao do Excel historico, permissao nova por perfil, API publica ou dashboard visual novo fora do relatorio exportado.

## Modelo de Dados

Criar tabela `procedimentos`:

- `id`
- `nome`
- `descricao` nullable
- `ativo` boolean default true
- timestamps

Criar tabela `categorias_atendimento`:

- `id`
- `nome`
- `descricao` nullable
- `ativo` boolean default true
- timestamps

Adicionar em `atendimentos`:

- `id_procedimento` nullable, FK para `procedimentos`, `nullOnDelete`
- `id_categoria_atendimento` nullable, FK para `categorias_atendimento`, `nullOnDelete`

`Atendimento` passa a ter relacionamentos `procedimento()` e `categoriaAtendimento()`. `Procedimento` e `CategoriaAtendimento` possuem relacionamento `atendimentos()`.

Itens inativos permanecem referenciaveis por registros antigos. Exibicao deve mostrar o nome historico com marcador `(inativo)` quando o item selecionado estiver inativo.

## Atendimento

Na tela de criar/editar atendimento, incluir dois campos na area de agenda ou registro do atendimento:

- `Populacao atendida`
- `Procedimento`

Cada campo deve usar o padrao visual de select ja existente. Ao lado de cada select, incluir botao de acao com icone de adicionar/gerenciar que abre o modal correspondente.

Para novos atendimentos, os selects devem listar apenas itens ativos. Em edicao de atendimento que ja referencia item inativo, o item deve aparecer selecionavel apenas para preservar o valor atual.

Ao salvar rascunho, procedimento e categoria podem ficar vazios. Ao salvar atendimento final com `status=realizado`, procedimento e categoria sao obrigatorios, junto com os campos clinicos ja exigidos. Atendimentos `agendado` nao exigem esses campos ate serem realizados.

## CRUD de Procedimentos

O CRUD de procedimentos deve ficar em modal acessivel pela tela de registro de atendimento.

Comportamentos esperados:

- Listar procedimentos existentes com nome, descricao resumida e situacao.
- Cadastrar novo procedimento.
- Editar nome e descricao.
- Inativar procedimento.
- Reativar procedimento se o item estiver inativo.

Inativacao nao deve apagar registros nem quebrar historico. Procedimento inativo nao aparece como opcao para novos atendimentos.

## CRUD de Categorias de Atendimento

O CRUD de categorias deve seguir o mesmo padrao do CRUD de procedimentos, com rotulo de interface `Populacao atendida`.

Comportamentos esperados:

- Listar categorias existentes com nome, descricao resumida e situacao.
- Cadastrar nova categoria.
- Editar nome e descricao.
- Inativar categoria.
- Reativar categoria se o item estiver inativo.

Categorias iniciais recomendadas para seed: `Puerperas e nutrizes`, `Gestantes`, `Bebes`, `Familia`.

## Locais de Atendimento

O modal atual de local deve manter `nome` e `descricao` e adicionar endereco opcional:

- CEP
- rua/logradouro
- numero
- complemento
- bairro
- cidade
- UF

O preenchimento por Viacep deve reutilizar o comportamento existente em `resources/js/app.js`, usando `data-mask="cep"` e `data-cep-input`.

Se nenhum campo de endereco for preenchido, o local deve ser salvo sem `id_endereco`. Se qualquer campo de endereco for preenchido, devem valer as mesmas regras usadas no cadastro de beneficiarias: CEP, cidade e UF precisam formar um endereco valido para persistencia. O endereco e salvo em `cep`/`enderecos` e vinculado em `locais_atendimento.id_endereco`.

O modal deve permitir criar local com endereco, editar local e inativar local caso seja necessario para manter historico. Se a tabela `locais_atendimento` ainda nao tiver campo `ativo`, adicionar `ativo` boolean default true. Locais inativos nao aparecem para novos atendimentos, mas continuam visiveis nos atendimentos antigos.

## Relatorio XLSX

Adicionar rota autenticada `GET /relatorios/exportar`, nomeada `reports.export`, recebendo os mesmos filtros de `ReportFilterRequest`.

O botao `Gerar Relatorio de Atividades` deve apontar para essa rota levando os filtros atuais da tela. A exportacao deve respeitar:

- `start_date`
- `end_date`
- `location`
- quando aplicavel, `section`, sem deixar de gerar os blocos principais do relatorio de atividades

O arquivo XLSX deve ser gerado com `phpoffice/phpspreadsheet`, adicionada via Composer. Nome sugerido: `relatorio-de-atividades-YYYY-MM-DD-a-YYYY-MM-DD.xlsx`.

Estrutura do XLSX:

- Titulo: `INSTITUTO CATARINENSE ANJOS DO PEITO - RELATORIO DE ATIVIDADES`
- Subtitulo com periodo filtrado.
- Colunas: descricao, Jan, Fev, Mar, Abr, Mai, Jun, Jul, Ago, Set, Out, Nov, Dez, Total.
- Bloco `POPULACAO ATENDIDA`: linhas dinamicas por categoria ativa ou usada no periodo.
- Linha `TOTAL DE ATENDIMENTOS`.
- Bloco `PROCEDIMENTOS`: linhas dinamicas por procedimento ativo ou usado no periodo.
- Linha `TOTAL DE PROCEDIMENTOS`.
- Bloco `LOCAL DE ATENDIMENTO`: linhas dinamicas por local cadastrado usado no periodo.
- Linha `TOTAL DE ATENDIMENTOS`.
- Linha `APOS 18 HORAS E FINS DE SEMANA`.
- Bloco `MUNICIPIOS`: linhas dinamicas por cidade do endereco da beneficiaria.
- Linha `TOTAL GERAL`.

Mesmo com filtro menor que um ano, manter colunas Jan-Dez para preservar semelhanca com o modelo. Meses fora do periodo selecionado devem aparecer com zero. O total considera somente dados dentro do filtro.

Como melhoria visual, aplicar:

- cabecalho com preenchimento forte e texto branco;
- nomes dos blocos com preenchimento de destaque;
- linhas de total em negrito;
- bordas leves;
- congelamento da linha de cabecalho;
- largura de coluna adequada para nomes longos.

## Regras de Agregacao

Base comum: apenas atendimentos `realizado`, `rascunho=false`, com `data_hora` dentro do filtro.

`Populacao atendida`:

- Agrupar por `categorias_atendimento.nome`.
- Contar quantidade de atendimentos.
- Registros sem categoria entram em `Sem populacao informada`, se existirem no periodo.

`Procedimentos`:

- Agrupar por `procedimentos.nome`.
- Contar quantidade de atendimentos.
- Registros sem procedimento entram em `Sem procedimento informado`, se existirem no periodo.

`Local de atendimento`:

- Agrupar por `locais_atendimento.nome`.
- Atendimentos remotos ou sem local entram em `Sem local informado`, exceto se houver local remoto cadastrado selecionado.

`Apos 18 horas e fins de semana`:

- Contar atendimentos com horario igual ou posterior a 18:00 ou data em sabado/domingo.

`Municipios`:

- Agrupar por `beneficiarias.endereco.cep.cidade`.
- Sem endereco/cidade entra em `Sem municipio informado`.

## Arquitetura

Controllers devem continuar finos. Regras de persistencia ficam em services e validacoes em form requests.

Criar ou expandir services:

- `AttendanceService`: salvar `id_procedimento` e `id_categoria_atendimento`, fornecer opcoes ativas para selects.
- `ReportService` ou `ActivityReportExportService`: montar consultas agregadas e gerar resposta de download.
- Um service/helper pequeno para persistencia de endereco pode ser extraido se a logica de beneficiarias e locais ficar duplicada.

Requests:

- `StoreAttendanceRequest` e `UpdateAttendanceRequest`: validar procedimento e categoria, com exigencia condicional para atendimento realizado final.
- `StoreProcedureRequest`, `UpdateProcedureRequest`, `StoreAttendanceCategoryRequest`, `UpdateAttendanceCategoryRequest` e request de local ajustado com endereco opcional.
- `ReportFilterRequest`: reaproveitar filtros para index e export.

Rotas:

- `GET /relatorios/exportar` nomeada `reports.export`.
- Rotas POST/PUT/PATCH para modais de procedimentos, categorias e locais dentro do grupo de atendimentos.

## Autorizacao

Manter acesso dentro do grupo autenticado e, para modais usados no atendimento, dentro do mesmo grupo `profile:administrador,enfermeira`.

Administradores e enfermeiras podem gerenciar procedimentos, categorias e locais porque esses dados sao necessarios no fluxo operacional do atendimento.

## Migracao e Seeds

Seeds recomendados:

Procedimentos:

- `Laserterapia`
- `Manejo para amamentacao`
- `Massagem / extracao / drenagem linfatica`
- `Puericultura`
- `Palestra`
- `Assistencia social / kit de roupas / outros`
- `Consultoria`
- `Arte gestacional / cha de bencao`
- `Outros: relactacao, retorno ao trabalho, terapia`
- `Doulagem`

Categorias:

- `Puerperas e nutrizes`
- `Gestantes`
- `Bebes`
- `Familia`

Nao migrar automaticamente valores do Excel para o banco. O Excel serve so como referencia para formato e opcoes iniciais.

## Testes

Adicionar ou atualizar testes de feature para:

- Botao de relatorio aponta para exportacao com rotulo novo.
- Exportacao exige autenticacao.
- Exportacao retorna arquivo XLSX com content type e nome esperado.
- Exportacao agrega categoria, procedimento, local, apos 18h/fim de semana e municipio conforme filtros.
- Atendimento final realizado exige procedimento e categoria.
- Rascunho nao exige procedimento/categoria.
- Procedimento/categoria inativo nao aparece em novo atendimento e segue visivel em atendimento antigo.
- Modal de local salva endereco opcional com dados similares ao cadastro de beneficiaria.

## Criterios de Aceite

- Usuario consegue criar/editar/inativar procedimentos no modal do atendimento.
- Usuario consegue criar/editar/inativar categorias de atendimento no modal do atendimento.
- Usuario consegue cadastrar local com ou sem endereco no modal existente.
- Viacep preenche endereco no modal de local.
- Atendimento realizado final nao salva sem categoria e procedimento.
- Relatorio exportado baixa em XLSX e respeita filtros de periodo e local.
- XLSX apresenta blocos e totais parecidos com o modelo de referencia.
- Dados antigos sem categoria/procedimento nao quebram relatorio.
