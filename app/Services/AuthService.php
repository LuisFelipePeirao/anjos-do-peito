<?php

namespace App\Services;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $credentials, bool $remember, Session $session): void
    {
        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['senha'],
        ], $remember)) {
            throw ValidationException::withMessages([
                'email' => 'As credenciais informadas não conferem.',
            ]);
        }

        $session->regenerate();
    }

    public function logout(Session $session): void
    {
        Auth::guard('web')->logout();

        $session->invalidate();
        $session->regenerateToken();
    }

    public function sendResetLink(string $email): void
    {
        Password::sendResetLink(['email' => $email]);
    }

    public function resetPassword(array $data): string
    {
        return Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['senha'],
                'password_confirmation' => $data['senha'],
                'token' => $data['token'],
            ],
            function ($user) use ($data) {
                $user->forceFill([
                    'senha' => Hash::make($data['senha']),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
    }
}
