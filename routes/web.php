<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/recover-password', function () {
    return view('auth.recover-password');
})->name('recover-password');

Route::get('/new-password', function () {
    return view('auth.new-password');
})->name('new-password');

Route::get('/home', function () {
    $kpis = [
        [
            'label' => 'Beneficiárias ativas',
            'value' => '184',
            'context' => '+12 novos cadastros em agosto',
            'trend' => '+7,1%',
            'trendType' => 'up',
            'icon' => 'users',
            'tone' => 'rose',
        ],
        [
            'label' => 'Atendimentos no mês',
            'value' => '42',
            'context' => 'Meta mensal: 55 atendimentos',
            'trend' => '+18,4%',
            'trendType' => 'up',
            'icon' => 'clipboard-list',
            'tone' => 'blue',
        ],
        [
            'label' => 'Bombas disponíveis',
            'value' => '8',
            'context' => '40% do parque operacional livre',
            'trend' => '-2 un.',
            'trendType' => 'down',
            'icon' => 'package',
            'tone' => 'green',
        ],
        [
            'label' => 'Riscos operacionais',
            'value' => '9',
            'context' => '3 devoluções e 6 itens críticos',
            'trend' => '+3',
            'trendType' => 'down',
            'icon' => 'triangle-alert',
            'tone' => 'amber',
        ],
    ];

    $monthlyAttendances = [
        'percent' => '82%',
        'values' => [
            ['month' => 'Abr', 'total' => 50, 'target' => 38],
            ['month' => 'Mar', 'total' => 26, 'target' => 38],
            ['month' => 'Mai', 'total' => 37, 'target' => 42],
            ['month' => 'Jun', 'total' => 34, 'target' => 45],
            ['month' => 'Jul', 'total' => 46, 'target' => 50],
            ['month' => 'Ago', 'total' => 42, 'target' => 55],
        ],
    ];

    $stock = [
        ['label' => 'Bombas', 'available' => 8, 'used' => 12, 'minimum' => 6],
        ['label' => 'Fraldas M', 'available' => 24, 'used' => 36, 'minimum' => 30],
        ['label' => 'Leite em pó', 'available' => 18, 'used' => 42, 'minimum' => 25],
        ['label' => 'Lenços', 'available' => 15, 'used' => 28, 'minimum' => 20],
    ];

    $pipeline = [
        ['label' => 'Triagem', 'value' => 23, 'percent' => 100],
        ['label' => 'Cadastro', 'value' => 18, 'percent' => 78],
        ['label' => 'Atendimento', 'value' => 14, 'percent' => 61],
        ['label' => 'Acompanhamento', 'value' => 9, 'percent' => 39],
    ];

    $risks = [
        ['title' => '3 bombas com devolução atrasada', 'description' => 'BP-004, BP-002 e BP-011 estão fora do prazo previsto.', 'tone' => 'red'],
        ['title' => '6 itens abaixo do estoque mínimo', 'description' => 'Leite em pó, fralda M e lenço umedecido exigem reposição.', 'tone' => 'amber'],
        ['title' => '5 beneficiárias sem retorno', 'description' => 'Casos aguardando contato da equipe há mais de 7 dias.', 'tone' => 'blue'],
    ];

    $recent = [
        ['time' => '14:30', 'title' => 'Atendimento registrado para Maria da Silva.', 'meta' => 'Consulta de acompanhamento'],
        ['time' => '11:20', 'title' => 'Bomba BP-015 emprestada para Ana Souza.', 'meta' => 'Previsão de devolução em 30 dias'],
        ['time' => '09:45', 'title' => 'Entrada de 20 pacotes de fraldas no estoque.', 'meta' => 'Doação registrada pela equipe'],
    ];

    $maxAttendance = $monthlyAttendances['values'] ? max(array_column($monthlyAttendances['values'], 'total')) : 0;
    $totalStock = array_sum(array_column($stock, 'available')) + array_sum(array_column($stock, 'used'));

    return view('pages.home', compact(
        'kpis',
        'monthlyAttendances',
        'stock',
        'pipeline',
        'risks',
        'recent',
        'maxAttendance',
        'totalStock'
    ));
})->name('home');

