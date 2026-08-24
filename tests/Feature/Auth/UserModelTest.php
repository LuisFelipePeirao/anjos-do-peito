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
