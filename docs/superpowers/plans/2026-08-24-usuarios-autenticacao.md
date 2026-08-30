# Usuários e Autenticação Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implementar autenticação real por e-mail e senha, recuperação de senha via Resend SMTP e gestão interna de usuários administradores.

**Architecture:** Usar autenticação de sessão do Laravel com guard `web`, preservando a tabela de domínio `usuarios` e campos em português. O model `App\Models\User` fará a ponte entre o contrato de autenticação do Laravel e os campos `nome`/`senha`; controllers HTTP concentrarão login, senha e administração.

**Tech Stack:** PHP 8.3, Laravel 13, Blade, Eloquent ORM, Pest, Mail/Notifications nativos do Laravel, SMTP Resend.

**Spec:** `docs/superpowers/specs/2026-08-24-usuarios-autenticacao-design.md`

## Global Constraints

- Login por `email` e `senha`.
- Apenas usuários com perfil `administrador` podem manter usuários internos.
- Perfis persistidos: `administrador`, `atendente`, `enfermeira`.
- Tabela principal: `usuarios`.
- Campos principais: `nome`, `email`, `senha`, `perfil`, timestamps e soft deletes.
- Recuperação de senha pelo password broker nativo do Laravel.
- Resend configurada como SMTP via `.env`; nenhuma chave pode ser commitada.
- Páginas internas devem exigir autenticação.
- Usuário autenticado sem permissão administrativa deve receber HTTP 403.
- Senhas devem usar hash do Laravel, compatível com bcrypt.

---

## File Structure

- `database/migrations/0001_01_01_000000_create_users_table.php`: ajustar schema de `usuarios` para perfil `administrador` e compatibilidade com auth.
- `app/Models/User.php`: mapear tabela `usuarios`, campos fillable/hidden/casts, `getAuthPassword()`, helpers de perfil e soft deletes.
- `database/factories/UserFactory.php`: criar usuários em português com senha hasheada e perfis válidos.
- `database/seeders/DatabaseSeeder.php`: criar administrador inicial por variáveis de ambiente.
- `tests/Feature/Auth/AuthenticationTest.php`: login, logout e proteção de páginas internas.
- `tests/Feature/Auth/PasswordResetTest.php`: solicitação e redefinição de senha.
- `tests/Feature/Admin/UserManagementTest.php`: acesso administrativo e CRUD básico de usuários.
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`: login/logout.
- `app/Http/Controllers/Auth/PasswordResetLinkController.php`: solicitação de link.
- `app/Http/Controllers/Auth/NewPasswordController.php`: redefinição de senha.
- `app/Http/Controllers/Admin/UserController.php`: gestão de usuários internos.
- `app/Http/Middleware/EnsureUserHasProfile.php`: bloqueio por perfil.
- `bootstrap/app.php`: registrar alias do middleware de perfil.
- `routes/web.php`: substituir rotas estáticas de autenticação por rotas reais e agrupar páginas internas com `auth`.
- `resources/views/auth/login.blade.php`: formulário POST para login.
- `resources/views/auth/recover-password.blade.php`: formulário POST para envio de link.
- `resources/views/auth/new-password.blade.php`: formulário POST com token/e-mail.
- `resources/views/pages/users/index.blade.php`: listagem de usuários.
- `resources/views/pages/users/create.blade.php`: criação de usuário.
- `resources/views/pages/users/edit.blade.php`: edição de usuário.
- `.env.example`: documentar variáveis SMTP Resend e seed de administrador sem valores secretos.

---

### Task 1: Base de Usuários Compatível com Laravel Auth

**Files:**
- Modify: `database/migrations/0001_01_01_000000_create_users_table.php`
- Modify: `app/Models/User.php`
- Modify: `database/factories/UserFactory.php`
- Modify: `database/seeders/DatabaseSeeder.php`
- Test: `tests/Feature/Auth/UserModelTest.php`

**Interfaces:**
- Produces: `App\Models\User::getAuthPassword(): string`
- Produces: `App\Models\User::isAdministrador(): bool`
- Produces: factory states `administrador()`, `atendente()`, `enfermeira()`
- Produces: `usuarios.perfil` values `administrador`, `atendente`, `enfermeira`

- [ ] **Step 1: Write failing model tests**

Create `tests/Feature/Auth/UserModelTest.php`:

```php
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('uses the usuarios table and senha as the auth password', function () {
    $user = User::factory()->create([
        'nome' => 'Maria Admin',
        'email' => 'maria@example.com',
        'senha' => Hash::make('secret-password'),
        'perfil' => 'administrador',
    ]);

    expect($user->getTable())->toBe('usuarios');
    expect(Hash::check('secret-password', $user->getAuthPassword()))->toBeTrue();
});

