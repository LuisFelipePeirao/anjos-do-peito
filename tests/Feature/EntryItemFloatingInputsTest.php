<?php

use App\Models\CategoriaMaterial;
use App\Models\Material;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders dynamically added entry item fields as floating inputs', function () {
    $user = User::factory()->administrador()->create();
    $category = CategoriaMaterial::create([
        'nome' => 'Higiene',
        'ativo' => true,
    ]);

    Material::create([
        'nome' => 'Fralda tamanho P',
        'id_categoria' => $category->id,
        'unidade_medida' => 'pacote',
        'estoque_minimo' => 10,
    ]);

    $content = $this->actingAs($user)
        ->get(route('movements.create', ['tipo' => 'entrada']))
        ->assertOk()
        ->getContent();

    preg_match('/<template data-entry-item-template>(.*?)<\/template>/s', $content, $matches);

    expect($matches[1])
        ->toContain('data-entry-quantity')
        ->toContain('data-entry-observation')
        ->toContain('class="peer');
});
