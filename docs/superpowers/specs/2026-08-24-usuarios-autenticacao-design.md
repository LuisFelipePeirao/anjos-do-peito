# Spec de Design: Usuários e Autenticação

Data: 2026-08-24

## Contexto

O sistema Anjos do Peito possui telas Blade para login, recuperação de senha e páginas internas, mas ainda não tem autenticação funcional. O objetivo desta spec é definir a primeira entrega implementável de backend para usuários internos e autenticação, mantendo compatibilidade com Laravel e com as regras documentadas em `docs/requisitos-sistema-anjos-do-peito.md`.

Esta entrega cobre RF01, RF02, RF26, RF27, RN01, RNF07, RNF08 e a base de autorização por perfil para os módulos seguintes.

## Escopo

Inclui:

- Login por e-mail e senha.
- Logout com invalidação da sessão.
- Proteção das páginas internas por autenticação.
- Recuperação e redefinição de senha por e-mail.
- Envio de e-mails via SMTP da Resend usando variáveis de ambiente.
- Cadastro, consulta, atualização, inativação e definição de perfil de usuários internos por administradores.
- Seed inicial de um usuário administrador.
- Testes de autenticação, recuperação de senha e autorização básica.

Não inclui:

- Cadastro público de usuários.
- Verificação obrigatória de e-mail.
- Autenticação por API/token.
- Autorização detalhada dos demais módulos além da proteção inicial por perfil.

## Decisões

- O login será feito com `email` e `senha`.
- Apenas usuários com perfil `administrador` podem manter usuários internos.
- Os perfis persistidos serão `administrador`, `atendente` e `enfermeira`.
- A tabela principal será `usuarios`, preservando a nomenclatura do domínio.
- Os campos persistidos serão `nome`, `email`, `senha`, `perfil`, timestamps e soft deletes.
- A recuperação de senha usará o password broker nativo do Laravel.
- A Resend será configurada como SMTP no mailer nativo do Laravel; nenhuma chave será gravada no código.

## Modelo de Dados

### `usuarios`

Campos:

- `id`: chave primária.
- `nome`: nome completo do usuário interno.
- `email`: e-mail único usado no login.
- `email_verificado_em`: opcional, reservado para verificação futura.
- `senha`: hash bcrypt da senha.
- `perfil`: enum com `administrador`, `atendente`, `enfermeira`.
- `remember_token`: token de lembrar sessão.
- `created_at` e `updated_at`.
- `deleted_at`: inativação por soft delete.

O model `App\Models\User` deverá apontar para a tabela `usuarios` e mapear os campos em português. Como o Laravel espera o atributo autenticável `password`, o model deverá implementar `getAuthPassword()` retornando `senha` e aplicar cast `hashed` ao campo `senha`.

### `password_reset_tokens`

Será mantida a tabela padrão do Laravel:

- `email`: chave primária.
- `token`: token gerado pelo password broker.
- `created_at`: data de criação para expiração.

## Fluxos

### Login

1. Usuário acessa `/`.
2. Informa `email` e `senha`.
3. Sistema valida formato do e-mail e presença da senha.
4. Sistema tenta autenticar usando o guard `web`.
5. Em sucesso, regenera a sessão e redireciona para `/home`.
6. Em falha, retorna para login com mensagem genérica.

Mensagem de falha recomendada: "As credenciais informadas não conferem."

### Logout

1. Usuário autenticado aciona "Sair".
2. Sistema executa logout no guard `web`.
3. Sistema invalida a sessão e regenera o token CSRF.
4. Sistema redireciona para a tela de login.

### Recuperação de senha

1. Usuário acessa `/recover-password`.
2. Informa o e-mail.
3. Sistema valida formato do e-mail.
4. Sistema solicita ao password broker o envio do link.
5. Sistema sempre retorna uma resposta segura, sem revelar se o e-mail existe.
6. Se o e-mail existir, o Laravel envia o link via SMTP da Resend.

### Redefinição de senha

1. Usuário acessa o link recebido por e-mail com token válido.
2. Informa nova senha e confirmação.
3. Sistema valida token, e-mail e força mínima da senha.
4. Sistema grava a nova senha com hash bcrypt.
5. Sistema invalida o token usado.
6. Sistema redireciona para login com confirmação.

### Administração de usuários

1. Usuário administrador acessa a área de usuários internos.
2. Pode listar usuários ativos e inativos.
3. Pode criar usuário com `nome`, `email`, `senha` inicial e `perfil`.
4. Pode editar `nome`, `email` e `perfil`.
5. Pode inativar usuário por soft delete.
6. Não pode inativar a própria conta se ela for o único administrador ativo.

Usuários não administradores devem receber bloqueio ao tentar acessar rotas de administração.

## Rotas

Rotas públicas:

- `GET /`: exibe login.
- `POST /login`: autentica usuário.
- `GET /recover-password`: exibe solicitação de recuperação.
- `POST /recover-password`: envia link de recuperação.
- `GET /new-password/{token}`: exibe formulário de nova senha.
- `POST /new-password`: redefine senha.