it('detects administrador profile', function () {
    $admin = User::factory()->administrador()->create();
    $attendant = User::factory()->atendente()->create();

    expect($admin->isAdministrador())->toBeTrue();
    expect($attendant->isAdministrador())->toBeFalse();
});
```

- [ ] **Step 2: Run test to verify it fails**

Run:

```bash
php artisan test tests/Feature/Auth/UserModelTest.php
```

Expected: fails because factory/model still use `name/password` and `isAdministrador()` does not exist.

- [ ] **Step 3: Update migration enum and user schema**

In `database/migrations/0001_01_01_000000_create_users_table.php`, ensure the `usuarios` schema uses:

```php
$table->string('nome');
$table->string('email')->unique();
$table->timestamp('email_verificado_em')->nullable();
$table->string('senha');
$table->enum('perfil', ['administrador', 'atendente', 'enfermeira']);
$table->rememberToken();
$table->timestamps();
$table->softDeletes();
```

Replace any `administradora` enum value with `administrador`.

- [ ] **Step 4: Update `App\Models\User`**

Modify `app/Models/User.php`:

```php
<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nome', 'email', 'senha', 'perfil'])]
#[Hidden(['senha', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getAuthPassword(): string
    {
        return $this->senha;
    }

    public function isAdministrador(): bool
    {
        return $this->perfil === 'administrador';
    }

    protected function casts(): array
    {
        return [
            'email_verificado_em' => 'datetime',
            'senha' => 'hashed',
        ];
    }
}
```

- [ ] **Step 5: Update `UserFactory`**

Modify `database/factories/UserFactory.php` so the default definition is:

```php
public function definition(): array
{
    return [
        'nome' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'email_verificado_em' => now(),
        'senha' => 'password',
        'perfil' => 'atendente',
        'remember_token' => Str::random(10),
    ];
}

public function administrador(): static
{
    return $this->state(fn (array $attributes) => ['perfil' => 'administrador']);
}

public function atendente(): static
{
    return $this->state(fn (array $attributes) => ['perfil' => 'atendente']);
}

public function enfermeira(): static
{
    return $this->state(fn (array $attributes) => ['perfil' => 'enfermeira']);
}
```

Keep `use Illuminate\Support\Str;` at the top. The `senha` cast hashes the plain factory value.

- [ ] **Step 6: Add initial admin seed**

Modify `database/seeders/DatabaseSeeder.php`:

```php
use App\Models\User;

public function run(): void
{
    if (User::query()->where('perfil', 'administrador')->exists()) {
        return;
    }

    User::factory()->administrador()->create([
        'nome' => env('ADMIN_SEED_NOME', 'Administrador'),
        'email' => env('ADMIN_SEED_EMAIL', 'admin@anjosdopeito.org.br'),
        'senha' => env('ADMIN_SEED_PASSWORD', 'change-me'),
    ]);
}
```

- [ ] **Step 7: Run tests**

Run:

```bash
php artisan test tests/Feature/Auth/UserModelTest.php
```

Expected: PASS.

- [ ] **Step 8: Commit**

```bash
git add database/migrations/0001_01_01_000000_create_users_table.php app/Models/User.php database/factories/UserFactory.php database/seeders/DatabaseSeeder.php tests/Feature/Auth/UserModelTest.php
git commit -m "feat: configure usuarios auth model"
```

---

### Task 2: Login, Logout e Proteção de Páginas Internas

**Files:**
- Create: `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- Modify: `routes/web.php`
- Modify: `resources/views/auth/login.blade.php`
- Test: `tests/Feature/Auth/AuthenticationTest.php`

