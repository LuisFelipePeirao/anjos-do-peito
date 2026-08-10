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

Route::get('/beneficiarias/nova', function () {
    return view('pages.beneficiaries.create');
})->name('beneficiaries.create');

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
        ['date' => '08/08/2026', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial', 'summary' => 'Orientações sobre amamentação e pega correta', 'return' => '20/08/2026', '_actions' => ['view' => '#']],
        ['date' => '29/07/2026', 'professional' => 'Camila Rocha', 'modality' => 'Presencial', 'summary' => 'Avaliação de ganho de peso do bebê', 'return' => '-', '_actions' => ['view' => '#']],
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

Route::get('/atendimentos', function () {
    $kpis = [
        [
            'label' => 'Atendimentos no mês',
            'value' => '42',
            'context' => 'Registros realizados em agosto',
            'trend' => '+18,4%',
            'trendType' => 'up',
            'icon' => 'clipboard-list',
            'tone' => 'rose',
        ],
        [
            'label' => 'Agendados',
            'value' => '12',
            'context' => 'Atendimentos futuros confirmados',
            'trend' => '+4',
            'trendType' => 'up',
            'icon' => 'calendar-days',
            'tone' => 'blue',
        ],
        [
            'label' => 'Retornos pendentes',
            'value' => '5',
            'context' => 'Casos aguardando novo contato',
            'trend' => '+2',
            'trendType' => 'down',
            'icon' => 'clock',
            'tone' => 'amber',
        ],
        [
            'label' => 'Realizados hoje',
            'value' => '3',
            'context' => 'Atendimentos concluídos em 10/08',
            'trend' => null,
            'trendType' => 'up',
            'icon' => 'circle-check',
            'tone' => 'green',
        ],
    ];

    $attendances = [
        ['date' => '10/08/2026', 'time' => '14:30', 'beneficiary' => 'Maria da Silva', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial', 'status' => 'Agendado', 'summary' => 'Orientações sobre amamentação'],
        ['date' => '10/08/2026', 'time' => '09:15', 'beneficiary' => 'Ana Souza', 'professional' => 'Camila Rocha', 'modality' => 'Remota', 'status' => 'Realizado', 'summary' => 'Retorno sobre ganho de peso'],
        ['date' => '09/08/2026', 'time' => '16:00', 'beneficiary' => 'Juliana Martins', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial', 'status' => 'Retorno pendente', 'summary' => 'Avaliação de pega correta'],
        ['date' => '08/08/2026', 'time' => '13:40', 'beneficiary' => 'Patrícia Lima', 'professional' => 'Mariana Fernandes', 'modality' => 'Presencial', 'status' => 'Realizado', 'summary' => 'Entrega de itens e orientação'],
        ['date' => '07/08/2026', 'time' => '10:20', 'beneficiary' => 'Camila Rocha', 'professional' => 'Camila Rocha', 'modality' => 'Remota', 'status' => 'Cancelado', 'summary' => 'Beneficiária solicitou reagendamento'],
        ['date' => '06/08/2026', 'time' => '15:10', 'beneficiary' => 'Renata Alves', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial', 'status' => 'Realizado', 'summary' => 'Acompanhamento puerperal'],
    ];

    $search = trim((string) request('q', ''));
    $status = request('status', 'all');
    $modality = request('modality', 'all');

    $filteredAttendances = collect($attendances)
        ->when($status !== 'all', fn ($items) => $items->where('status', $status))
        ->when($modality !== 'all', fn ($items) => $items->where('modality', $modality))
        ->when($search !== '', function ($items) use ($search) {
            $lowerSearch = mb_strtolower($search);

            return $items->filter(function ($attendance) use ($lowerSearch) {
                return str_contains(mb_strtolower($attendance['beneficiary']), $lowerSearch)
                    || str_contains(mb_strtolower($attendance['professional']), $lowerSearch)
                    || str_contains(mb_strtolower($attendance['summary']), $lowerSearch);
            });
        })
        ->map(function ($attendance, $index) {
            $attendance['_id'] = $index + 1;
            $attendance['_actions'] = [
                'items' => [
                    [
                        'icon' => 'eye',
                        'route' => route('attendances.show', $index + 1),
                        'title' => 'Visualizar',
                    ],
                    [
                        'icon' => 'pencil',
                        'route' => route('attendances.edit', $index + 1),
                        'title' => 'Editar',
                    ],
                    [
                        'icon' => 'trash-2',
                        'route' => '#',
                        'title' => 'Excluir',
                        'variant' => 'danger',
                    ],
                ],
            ];

            return $attendance;
        })
        ->values()
        ->all();

    return view('pages.attendances.index', [
        'attendances' => $filteredAttendances,
        'search' => $search,
        'status' => $status,
        'modality' => $modality,
        'kpis' => $kpis,
    ]);
})->name('attendances.index');

Route::get('/atendimentos/novo', function () {
    $attendanceData = [
        'id' => null,
        'beneficiary' => '',
        'professional' => '',
        'date' => '',
        'time' => '',
        'duration' => '45',
        'status' => 'Agendado',
        'modality' => 'Presencial',
        'location' => '',
        'return_date' => '',
        'priority' => 'Média',
        'summary' => '',
        'objective' => '',
        'complaint' => '',
        'evaluation' => '',
        'conduct' => '',
        'referral' => '',
        'notes' => '',
    ];

    return view('pages.attendances.form', [
        'mode' => 'create',
        'attendanceData' => $attendanceData,
        'beneficiaries' => ['Maria da Silva', 'Ana Souza', 'Juliana Martins', 'Patrícia Lima', 'Renata Alves'],
        'professionals' => ['Fernanda Souza', 'Camila Rocha', 'Mariana Fernandes'],
        'locations' => ['Hospital Azambuja', 'Domiciliar', 'Google Meet', 'Teleatendimento'],
    ]);
})->name('attendances.create');

Route::get('/atendimentos/{attendance}/editar', function (string $attendance) {
    $attendanceData = [
        'id' => $attendance,
        'beneficiary' => 'Maria da Silva',
        'professional' => 'Fernanda Souza',
        'date' => '2026-08-10',
        'time' => '14:30',
        'duration' => '45',
        'status' => 'Agendado',
        'modality' => 'Presencial',
        'location' => 'Domiciliar',
        'return_date' => '2026-08-20',
        'priority' => 'Média',
        'summary' => 'Orientações sobre amamentação e pega correta.',
        'objective' => 'Avaliar a amamentação, orientar manejo de dor e definir necessidade de retorno.',
        'complaint' => 'Dor durante a mamada e insegurança sobre pega correta.',
        'evaluation' => 'Bebê ativo, mãe orientada e com boa resposta às correções de posicionamento.',
        'conduct' => 'Foi reforçada a posição confortável da mãe, sinais de pega efetiva e livre demanda.',
        'referral' => 'Retorno agendado para acompanhamento do ganho de peso.',
        'notes' => 'Confirmar presença por telefone no dia anterior.',
    ];

    return view('pages.attendances.form', [
        'mode' => 'edit',
        'attendanceData' => $attendanceData,
        'beneficiaries' => ['Maria da Silva', 'Ana Souza', 'Juliana Martins', 'Patrícia Lima', 'Renata Alves'],
        'professionals' => ['Fernanda Souza', 'Camila Rocha', 'Mariana Fernandes'],
        'locations' => ['Hospital Azambuja', 'Domiciliar', 'Google Meet', 'Teleatendimento'],
    ]);
})->name('attendances.edit');

Route::get('/atendimentos/{attendance}', function (string $attendance) {
    $attendanceData = [
        'id' => $attendance,
        'date' => '10/08/2026',
        'time' => '14:30',
        'status' => 'Agendado',
        'modality' => 'Presencial',
        'beneficiary' => 'Maria da Silva',
        'beneficiary_initials' => 'Md',
        'cpf' => '123.456.789-00',
        'phone' => '(47) 99999-1234',
        'baby_name' => 'Lucas',
        'professional' => 'Fernanda Souza',
        'registered_by' => 'Mariana Fernandes',
        'location' => 'Domiciliar',
        'return_date' => '20/08/2026',
        'summary' => 'Orientações sobre amamentação e pega correta.',
        'objective' => 'Avaliar a amamentação, orientar manejo de dor e definir necessidade de retorno.',
        'conduct' => 'Foi reforçada a posição confortável da mãe, sinais de pega efetiva e livre demanda. Retorno agendado para acompanhamento do ganho de peso.',
    ];

    $kpis = [
        ['label' => 'Duração prevista', 'value' => '45 min', 'context' => 'Janela reservada na agenda', 'trend' => null, 'trendType' => 'up', 'icon' => 'clock', 'tone' => 'rose'],
        ['label' => 'Retorno previsto', 'value' => '20/08', 'context' => 'Próximo acompanhamento', 'trend' => null, 'trendType' => 'up', 'icon' => 'calendar-days', 'tone' => 'blue'],
        ['label' => 'Atendimentos da beneficiária', 'value' => '6', 'context' => 'Histórico acumulado', 'trend' => '+1', 'trendType' => 'up', 'icon' => 'clipboard-list', 'tone' => 'green'],
        ['label' => 'Prioridade', 'value' => 'Média', 'context' => 'Sem alerta crítico no momento', 'trend' => null, 'trendType' => 'down', 'icon' => 'triangle-alert', 'tone' => 'amber'],
    ];

    $evolution = [
        ['item' => 'Queixa principal', 'description' => 'Dor durante a mamada e insegurança sobre pega correta.', 'responsible' => 'Fernanda Souza'],
        ['item' => 'Avaliação', 'description' => 'Bebê ativo, mãe orientada e com boa resposta às correções de posicionamento.', 'responsible' => 'Fernanda Souza'],
        ['item' => 'Conduta', 'description' => 'Manter livre demanda, observar sinais de saciedade e retornar em 10 dias.', 'responsible' => 'Fernanda Souza'],
    ];

    $referrals = [
        ['date' => '10/08/2026', 'type' => 'Retorno agendado', 'description' => 'Acompanhar ganho de peso e adaptação da pega.', 'status' => 'Agendado'],
        ['date' => '10/08/2026', 'type' => 'Material educativo', 'description' => 'Orientações impressas sobre posições de amamentação.', 'status' => 'Realizado'],
    ];

    $history = [
        ['date' => '10/08/2026', 'type' => 'Atendimento agendado', 'description' => 'Atendimento registrado na agenda da equipe.', 'responsible' => 'Mariana Fernandes', 'icon' => 'calendar-days'],
        ['date' => '09/08/2026', 'type' => 'Contato confirmado', 'description' => 'Beneficiária confirmou presença por telefone.', 'responsible' => 'Camila Rocha', 'icon' => 'phone'],
        ['date' => '08/08/2026', 'type' => 'Triagem atualizada', 'description' => 'Caso marcado para orientação de amamentação.', 'responsible' => 'Fernanda Souza', 'icon' => 'clipboard-list'],
    ];

    $tab = request('tab', 'overview');

    return view('pages.attendances.show', compact(
        'attendance',
        'attendanceData',
        'kpis',
        'evolution',
        'referrals',
        'history',
        'tab'
    ));
})->name('attendances.show');
