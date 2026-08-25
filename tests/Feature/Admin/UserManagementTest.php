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
