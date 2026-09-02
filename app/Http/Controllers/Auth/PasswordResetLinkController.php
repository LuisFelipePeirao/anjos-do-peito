<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetLinkRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function __construct(private readonly AuthService $auth)
    {
    }

    public function create(): View
    {
        return view('auth.recover-password');
    }

    public function store(PasswordResetLinkRequest $request): RedirectResponse
    {
        $this->auth->sendResetLink($request->validated('email'));

        return back()->with('status', 'Se o e-mail informado estiver cadastrado, voce recebera um link para criar uma nova senha.');
    }
}
