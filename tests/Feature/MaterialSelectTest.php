<?php

use Illuminate\Support\Facades\Blade;

it('renders the select label inside the field without a placeholder option', function () {
    $html = Blade::render(
        '<x-material.select name="origem" label="Origem do cadastro" :options="$options" placeholder="Selecione" required />',
        ['options' => ['busca_espontanea' => 'Busca espontânea']]
    );

    expect($html)
        ->toContain('label="Origem do cadastro"')
        ->toContain('required')
        ->toContain('no-asterisk')
        ->toContain('data-select-required-asterisk')
        ->toContain('text-[#c2414b]')
        ->toContain('value="busca_espontanea"')
        ->not->toContain('>Selecione<')
        ->not->toContain('<span class="block text-sm font-semibold text-[#344054]">');
});

it('keeps the selected option when the select has a value', function () {
    $html = Blade::render(
        '<x-material.select name="origem" label="Origem do cadastro" :options="$options" selected="indicacao" />',
        ['options' => ['indicacao' => 'Indicação']]
    );

    expect($html)->toMatch('/value="indicacao"\s+selected/');
});