**Interfaces:**
- Consumes: `App\Models\User::getAuthPassword(): string`
- Produces: route names `login`, `login.store`, `logout`
- Produces: POST `/login` with fields `email`, `senha`

- [ ] **Step 1: Write failing authentication tests**

Create `tests/Feature/Auth/AuthenticationTest.php`:

```php
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests away from home', function () {
    $this->get('/home')
        ->assertRedirect(route('login'));
});

it('authenticates a user with email and senha', function () {
    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'senha' => 'secret-password',
    ]);

    $this->post(route('login.store'), [
        'email' => 'admin@example.com',
        'senha' => 'secret-password',
    ])->assertRedirect(route('home'));

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid credentials', function () {
    User::factory()->create([
        'email' => 'admin@example.com',
        'senha' => 'secret-password',
    ]);

    $this->from(route('login'))->post(route('login.store'), [
        'email' => 'admin@example.com',
        'senha' => 'wrong-password',
    ])->assertRedirect(route('login'));

    $this->assertGuest();
});

it('logs out an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run:

```bash
php artisan test tests/Feature/Auth/AuthenticationTest.php
```

Expected: FAIL because controllers and POST routes do not exist.

- [ ] **Step 3: Create session controller**

Create `app/Http/Controllers/Auth/AuthenticatedSessionController.php`:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required', 'string'],
        ]);

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['senha']], $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'As credenciais informadas não conferem.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
```

- [ ] **Step 4: Update auth routes**

In `routes/web.php`, import the controller:

```php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
```

Replace the current login route with:

```php
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
```

Wrap all existing internal routes from `/home` onward in:

```php
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        // keep existing body unchanged
    })->name('home');

    // keep the rest of the existing internal routes here
});
```

Leave `/icon` outside the group only if it remains a development-only route; otherwise move it inside `auth`.

- [ ] **Step 5: Update login form**

Modify `resources/views/auth/login.blade.php`:

```php
<form action="{{ route('login.store') }}" method="POST" class="w-72.5 md:w-80">
    @csrf

    <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Seja Bem-vindo!</h1>

    <x-material.input label="E-mail" name="email" type="email" value="{{ old('email') }}">
        <x-slot:icon>
            <x-gmdi-account-circle-o />
        </x-slot:icon>
    </x-material.input>

    <x-material.input label="Senha" name="senha" type="password">
        <x-slot:icon>
            <x-gmdi-lock-o />
        </x-slot:icon>
    </x-material.input>

    @error('email')
        <p class="mb-4 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror

    <a href="{{ route('recover-password') }}" class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Esqueceu a Senha?</a>

    <x-login.login-button value="Entrar" />
</form>
```

If `x-material.input` does not forward `name` and `value`, update `resources/views/components/material/input.blade.php` to accept and render those attributes via `$attributes`.

- [ ] **Step 6: Run tests**

Run:

```bash
php artisan test tests/Feature/Auth/AuthenticationTest.php
```

Expected: PASS.

- [ ] **Step 7: Commit**

```bash
git add app/Http/Controllers/Auth/AuthenticatedSessionController.php routes/web.php resources/views/auth/login.blade.php resources/views/components/material/input.blade.php tests/Feature/Auth/AuthenticationTest.php
git commit -m "feat: add session authentication"
```

---

### Task 3: Recuperação de Senha com SMTP Resend

**Files:**
- Create: `app/Http/Controllers/Auth/PasswordResetLinkController.php`
- Create: `app/Http/Controllers/Auth/NewPasswordController.php`
- Modify: `routes/web.php`
- Modify: `resources/views/auth/recover-password.blade.php`
- Modify: `resources/views/auth/new-password.blade.php`
- Modify: `.env.example`
- Test: `tests/Feature/Auth/PasswordResetTest.php`

**Interfaces:**
- Produces: route names `password.request`, `password.email`, `password.reset`, `password.update`
- Produces: `.env.example` mail variables for Resend SMTP