Route::get('/beneficiarias', function () {
    $kpis = [
        [
            'label' => 'Beneficiárias ativas',
            'value' => '4',
            'context' => 'Beneficiárias com acompanhamento ativo',
            'trend' => '+2',
            'trendType' => 'up',
            'icon' => 'users',
            'tone' => 'rose',
        ],
        [
            'label' => 'Total cadastrado',
            'value' => '6',
            'context' => 'Beneficiárias cadastradas no sistema',
            'trend' => '+12%',
            'trendType' => 'up',
            'icon' => 'badge-check',
            'tone' => 'green',
        ],
        [
            'label' => 'Cadastros inativos',
            'value' => '2',
            'context' => 'Sem acompanhamento ativo',
            'trend' => '-1',
            'trendType' => 'down',
            'icon' => 'triangle-alert',
            'tone' => 'amber',
        ],
    ];

    $beneficiaries = [
        ['name' => 'Maria da Silva', 'cpf' => '123.456.789-01', 'mail' => 'maria.silva@example.com', 'phone' => '(11) 98765-4321', 'status' => 'Ativa'],
        ['name' => 'Ana Souza', 'cpf' => '987.654.321-00', 'mail' => 'ana.souza@example.com', 'phone' => '(11) 97654-3210', 'status' => 'Ativa'],
        ['name' => 'Juliana Martins', 'cpf' => '456.123.789-55', 'mail' => 'juliana.martins@example.com', 'phone' => '(11) 96543-2109', 'status' => 'Ativa'],
        ['name' => 'Camila Rocha', 'cpf' => '321.654.987-22', 'mail' => 'camila.rocha@example.com', 'phone' => '(11) 95432-1098', 'status' => 'Inativa'],
        ['name' => 'Patrícia Lima', 'cpf' => '741.852.963-44', 'mail' => 'patricia.lima@example.com', 'phone' => '(11) 94321-0987', 'status' => 'Ativa'],
        ['name' => 'Renata Alves', 'cpf' => '159.357.258-66', 'mail' => 'renata.alves@example.com', 'phone' => '(11) 93210-9876', 'status' => 'Inativa'],
    ];

    $search = trim((string) request('q', ''));
    $status = request('status', 'active');

    $filteredBeneficiaries = collect($beneficiaries)
        ->when($status === 'active', fn ($items) => $items->where('status', 'Ativa'))
        ->when($search !== '', function ($items) use ($search) {
            $normalizedSearch = preg_replace('/\D/', '', $search);
            $lowerSearch = mb_strtolower($search);

            return $items->filter(function ($beneficiary) use ($normalizedSearch, $lowerSearch) {
                $nameMatches = str_contains(mb_strtolower($beneficiary['name']), $lowerSearch);
                $cpfMatches = $normalizedSearch !== ''
                    && str_contains(preg_replace('/\D/', '', $beneficiary['cpf']), $normalizedSearch);

                return $nameMatches || $cpfMatches;
            });
        })
        ->map(function ($beneficiary) {
            $beneficiary['_actions'] = [
                'items' => [
                    [
                        'icon' => 'eye',
                        'route' => route('beneficiaries.show', preg_replace('/\D/', '', $beneficiary['cpf'])),
                        'title' => 'Visualizar',
                    ],
                    [
                        'icon' => 'trash-2',
                        'route' => '#',
                        'title' => 'Excluir',
                        'variant' => 'danger',
                    ],
                ],
            ];

            return $beneficiary;
        })
        ->values()
        ->all();

    return view('pages.beneficiaries.index', [
        'beneficiaries' => $filteredBeneficiaries,
        'totalBeneficiaries' => count($beneficiaries),
        'activeBeneficiaries' => collect($beneficiaries)->where('status', 'Ativa')->count(),
        'search' => $search,
        'status' => $status,
        'kpis' => $kpis,
    ]);
})->name('beneficiaries.index');

