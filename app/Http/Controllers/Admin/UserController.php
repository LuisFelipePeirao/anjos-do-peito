<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Requests\Users\UserFilterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private readonly UserService $users)
    {
    }

    public function index(UserFilterRequest $request): View
    {
        return view('pages.users.index', $this->users->indexData($request->filters()));
    }

    public function create(): View
    {
        return view('pages.users.create', [
            'profiles' => $this->users->profiles(),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->users->create($request->validated());

        return redirect()->route('users.index')->with('status', 'Usuário criado com sucesso.');
    }

    public function edit(User $usuario): View
    {
        return view('pages.users.edit', [
            'user' => $usuario,
            'profiles' => $this->users->profiles(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $usuario): RedirectResponse
    {
        $this->users->update($usuario, $request->validated());

        return redirect()->route('users.index')->with('status', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        $this->users->deactivate($usuario);

        return redirect()->route('users.index')->with('status', 'Usuario inativado com sucesso.');
    }
}