- [ ] **Step 1: Write failing password reset tests**

Create `tests/Feature/Auth/PasswordResetTest.php`:

```php
<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('sends a password reset link', function () {
    Notification::fake();
    $user = User::factory()->create(['email' => 'maria@example.com']);

    $this->post(route('password.email'), [
        'email' => 'maria@example.com',
    ])->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPassword::class);
});

it('resets password with a valid token', function () {
    Notification::fake();
    $user = User::factory()->create([
        'email' => 'maria@example.com',
        'senha' => 'old-password',
    ]);

    $this->post(route('password.email'), [
        'email' => 'maria@example.com',
    ]);

    $token = null;
    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$token) {
        $token = $notification->token;
        return true;
    });

    $this->post(route('password.update'), [
        'token' => $token,
        'email' => 'maria@example.com',
        'senha' => 'new-secret-password',
        'senha_confirmation' => 'new-secret-password',
    ])->assertRedirect(route('login'));

    expect(Hash::check('new-secret-password', $user->fresh()->senha))->toBeTrue();
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run:

```bash
php artisan test tests/Feature/Auth/PasswordResetTest.php
```

Expected: FAIL because password reset routes/controllers are not implemented.

- [ ] **Step 3: Create password reset link controller**

Create `app/Http/Controllers/Auth/PasswordResetLinkController.php`:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.recover-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Se o e-mail informado estiver cadastrado, você receberá um link para criar uma nova senha.');
    }
}
```

- [ ] **Step 4: Create new password controller**

Create `app/Http/Controllers/Auth/NewPasswordController.php`:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request, string $token): View
    {
        return view('auth.new-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'senha' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $status = Password::reset(
            [
                'email' => $request->email,
                'password' => $request->senha,
                'password_confirmation' => $request->senha_confirmation,
                'token' => $request->token,
            ],
            function ($user) use ($request) {
                $user->forceFill([
                    'senha' => Hash::make($request->senha),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors(['email' => __($status)])->onlyInput('email');
        }

        return redirect()->route('login')->with('status', __($status));
    }
}
```

- [ ] **Step 5: Add password routes**

In `routes/web.php`, import:

```php
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
```

Inside the `guest` group, add:

```php
Route::get('/recover-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/recover-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/new-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/new-password', [NewPasswordController::class, 'store'])->name('password.update');
```

For compatibility with existing views, either update references to `route('password.request')` or alias the old name:

```php
Route::redirect('/new-password', '/recover-password')->name('new-password');
Route::get('/recover-password', [PasswordResetLinkController::class, 'create'])
    ->name('recover-password');
```

Use one canonical route name in final views: `password.request`.

- [ ] **Step 6: Update recover password form**

Modify `resources/views/auth/recover-password.blade.php`:

```php
<form action="{{ route('password.email') }}" method="POST" class="w-72.5 md:w-80">
    @csrf

    <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Recuperar Senha</h1>

    <x-material.input label="E-mail" name="email" type="email" value="{{ old('email') }}">
        <x-slot:icon>
            <x-gmdi-mail-o />
        </x-slot:icon>
    </x-material.input>

    @if (session('status'))
        <p class="mb-4 text-sm font-medium text-green-700">{{ session('status') }}</p>
    @endif

    @error('email')
        <p class="mb-4 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror

    <x-login.login-span>
        Insira o seu e-mail no campo acima para recuperar sua senha.
        Se o e-mail informado estiver cadastrado, você receberá um link para criar uma nova senha.
    </x-login.login-span>

    <a href="{{ route('login') }}" class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Acessar o sistema</a>

    <x-login.login-button value="Enviar E-mail" />
</form>
```

- [ ] **Step 7: Update new password form**

Modify `resources/views/auth/new-password.blade.php`:

```php
<form action="{{ route('password.update') }}" method="POST" class="w-72.5 md:w-80">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ old('email', $email) }}">

    <h1 class="mb-8 text-[2rem] font-medium md:text-[2.5rem]">Nova Senha</h1>

    <x-material.input label="Senha" name="senha" type="password">
        <x-slot:icon>
            <x-gmdi-lock-o />
        </x-slot:icon>
    </x-material.input>

    <x-material.input label="Confirmar senha" name="senha_confirmation" type="password">
        <x-slot:icon>
            <x-gmdi-lock-o />
        </x-slot:icon>
    </x-material.input>

    @error('email')
        <p class="mb-4 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror

    @error('senha')
        <p class="mb-4 text-sm font-medium text-red-600">{{ $message }}</p>
    @enderror

    <a href="{{ route('login') }}" class="mb-8 block text-right text-base font-medium text-[#8590AD] transition duration-500 hover:text-[#ef5b97]">Acessar o sistema</a>

    <x-login.login-button value="Redefinir Senha" />