Route::get('/beneficiarias/{cpf}', function (string $cpf) {
    $beneficiary = [
        'name' => 'Maria da Silva',
        'initials' => 'Md',
        'status' => 'Ativa',
        'cpf' => '123.456.789-00',
        'phone' => '(47) 99999-1234',
        'birth_date' => '15/04/1997',
        'baby_name' => 'Lucas',
        'registered_at' => '14/05/2026',
        'address' => 'Rua das Palmeiras, 245 - Centro',
    ];

    $kpis = [
        ['label' => 'Atendimentos realizados', 'value' => '6', 'context' => '', 'trend' => null, 'trendType' => 'up', 'icon' => 'clipboard-list', 'tone' => 'rose'],
        ['label' => 'Último atendimento', 'value' => '07/08/2026', 'context' => '', 'trend' => null, 'trendType' => 'up', 'icon' => 'calendar-days', 'tone' => 'blue'],
        ['label' => 'Bomba em uso', 'value' => 'BP-004', 'context' => '', 'trend' => null, 'trendType' => 'down', 'icon' => 'wrench', 'tone' => 'rose'],
        ['label' => 'Distribuições recebidas', 'value' => '4', 'context' => '', 'trend' => null, 'trendType' => 'up', 'icon' => 'package', 'tone' => 'amber'],
    ];

    $attendances = [
        ['date' => '08/08/2026', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial na ONG', 'summary' => 'Orientações sobre amamentação e pega correta', 'return' => '20/08/2026', '_actions' => ['view' => '#']],
        ['date' => '29/07/2026', 'professional' => 'Camila Rocha', 'modality' => 'Presencial na ONG', 'summary' => 'Avaliação de ganho de peso do bebê', 'return' => '-', '_actions' => ['view' => '#']],
    ];

    $pumps = [
        ['code' => 'BP-004', 'withdrawn_at' => '22/07/2026', 'expected_return' => '05/08/2026', 'returned_at' => '-', 'status' => 'Em atraso'],
    ];

    $donations = [
        ['date' => '01/08/2026', 'items' => 'Fralda tamanho P', 'quantity' => '1 pacote', 'responsible' => 'Camila Rocha'],
        ['date' => '01/08/2026', 'items' => 'Kit de higiene', 'quantity' => '1 kit', 'responsible' => 'Camila Rocha'],
        ['date' => '12/07/2026', 'items' => 'Leite em pó', 'quantity' => '2 latas', 'responsible' => 'Fernanda Souza'],
        ['date' => '20/06/2026', 'items' => 'Roupas de bebê RN', 'quantity' => '5 peças', 'responsible' => 'Mariana Fernandes'],
    ];

    $history = [
        ['date' => '07/08/2026', 'type' => 'Atendimento realizado', 'description' => 'Orientações relacionadas à amamentação e pega correta.', 'responsible' => 'Fernanda Souza', 'icon' => 'clipboard-list'],
        ['date' => '01/08/2026', 'type' => 'Distribuição de itens', 'description' => '1 pacote de fralda tamanho P e 1 kit de higiene.', 'responsible' => 'Camila Rocha', 'icon' => 'gift'],
        ['date' => '22/07/2026', 'type' => 'Empréstimo de bomba', 'description' => 'Bomba BP-004 - previsão de devolução em 05/08/2026.', 'responsible' => 'Camila Rocha', 'icon' => 'wrench'],
        ['date' => '12/07/2026', 'type' => 'Distribuição de itens', 'description' => '2 latas de leite em pó.', 'responsible' => 'Fernanda Souza', 'icon' => 'gift'],
        ['date' => '29/06/2026', 'type' => 'Atendimento realizado', 'description' => 'Avaliação de ganho de peso do bebê Lucas.', 'responsible' => 'Camila Rocha', 'icon' => 'clipboard-list'],
        ['date' => '14/05/2026', 'type' => 'Cadastro realizado', 'description' => 'Beneficiária cadastrada no sistema da ONG.', 'responsible' => 'Mariana Fernandes', 'icon' => 'clipboard-list'],
    ];

    $recentInfo = [
        ['title' => 'Último atendimento', 'description' => '08/08/2026 - Orientações sobre amamentação e pega correta', 'meta' => 'Profissional: Fernanda Souza', 'link' => route('beneficiaries.show', ['cpf' => $cpf, 'tab' => 'attendances']), 'button' => 'Ver atendimentos', 'icon' => 'clipboard-list'],
        ['title' => 'Empréstimo atual', 'description' => 'Bomba BP-004 - retirada em 22/07/2026', 'meta' => 'Devolução atrasada', 'link' => route('beneficiaries.show', ['cpf' => $cpf, 'tab' => 'pumps']), 'button' => 'Ver bombas', 'icon' => 'wrench'],
        ['title' => 'Última distribuição', 'description' => '01/08/2026 - 1 pacote de Fralda tamanho P', 'meta' => 'Responsável: Camila Rocha', 'link' => route('beneficiaries.show', ['cpf' => $cpf, 'tab' => 'donations']), 'button' => 'Ver doações', 'icon' => 'gift'],
    ];

    $tab = request('tab', 'overview');

    return view('pages.beneficiaries.show', compact(
        'beneficiary',
        'kpis',
        'attendances',
        'pumps',
        'donations',
        'history',
        'recentInfo',
        'tab',
        'cpf'
    ));
})->name('beneficiaries.show');
