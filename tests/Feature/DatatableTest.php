<?php

it('uses the page-specific deletion confirmation when an action defines only its method', function () {
    $html = view('components.tables.datatable', [
        'header' => ['Registro'],
        'data' => [[
            'name' => 'Bomba BL-001',
            '_actions' => [
                'items' => [[
                    'icon' => 'delete-o',
                    'route' => '/bombas-de-leite/1',
                    'title' => 'Excluir bomba',
                    'variant' => 'danger',
                    'confirmation' => ['method' => 'DELETE'],
                ]],
            ],
        ]],
        'deleteConfirmation' => [
            'title' => 'Excluir bomba de leite?',
            'message' => 'Bombas vinculadas serão inativadas.',
            'confirmLabel' => 'Excluir bomba',
        ],
    ])->render();

    expect($html)
        ->toContain('Excluir bomba de leite?')
        ->toContain('Bombas vinculadas serão inativadas.')
        ->toContain('Excluir bomba');
});