</form>
```

- [ ] **Step 8: Document SMTP Resend env variables**

Modify `.env.example`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.resend.com
MAIL_PORT=587
MAIL_USERNAME=resend
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=nao-responda@anjosdopeito.org.br
MAIL_FROM_NAME="Anjos do Peito"

ADMIN_SEED_NOME="Administrador"
ADMIN_SEED_EMAIL=admin@anjosdopeito.org.br
ADMIN_SEED_PASSWORD=change-me
```

- [ ] **Step 9: Run tests**

Run:

```bash
php artisan test tests/Feature/Auth/PasswordResetTest.php
```

Expected: PASS.

- [ ] **Step 10: Commit**

```bash
git add app/Http/Controllers/Auth/PasswordResetLinkController.php app/Http/Controllers/Auth/NewPasswordController.php routes/web.php resources/views/auth/recover-password.blade.php resources/views/auth/new-password.blade.php .env.example tests/Feature/Auth/PasswordResetTest.php
git commit -m "feat: add password reset via mail"
```

---

### Task 4: Middleware de Perfil e Gestão Administrativa de Usuários

**Files:**
- Create: `app/Http/Middleware/EnsureUserHasProfile.php`
- Modify: `bootstrap/app.php`
- Create: `app/Http/Controllers/Admin/UserController.php`
- Create: `resources/views/pages/users/index.blade.php`
- Create: `resources/views/pages/users/create.blade.php`
- Create: `resources/views/pages/users/edit.blade.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/Admin/UserManagementTest.php`

**Interfaces:**
- Consumes: `App\Models\User::isAdministrador(): bool`
- Produces: route names `users.index`, `users.create`, `users.store`, `users.edit`, `users.update`, `users.destroy`
- Produces: middleware alias `profile`

- [ ] **Step 1: Write failing admin tests**

Create `tests/Feature/Admin/UserManagementTest.php`:

```php
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows administrador to view users', function () {
    $admin = User::factory()->administrador()->create();

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertOk();
});

it('blocks non administradores from user management', function (string $profile) {
    $user = User::factory()->create(['perfil' => $profile]);

    $this->actingAs($user)
        ->get(route('users.index'))
        ->assertForbidden();
})->with(['atendente', 'enfermeira']);

it('allows administrador to create internal user', function () {
    $admin = User::factory()->administrador()->create();

    $this->actingAs($admin)
        ->post(route('users.store'), [
            'nome' => 'Ana Atendente',
            'email' => 'ana@example.com',
            'senha' => 'secret-password',
            'senha_confirmation' => 'secret-password',
            'perfil' => 'atendente',
        ])->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('usuarios', [
        'nome' => 'Ana Atendente',
        'email' => 'ana@example.com',
        'perfil' => 'atendente',
    ]);
});

it('prevents deactivating the only active administrador', function () {
    $admin = User::factory()->administrador()->create();

    $this->actingAs($admin)
        ->delete(route('users.destroy', $admin))
        ->assertSessionHasErrors('usuario');

    expect($admin->fresh()->deleted_at)->toBeNull();
});
```

- [ ] **Step 2: Run tests to verify they fail**

Run:

```bash
php artisan test tests/Feature/Admin/UserManagementTest.php
```

Expected: FAIL because middleware, controller, routes and views do not exist.

