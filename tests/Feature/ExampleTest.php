<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('login page has keyboard navigation landmarks and labelled inputs', function () {
    $response = $this->get('/');

    $response->assertSee('lang="pt-BR"', false)
        ->assertSee('href="#inicio-conteudo"', false)
        ->assertSee('id="conteudo"', false)
        ->assertSee('label="E-mail"', false)
        ->assertSee('name="email"', false)
        ->assertSee('label="Senha"', false)
        ->assertSee('name="senha"', false);
});

test('login form groups its credentials with a descriptive legend', function () {
    $response = $this->get('/');

    $response->assertSee('<fieldset', false)
        ->assertSee('<legend class="sr-only">Credenciais de acesso</legend>', false);
});

test('login page provides an eMAG skip link and a no-JavaScript fallback', function () {
    $response = $this->get('/');

    $response->assertSee('href="#inicio-conteudo"', false)
        ->assertSee('accesskey="1"', false)
        ->assertSee('id="inicio-conteudo"', false)
        ->assertSee('name="inicio-conteudo"', false)
        ->assertSee('<noscript>', false)
        ->assertSee('E-mail para acesso sem JavaScript', false)
        ->assertSee('Senha para acesso sem JavaScript', false);
});

test('login page exposes only one top-level heading across script fallbacks', function () {
    $response = $this->get('/');

    expect(substr_count($response->getContent(), '<h1'))->toBe(1);
});
