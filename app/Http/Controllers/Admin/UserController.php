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
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $status = $request->string('status', 'all')->toString();
        $profile = $request->string('profile', 'all')->toString();

        $usersQuery = User::query()
            ->withTrashed()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('nome', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', fn ($query) => $query->whereNull('deleted_at'))
            ->when($status === 'inactive', fn ($query) => $query->whereNotNull('deleted_at'))
            ->when(in_array($profile, $this->profiles(), true), fn ($query) => $query->where('perfil', $profile))
            ->orderBy('nome');

        return view('pages.users.index', [
            'users' => $usersQuery->get()->map(fn (User $user) => [
                'nome' => $user->nome,
                'email' => $user->email,
                'perfil' => ucfirst($user->perfil),
                'status' => $user->trashed() ? 'Inativa' : 'Ativa',
                '_actions' => [
                    'items' => $user->trashed() ? [] : [
                        [
                            'icon' => 'edit-o',
                            'route' => route('users.edit', $user),
                            'title' => 'Editar usuário',
                        ],
                        [
                            'icon' => 'delete-o',
                            'route' => route('users.destroy', $user),
                            'title' => 'Inativar usuário',
                            'variant' => 'danger',
                            'confirmation' => [
                                'title' => 'Inativar usuário?',
                                'message' => 'O usuário deixará de acessar o sistema, mas o histórico será preservado. Deseja continuar?',
                                'confirmLabel' => 'Inativar usuário',
                                'variant' => 'danger',
                                'method' => 'DELETE',
                            ],
                        ],
                    ],
                ],
            ]),
            'search' => $search,
            'status' => $status,
            'profile' => $profile,
            'profiles' => $this->profiles(),
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

        return redirect()->route('users.index')->with('status', 'Usuario inativado com sucesso.');
    }

    private function profiles(): array
    {
        return ['administrador', 'atendente', 'enfermeira'];
    }
}
