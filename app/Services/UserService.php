<?php

namespace App\Services;

use App\Http\Requests\Users\StoreUserRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function indexData(array $filters): array
    {
        $search = $filters['search'];
        $status = $filters['status'];
        $profile = $filters['profile'];

        $users = User::query()
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
            ->when(in_array($profile, StoreUserRequest::profiles(), true), fn ($query) => $query->where('perfil', $profile))
            ->orderBy('nome')
            ->get()
            ->map(fn (User $user) => [
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
            ]);

        return [
            'users' => $users,
            'search' => $search,
            'status' => $status,
            'profile' => $profile,
            'profiles' => StoreUserRequest::profiles(),
        ];
    }

    public function profiles(): array
    {
        return StoreUserRequest::profiles();
    }

    public function create(array $data): void
    {
        User::query()->create($data);
    }

    public function update(User $user, array $data): void
    {
        if (! filled($data['senha'] ?? null)) {
            unset($data['senha']);
        }

        $user->update($data);
    }

    public function deactivate(User $user): void
    {
        if ($user->isAdministrador() && User::query()->where('perfil', 'administrador')->count() === 1) {
            throw ValidationException::withMessages([
                'usuario' => 'Não é permitido inativar o único administrador ativo.',
            ]);
        }

        $user->delete();
    }
}
