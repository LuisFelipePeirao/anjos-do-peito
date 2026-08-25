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
