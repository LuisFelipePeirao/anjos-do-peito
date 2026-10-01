# Deploy: cron de cobranças recorrentes no Ubuntu Server

## O que será executado

O projeto agenda o comando `rentals:generate-payments` uma vez por dia em `routes/console.php`. Ele cria parcelas de aluguel pendentes, evita duplicidade e marca parcelas vencidas como `atrasado`.

O Ubuntu não deve chamar esse comando diretamente. Ele chama o Scheduler do Laravel a cada minuto; o Laravel decide quando executar cada tarefa. Assim, novos agendamentos ficam versionados no projeto e não exigem uma nova cron entry.

## Premissas

Substitua estes valores conforme seu servidor:

- `/var/www/anjos-do-peito`: caminho absoluto do projeto.
- `www-data`: usuário que executa PHP-FPM/Nginx e possui acesso de leitura ao projeto e escrita em `storage` e `bootstrap/cache`.
- `/usr/bin/php`: caminho do PHP do servidor. Confirme com `command -v php`.

Não use `root` para a cron da aplicação. Execute-a com o mesmo usuário da aplicação, para não criar arquivos de log/cache pertencentes ao root.

## Primeira instalação no servidor

Conecte por SSH e execute:

```bash
cd /var/www/anjos-do-peito
git status
git pull --ff-only origin staging
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan schedule:list
```

`migrate --force` é necessário em ambiente de produção. Antes de executá-lo, tenha backup recente do banco. A migration deste recurso adiciona campos e índice; não remove dados existentes.

Corrija permissões, caso necessário:

```bash
sudo chown -R www-data:www-data /var/www/anjos-do-peito/storage /var/www/anjos-do-peito/bootstrap/cache
sudo find /var/www/anjos-do-peito/storage /var/www/anjos-do-peito/bootstrap/cache -type d -exec chmod 775 {} \;
sudo find /var/www/anjos-do-peito/storage /var/www/anjos-do-peito/bootstrap/cache -type f -exec chmod 664 {} \;
```

## Criar a cron entry

Abra a crontab do usuário da aplicação:

```bash
sudo -u www-data crontab -e
```

Adicione esta única linha:

```cron
* * * * * cd /var/www/anjos-do-peito && /usr/bin/php artisan schedule:run >> /var/www/anjos-do-peito/storage/logs/scheduler.log 2>&1
```

Salve e confira:

```bash
sudo -u www-data crontab -l
```

O `schedule:run` termina sozinho a cada chamada. Portanto, ele não depende de sessão SSH aberta, `screen`, `tmux` ou terminal ativo. O cron do sistema inicia uma execução nova por minuto.

## Validar antes e depois da cron

Execute manualmente como o usuário da aplicação:

```bash
sudo -u www-data -H bash -lc 'cd /var/www/anjos-do-peito && /usr/bin/php artisan schedule:list'
sudo -u www-data -H bash -lc 'cd /var/www/anjos-do-peito && /usr/bin/php artisan rentals:generate-payments'
tail -f /var/www/anjos-do-peito/storage/logs/scheduler.log
tail -f /var/www/anjos-do-peito/storage/logs/laravel.log
```

Depois de aguardar um minuto, o arquivo `scheduler.log` deve receber nova saída. Para diagnosticar cron do sistema, use:

```bash
sudo systemctl status cron
sudo journalctl -u cron --since '15 minutes ago'
```

## Deploy sem depender da sessão SSH

O deploy deve ser feito por pipeline CI/CD, webhook controlado ou ferramenta de deploy; nunca por um processo que só continua enquanto uma sessão SSH permanece aberta. O passo obrigatório após publicar o novo código é executar comandos não interativos, nesta ordem:

```bash
cd /var/www/anjos-do-peito
composer install --no-dev --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan schedule:list
```

A cron entry é criada uma única vez e permanece ativa entre deploys. A aplicação contém a regra `Schedule::command('rentals:generate-payments')->daily()->withoutOverlapping()`: o deploy só atualiza o código que o Scheduler lerá na próxima execução.

Se o deploy usa GitHub Actions, GitLab CI ou outro runner, configure conexão SSH por chave de deploy e execute os comandos acima no runner. Mantenha `.env` exclusivamente no servidor; não o envie ao repositório ou ao pipeline.

## Rollback

Se o deploy falhar antes de `migrate --force`, restaure a release/commit anterior e rode novamente os comandos de cache. Se a migration já foi aplicada, não execute rollback automático em produção sem backup e revisão: avalie a migration e o estado real do banco primeiro.

## Referência

O Laravel recomenda uma única cron entry para `schedule:run` por minuto e mantém os agendamentos no código da aplicação. Consulte a [documentação oficial do Laravel Scheduler](https://laravel.com/docs/13.x/scheduling).
