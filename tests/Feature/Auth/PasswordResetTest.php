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

it('rejects password reset with an invalid token', function () {
    $user = User::factory()->create([
        'email' => 'maria@example.com',
        'senha' => 'old-password',
    ]);

    $this->from(route('password.request'))->post(route('password.update'), [
        'token' => 'invalid-token',
        'email' => 'maria@example.com',
        'senha' => 'new-secret-password',
        'senha_confirmation' => 'new-secret-password',
    ])->assertRedirect(route('password.request'));

    expect(Hash::check('old-password', $user->fresh()->senha))->toBeTrue();
});
