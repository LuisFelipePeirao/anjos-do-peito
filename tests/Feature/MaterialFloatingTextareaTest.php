<?php

use Illuminate\Support\Facades\Blade;

it('renders a required textarea with a floating label', function () {
    $html = Blade::render(
        '<x-material.floating-textarea name="notes" label="Observações" value="Texto" required />'
    );

    expect($html)
        ->toContain('name="notes"')
        ->toContain('peer-focus:-top-2.5')
        ->toContain('peer-not-placeholder-shown:-top-2.5')
        ->toContain('required')
        ->toContain('text-[#c2414b]');
});
