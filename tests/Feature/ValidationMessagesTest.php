<?php

use Illuminate\Support\Facades\File;

it('defines Portuguese validation messages in every form request', function () {
    $requests = collect(File::allFiles(app_path('Http/Requests')))
        ->map(fn (SplFileInfo $file) => 'App\\Http\\Requests\\'.str_replace(
            ['/', '.php'],
            ['\\', ''],
            $file->getRelativePathname(),
        ));

    $requests->each(function (string $request) {
        expect(method_exists($request, 'messages'))
            ->toBeTrue("{$request} must define validation messages.");

        expect((new $request)->messages())
            ->not->toBeEmpty();
    });
});

it('returns Portuguese messages to users after validation fails', function () {
    $this->from(route('password.request'))
        ->post(route('password.email'), ['email' => 'invalido'])
        ->assertRedirect(route('password.request'))
        ->assertSessionHasErrors([
            'email' => 'O e-mail informado não é válido.',
        ]);
});

it('displays the password validation message on the login page', function () {
    $this->from(route('login'))
        ->post(route('login.store'), [
            'email' => 'usuario@example.com',
            'senha' => '',
        ])
        ->assertRedirect(route('login'));

    $this
        ->get(route('login'))
        ->assertSee('O campo senha é obrigatório.');
});