- [ ] **Step 3: Create profile middleware**

Create `app/Http/Middleware/EnsureUserHasProfile.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasProfile
{
    public function handle(Request $request, Closure $next, string ...$profiles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->perfil, $profiles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
```

- [ ] **Step 4: Register middleware alias**

Modify `bootstrap/app.php` to add the alias in the middleware configuration:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'profile' => \App\Http\Middleware\EnsureUserHasProfile::class,
    ]);
})
```

Keep existing middleware configuration intact if the file already has a `withMiddleware` block.

- [ ] **Step 5: Create admin user controller**

Create `app/Http/Controllers/Admin/UserController.php`:

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('pages.users.index', [
            'users' => User::query()->withTrashed()->orderBy('nome')->get(),
        ]);
    }

    public function create(): View
    {
        return view('pages.users.create', [
            'profiles' => $this->profiles(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('usuarios', 'email')->whereNull('deleted_at')],
            'senha' => ['required', 'confirmed', Password::defaults()],
            'perfil' => ['required', Rule::in($this->profiles())],
        ]);

        User::query()->create($data);

        return redirect()->route('users.index')->with('status', 'Usuário criado com sucesso.');
    }

    public function edit(User $usuario): View
    {
        return view('pages.users.edit', [
            'user' => $usuario,
            'profiles' => $this->profiles(),
        ]);
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($usuario->id)->whereNull('deleted_at')],
            'senha' => ['nullable', 'confirmed', Password::defaults()],
            'perfil' => ['required', Rule::in($this->profiles())],
        ]);

        if (! filled($data['senha'] ?? null)) {
            unset($data['senha']);
        }

        $usuario->update($data);

        return redirect()->route('users.index')->with('status', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        if ($usuario->isAdministrador() && User::query()->where('perfil', 'administrador')->count() === 1) {
            return back()->withErrors(['usuario' => 'Não é permitido inativar o único administrador ativo.']);
        }

        $usuario->delete();

        return redirect()->route('users.index')->with('status', 'Usuário inativado com sucesso.');
    }

    private function profiles(): array
    {
        return ['administrador', 'atendente', 'enfermeira'];
    }
}
```

- [ ] **Step 6: Add admin routes**

In `routes/web.php`, import:

```php
use App\Http\Controllers\Admin\UserController;
```

Inside the authenticated group, add:

```php
Route::middleware('profile:administrador')->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/novo', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('users.destroy');
});
```

- [ ] **Step 7: Create minimal user management views**

Create `resources/views/pages/users/index.blade.php`:

```php
@extends('layouts.main-pages')

@section('title', 'Usuários internos')
@section('page-title', 'Usuários internos')

@section('content')
    <div class="space-y-6">
        <x-app.page-info
            subheading="Administração"
            title="Usuários internos"
            description="Gerencie os acessos da equipe da ONG."
            :firstButton="['label' => 'Novo usuário', 'link' => route('users.create'), 'icon' => 'add']"
        />

        @if (session('status'))
            <p class="rounded-[8px] border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">{{ session('status') }}</p>
        @endif

        @error('usuario')
            <p class="rounded-[8px] border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ $message }}</p>
        @enderror

        <div class="overflow-hidden rounded-[8px] border border-[#eadfe1] bg-white">
            <table class="min-w-full divide-y divide-[#eadfe1]">
                <thead class="bg-[#fbf1f3]">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-[#111827]">Nome</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-[#111827]">E-mail</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-[#111827]">Perfil</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-[#111827]">Situação</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-[#111827]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#eadfe1]">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-3 text-sm text-[#111827]">{{ $user->nome }}</td>
                            <td class="px-4 py-3 text-sm text-[#667085]">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-sm text-[#667085]">{{ ucfirst($user->perfil) }}</td>
                            <td class="px-4 py-3 text-sm text-[#667085]">{{ $user->trashed() ? 'Inativo' : 'Ativo' }}</td>
                            <td class="px-4 py-3 text-right text-sm">
                                <a href="{{ route('users.edit', $user) }}" class="font-semibold text-[#c6366f]">Editar</a>
                                @unless ($user->trashed())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="ml-3 inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-700">Inativar</button>
                                    </form>
                                @endunless
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
```