Rotas autenticadas:

- `POST /logout`: encerra sessão.
- `GET /home`: dashboard.
- Demais páginas internas existentes.

Rotas administrativas:

- `GET /usuarios`: lista usuários internos.
- `GET /usuarios/novo`: exibe criação.
- `POST /usuarios`: cria usuário.
- `GET /usuarios/{usuario}/editar`: exibe edição.
- `PUT /usuarios/{usuario}`: atualiza usuário.
- `DELETE /usuarios/{usuario}`: inativa usuário.

## Autorização

A primeira camada será:

- Middleware `auth` em todas as páginas internas.
- Middleware de perfil para rotas administrativas.

Regra inicial:

- `administrador`: acesso total ao módulo de usuários e às páginas internas.
- `atendente`: acesso às páginas internas não administrativas.
- `enfermeira`: acesso às páginas internas não administrativas.

As permissões específicas dos módulos de atendimentos, doações, estoque, bombas e relatórios serão detalhadas nas próximas specs implementáveis.

## Configuração de E-mail

O envio de recuperação de senha usará SMTP da Resend via `.env`.

Variáveis esperadas:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.resend.com
MAIL_PORT=587
MAIL_USERNAME=resend
MAIL_PASSWORD=re_xxxxxxxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nao-responda@anjosdopeito.org.br
MAIL_FROM_NAME="Anjos do Peito"
```

O valor `re_xxxxxxxxx` deve ser substituído pela chave real da Resend no ambiente local ou de produção. O remetente deverá usar um domínio verificado na Resend antes do uso em produção. Enquanto o domínio final não estiver verificado, o ambiente de desenvolvimento pode usar um remetente autorizado pela conta Resend.

## Validações

Login:

- `email`: obrigatório, formato de e-mail.
- `senha`: obrigatória.

Usuário interno:

- `nome`: obrigatório.
- `email`: obrigatório, formato de e-mail, único entre usuários não excluídos.
- `senha`: obrigatória na criação; opcional na edição.
- `perfil`: obrigatório, um dos valores permitidos.

Redefinição de senha:

- `email`: obrigatório, formato de e-mail.
- `token`: obrigatório.
- `senha`: obrigatória, confirmada, com regra mínima do Laravel.

## Mensagens e UX

- Login inválido deve exibir erro genérico.
- Logout deve exibir confirmação de saída usando o modal já existente.
- Recuperação de senha deve exibir uma mensagem neutra após envio.
- Criação, atualização e inativação de usuários devem exibir feedback de sucesso ou erro.
- Usuário autenticado sem permissão deve receber resposta HTTP 403.

## Seed Inicial

Deve existir um seeder para criar o primeiro administrador quando não houver usuários.

Campos sugeridos via `.env`:

```env
ADMIN_SEED_NOME="Administrador"
ADMIN_SEED_EMAIL=admin@anjosdopeito.org.br
ADMIN_SEED_PASSWORD=change-me
```

A senha inicial deve ser alterada fora do código e não deve ser commitada com valor real sensível.

## Testes

Testes de feature esperados:

- Usuário visitante acessando `/home` é redirecionado para login.
- Usuário com credenciais válidas consegue autenticar.
- Usuário com senha inválida não autentica.
- Logout encerra a sessão.
- Solicitação de recuperação aceita e-mail válido e dispara notificação/e-mail fake em teste.
- Token válido permite redefinir senha.
- Token inválido não permite redefinir senha.
- Administrador consegue criar usuário interno.
- Atendente e enfermeira não conseguem acessar rotas administrativas.
- Não é permitido remover ou inativar o único administrador ativo.

Testes de unidade ou integração devem cobrir regras auxiliares de perfil se forem extraídas para enum, policy ou middleware.

## Critérios de Aceite

- O login real substitui o redirecionamento estático atual.
- Todas as páginas internas ficam inacessíveis sem autenticação.
- A recuperação de senha envia e-mail usando o mailer SMTP configurado.
- Nenhuma chave da Resend aparece no repositório.
- Usuários internos são mantidos apenas por administradores.
- Os perfis persistidos são `administrador`, `atendente` e `enfermeira`.
- Senhas são armazenadas exclusivamente com hash bcrypt/hasher do Laravel.
- A suíte de testes de autenticação e autorização básica passa.

## Riscos e Observações

- O model `User` padrão do Laravel usa `password`; a implementação precisa adaptar corretamente para o campo `senha`.
- A tabela atual de `usuarios` usa `administradora`; a migration deve ser ajustada para `administrador` antes de rodar em ambientes novos.
- Caso a migration já tenha sido aplicada em algum ambiente, será necessária migration incremental para alterar o enum de perfil.
- O domínio remetente da Resend precisa estar verificado antes do envio real em produção.
- A autorização por perfil será intencionalmente simples nesta entrega; permissões finas por módulo serão evoluídas nas specs seguintes.
