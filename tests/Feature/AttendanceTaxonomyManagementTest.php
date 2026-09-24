<?php

use App\Models\CategoriaAtendimento;
use App\Models\Procedimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('manages procedures from attendance modal routes', function () {
    $user = User::factory()->enfermeira()->create();

    $this->actingAs($user)
        ->post(route('attendances.procedures.store'), [
            'nome' => 'Laserterapia',
            'descricao' => 'Aplicação conforme protocolo.',
        ])
        ->assertRedirect();

    $procedure = Procedimento::firstOrFail();

    $this->assertDatabaseHas('procedimentos', ['nome' => 'Laserterapia', 'ativo' => true]);

    $this->actingAs($user)
        ->put(route('attendances.procedures.update', $procedure), [
            'nome' => 'Laserterapia mamária',
            'descricao' => 'Descrição atualizada.',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('procedimentos', ['id' => $procedure->id, 'nome' => 'Laserterapia mamária']);

    $this->actingAs($user)
        ->patch(route('attendances.procedures.toggle', $procedure))
        ->assertRedirect();

    expect($procedure->fresh()->ativo)->toBeFalse();
});

it('manages attendance categories from attendance modal routes', function () {
    $user = User::factory()->enfermeira()->create();

    $this->actingAs($user)
        ->post(route('attendances.categories.store'), ['nome' => 'Gestantes'])
        ->assertRedirect();

    $category = CategoriaAtendimento::firstOrFail();

    $this->actingAs($user)
        ->put(route('attendances.categories.update', $category), [
            'nome' => 'Gestantes de alto risco',
            'descricao' => 'Grupo prioritário.',
        ])
        ->assertRedirect();

    $this->actingAs($user)
        ->patch(route('attendances.categories.toggle', $category))
        ->assertRedirect();

    expect($category->fresh()->ativo)->toBeFalse();
});