Create `resources/views/pages/users/create.blade.php` and `resources/views/pages/users/edit.blade.php` with the same layout and fields `nome`, `email`, `perfil`, `senha`, `senha_confirmation`. Use `POST route('users.store')` in create and `PUT route('users.update', $user)` in edit. The edit form must leave password fields blank and explain only that filling them changes the password.

- [ ] **Step 8: Run admin tests**

Run:

```bash
php artisan test tests/Feature/Admin/UserManagementTest.php
```

Expected: PASS.

- [ ] **Step 9: Commit**

```bash
git add app/Http/Middleware/EnsureUserHasProfile.php bootstrap/app.php app/Http/Controllers/Admin/UserController.php resources/views/pages/users routes/web.php tests/Feature/Admin/UserManagementTest.php
git commit -m "feat: add admin user management"
```

---

### Task 5: Final Integration, Regression Tests and Manual Verification

**Files:**
- Modify: `resources/views/components/app/sidebar.blade.php`
- Modify: `.env.example`
- Test: existing auth/admin tests

**Interfaces:**
- Consumes: route `users.index`
- Consumes: route `logout`
- Produces: sidebar link to user management for administrators when authenticated user has `perfil=administrador`

- [ ] **Step 1: Add sidebar access for administrators**

Modify `resources/views/components/app/sidebar.blade.php` to render an admin-only link:

```php
@if (auth()->user()?->isAdministrador())
    <a href="{{ route('users.index') }}" class="...">
        <x-gmdi-manage-accounts-o />
        <span>Usuários</span>
    </a>
@endif
```

Use the existing sidebar item style instead of introducing a new visual pattern.

- [ ] **Step 2: Ensure logout uses POST**

Find any logout link/form in `resources/views/components/app/sidebar.blade.php`. It must submit:

```php
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Sair</button>
</form>
```

If the existing confirm modal supports `method="POST"`, wire it to `route('logout')`. If it only submits links or spoofed verbs, prefer the plain POST form inside the existing visual control.

- [ ] **Step 3: Verify env example has no secret**

Open `.env.example` and confirm:

```env
MAIL_PASSWORD=
ADMIN_SEED_PASSWORD=change-me
```

There must be no real `re_` API key committed.

- [ ] **Step 4: Run focused test suites**

Run:

```bash
php artisan test tests/Feature/Auth tests/Feature/Admin
```

Expected: PASS.

- [ ] **Step 5: Run full backend suite**

Run:

```bash
php artisan test
```

Expected: PASS.

- [ ] **Step 6: Run asset build**

Run:

```bash
npm run build
```

Expected: PASS and Vite build completes without Blade-related asset errors.

- [ ] **Step 7: Manual smoke test**

Run the dev stack:

```bash
composer run dev
```

In the browser, verify:

- Visiting `/home` while logged out redirects to `/`.
- Login with seeded admin reaches `/home`.
- Logout returns to `/`.
- `/usuarios` opens for admin.
- Creating an `atendente` works.
- Logging in as `atendente` makes `/usuarios` return 403.
- `/recover-password` accepts an e-mail and displays the neutral success message.

- [ ] **Step 8: Commit**

```bash
git add resources/views/components/app/sidebar.blade.php .env.example
git commit -m "feat: finish auth integration"
```

---

## Self-Review

Spec coverage:

- Login/logout: Task 2.
- Protected internal pages: Task 2.
- Password reset via Resend SMTP: Task 3.
- Admin-only user management: Task 4.
- Profiles `administrador`, `atendente`, `enfermeira`: Tasks 1 and 4.
- Seed initial admin: Task 1.
- Tests and acceptance criteria: Tasks 1 through 5.

Placeholder scan:

- No deferred requirements are left in the plan.
- No secrets are embedded.

Type consistency:

- `senha` is the persisted password column across migration, model, factory, forms and tests.
- `password` is used only where Laravel's authentication/password broker APIs require that key.
- Route names match tests and controller responsibilities.
