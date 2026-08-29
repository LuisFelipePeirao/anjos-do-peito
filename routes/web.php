<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PumpController;
use App\Http\Controllers\PumpLoanController;
use Illuminate\Support\Facades\Route;

Route::view('/icon', 'icons.index')->name('icons.index');

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/recover-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/recover-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/new-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/new-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::middleware('profile:administrador')->group(function () {
        Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
        Route::get('/usuarios/novo', [UserController::class, 'create'])->name('users.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
        Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::get('/beneficiarias', [BeneficiaryController::class, 'index'])->name('beneficiaries.index');
    Route::get('/beneficiarias/nova', [BeneficiaryController::class, 'create'])->name('beneficiaries.create');
    Route::post('/beneficiarias', [BeneficiaryController::class, 'store'])->name('beneficiaries.store');
    Route::get('/beneficiarias/{beneficiaria}', [BeneficiaryController::class, 'show'])->name('beneficiaries.show');
    Route::get('/beneficiarias/{beneficiaria}/editar', [BeneficiaryController::class, 'edit'])->name('beneficiaries.edit');
    Route::put('/beneficiarias/{beneficiaria}', [BeneficiaryController::class, 'update'])->name('beneficiaries.update');
    Route::patch('/beneficiarias/{beneficiaria}/inativar', [BeneficiaryController::class, 'deactivate'])->name('beneficiaries.deactivate');
    Route::post('/beneficiarias/{beneficiaria}/criancas', [BeneficiaryController::class, 'storeChild'])->name('beneficiaries.children.store');
    Route::put('/beneficiarias/{beneficiaria}/criancas/{crianca}', [BeneficiaryController::class, 'updateChild'])->name('beneficiaries.children.update');
    Route::delete('/beneficiarias/{beneficiaria}/criancas/{crianca}', [BeneficiaryController::class, 'destroyChild'])->name('beneficiaries.children.destroy');

    Route::middleware('profile:administrador,enfermeira')->group(function () {
        Route::get('/atendimentos', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/atendimentos/novo', [AttendanceController::class, 'create'])->name('attendances.create');
        Route::post('/atendimentos', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::post('/atendimentos/locais', [AttendanceController::class, 'storeLocation'])->name('attendances.locations.store');
        Route::get('/atendimentos/beneficiarias/{beneficiaria}/criancas', [AttendanceController::class, 'children'])->name('attendances.children.index');
        Route::get('/atendimentos/{attendance}', [AttendanceController::class, 'show'])->name('attendances.show');
        Route::get('/atendimentos/{attendance}/editar', [AttendanceController::class, 'edit'])->name('attendances.edit');
        Route::put('/atendimentos/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
        Route::patch('/atendimentos/{attendance}/iniciar', [AttendanceController::class, 'start'])->name('attendances.start');
        Route::get('/atendimentos/{attendance}/continuar', [AttendanceController::class, 'continue'])->name('attendances.continue');
        Route::put('/atendimentos/{attendance}/continuar', [AttendanceController::class, 'saveContinuation'])->name('attendances.continue.save');
        Route::delete('/atendimentos/{attendance}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
    });

    Route::get('/home', HomeController::class)->name('home');

    /* Protótipo substituído pelo BeneficiaryController.
    Route::get('/beneficiarias', function () {
        $kpis = [
            [
                'label' => 'Beneficiárias ativas',
                'value' => '4',
                'context' => 'Beneficiárias com acompanhamento ativo',
                'trend' => '+2',
                'trendType' => 'up',
                'icon' => 'people-o',
                'tone' => 'rose',
            ],
            [
                'label' => 'Total cadastrado',
                'value' => '6',
                'context' => 'Beneficiárias cadastradas no sistema',
                'trend' => '+12%',
                'trendType' => 'up',
                'icon' => 'check',
                'tone' => 'green',
            ],
            [
                'label' => 'Cadastros inativos',
                'value' => '2',
                'context' => 'Sem acompanhamento ativo',
                'trend' => '-1',
                'trendType' => 'down',
                'icon' => 'report-problem-o',
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
                            'icon' => 'visibility-o',
                            'route' => route('beneficiaries.show', preg_replace('/\D/', '', $beneficiary['cpf'])),
                            'title' => 'Visualizar',
                        ],
                        [
                            'icon' => 'delete-o',
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
            'baby_name' => 'Lucas da Silva',
            'registered_at' => '14/05/2026',
            'address' => 'Rua das Palmeiras, 245 - Centro',
        ];

        $kpis = [
            ['label' => 'Atendimentos realizados', 'value' => '6', 'context' => '', 'trend' => null, 'trendType' => 'up', 'icon' => 'content-paste-o', 'tone' => 'rose'],
            ['label' => 'Último atendimento', 'value' => '07/08/2026', 'context' => '', 'trend' => null, 'trendType' => 'up', 'icon' => 'calendar-month-o', 'tone' => 'blue'],
            ['label' => 'Bomba em uso', 'value' => 'BP-004', 'context' => '', 'trend' => null, 'trendType' => 'down', 'icon' => 'info-o', 'tone' => 'rose'],
            ['label' => 'Distribuições recebidas', 'value' => '4', 'context' => '', 'trend' => null, 'trendType' => 'up', 'icon' => 'inventory-2-o', 'tone' => 'amber'],
        ];

        $attendances = [
            ['date' => '08/08/2026', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial', 'summary' => 'Orientações sobre amamentação e pega correta', 'return' => '20/08/2026', '_actions' => ['visibility-o' => '#']],
            ['date' => '29/07/2026', 'professional' => 'Camila Rocha', 'modality' => 'Presencial', 'summary' => 'Avaliação de ganho de peso do bebê', 'return' => '-', '_actions' => ['visibility-o' => '#']],
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
            ['date' => '07/08/2026', 'type' => 'Atendimento realizado', 'description' => 'Orientações relacionadas à amamentação e pega correta.', 'responsible' => 'Fernanda Souza', 'icon' => 'content-paste-o'],
            ['date' => '01/08/2026', 'type' => 'Distribuição de itens', 'description' => '1 pacote de fralda tamanho P e 1 kit de higiene.', 'responsible' => 'Camila Rocha', 'icon' => 'card-giftcard-o'],
            ['date' => '22/07/2026', 'type' => 'Empréstimo de bomba', 'description' => 'Bomba BP-004 - previsão de devolução em 05/08/2026.', 'responsible' => 'Camila Rocha', 'icon' => 'info-o'],
            ['date' => '12/07/2026', 'type' => 'Distribuição de itens', 'description' => '2 latas de leite em pó.', 'responsible' => 'Fernanda Souza', 'icon' => 'card-giftcard-o'],
            ['date' => '29/06/2026', 'type' => 'Atendimento realizado', 'description' => 'Avaliação de ganho de peso do bebê Lucas.', 'responsible' => 'Camila Rocha', 'icon' => 'content-paste-o'],
            ['date' => '14/05/2026', 'type' => 'Cadastro realizado', 'description' => 'Beneficiária cadastrada no sistema da ONG.', 'responsible' => 'Mariana Fernandes', 'icon' => 'content-paste-o'],
        ];

        $recentInfo = [
            ['title' => 'Último atendimento', 'description' => '08/08/2026 - Orientações sobre amamentação e pega correta', 'meta' => 'Profissional: Fernanda Souza', 'link' => route('beneficiaries.show', ['cpf' => $cpf, 'tab' => 'attendances']), 'button' => 'Ver atendimentos', 'icon' => 'inventory-2-o'],
            ['title' => 'Empréstimo atual', 'description' => 'Bomba BP-004 - retirada em 22/07/2026', 'meta' => 'Devolução atrasada', 'link' => route('beneficiaries.show', ['cpf' => $cpf, 'tab' => 'pumps']), 'button' => 'Ver bombas', 'icon' => 'info-o'],
            ['title' => 'Última distribuição', 'description' => '01/08/2026 - 1 pacote de Fralda tamanho P', 'meta' => 'Responsável: Camila Rocha', 'link' => route('beneficiaries.show', ['cpf' => $cpf, 'tab' => 'donations']), 'button' => 'Ver doações', 'icon' => 'card-giftcard-o'],
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
    */

    /* Protótipo substituído pelo AttendanceController.
    Route::get('/atendimentos', function () {
        $kpis = [
            [
                'label' => 'Atendimentos no mês',
                'value' => '42',
                'context' => 'Registros realizados em agosto',
                'trend' => '+18,4%',
                'trendType' => 'up',
                'icon' => 'content-paste-o',
                'tone' => 'rose',
            ],
            [
                'label' => 'Agendados',
                'value' => '12',
                'context' => 'Atendimentos futuros confirmados',
                'trend' => '+4',
                'trendType' => 'up',
                'icon' => 'calendar-month-o',
                'tone' => 'blue',
            ],
            [
                'label' => 'Em andamento',
                'value' => '5',
                'context' => 'Casos aguardando novo contato',
                'trend' => '+2',
                'trendType' => 'down',
                'icon' => 'schedule-o',
                'tone' => 'amber',
            ],
            [
                'label' => 'Realizados hoje',
                'value' => '3',
                'context' => 'Atendimentos concluídos em 10/08',
                'trend' => null,
                'trendType' => 'up',
                'icon' => 'check',
                'tone' => 'green',
            ],
        ];

        $attendances = [
            ['date' => '10/08/2026', 'time' => '14:30', 'beneficiary' => 'Maria da Silva', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial', 'status' => 'Agendado'],
            ['date' => '10/08/2026', 'time' => '09:15', 'beneficiary' => 'Ana Souza', 'professional' => 'Camila Rocha', 'modality' => 'Remota', 'status' => 'Realizado'],
            ['date' => '09/08/2026', 'time' => '16:00', 'beneficiary' => 'Juliana Martins', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial', 'status' => 'Em andamento'],
            ['date' => '08/08/2026', 'time' => '13:40', 'beneficiary' => 'Patrícia Lima', 'professional' => 'Mariana Fernandes', 'modality' => 'Presencial', 'status' => 'Realizado'],
            ['date' => '07/08/2026', 'time' => '10:20', 'beneficiary' => 'Camila Rocha', 'professional' => 'Camila Rocha', 'modality' => 'Remota', 'status' => 'Cancelado'],
            ['date' => '06/08/2026', 'time' => '15:10', 'beneficiary' => 'Renata Alves', 'professional' => 'Fernanda Souza', 'modality' => 'Presencial', 'status' => 'Realizado'],
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
                            'icon' => 'visibility-o',
                            'route' => route('attendances.show', $index + 1),
                            'title' => 'Visualizar',
                        ],
                        [
                            'icon' => 'delete-o',
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
            'baby_name' => 'Lucas da Silva',
            'professional' => 'Fernanda Souza',
            'registered_by' => 'Mariana Fernandes',
            'location' => 'Domiciliar',
            'return_date' => '20/08/2026',
            'summary' => 'Orientações sobre amamentação e pega correta.',
            'objective' => 'Avaliar a amamentação, orientar manejo de dor e definir necessidade de retorno.',
            'conduct' => 'Foi reforçada a posição confortável da mãe, sinais de pega efetiva e livre demanda. Retorno agendado para acompanhamento do ganho de peso.',
        ];

        $kpis = [
            ['label' => 'Duração prevista', 'value' => '45 min', 'context' => 'Janela reservada na agenda', 'trend' => null, 'trendType' => 'up', 'icon' => 'schedule-o', 'tone' => 'rose'],
            ['label' => 'Retorno previsto', 'value' => '20/08', 'context' => 'Próximo acompanhamento', 'trend' => null, 'trendType' => 'up', 'icon' => 'calendar-month-o', 'tone' => 'blue'],
            ['label' => 'Sessões da beneficiária', 'value' => '6', 'context' => 'Histórico acumulado', 'trend' => '+1', 'trendType' => 'up', 'icon' => 'content-paste-o', 'tone' => 'green'],
            ['label' => 'Prioridade', 'value' => 'Média', 'context' => 'Sem alerta crítico no momento', 'trend' => null, 'trendType' => 'down', 'icon' => 'report-problem-o', 'tone' => 'amber'],
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
            ['date' => '10/08/2026', 'type' => 'Atendimento agendado', 'description' => 'Atendimento registrado na agenda da equipe.', 'responsible' => 'Mariana Fernandes', 'icon' => 'calendar-month-o'],
            ['date' => '09/08/2026', 'type' => 'Contato confirmado', 'description' => 'Beneficiária confirmou presença por telefone.', 'responsible' => 'Camila Rocha', 'icon' => 'phone'],
            ['date' => '08/08/2026', 'type' => 'Triagem atualizada', 'description' => 'Caso marcado para orientação de amamentação.', 'responsible' => 'Fernanda Souza', 'icon' => 'content-paste-o'],
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
    */

    Route::get('/bombas-de-leite/emprestimos/novo', [PumpLoanController::class, 'create'])->name('pumps.loans.create');
    Route::post('/bombas-de-leite/emprestimos', [PumpLoanController::class, 'store'])->name('pumps.loans.store');

    Route::get('/bombas-de-leite', [PumpController::class, 'index'])->name('pumps.index');
    Route::get('/bombas-de-leite/nova', [PumpController::class, 'create'])->name('pumps.create');
    Route::post('/bombas-de-leite', [PumpController::class, 'store'])->name('pumps.store');
    Route::get('/bombas-de-leite/{pump}', [PumpController::class, 'show'])->name('pumps.show');
    Route::get('/bombas-de-leite/{pump}/editar', [PumpController::class, 'edit'])->name('pumps.edit');
    Route::put('/bombas-de-leite/{pump}', [PumpController::class, 'update'])->name('pumps.update');
    Route::patch('/bombas-de-leite/{pump}/renovar-emprestimo', [PumpController::class, 'renewLoan'])->name('pumps.loans.renew');
    Route::delete('/bombas-de-leite/{pump}', [PumpController::class, 'destroy'])->name('pumps.destroy');

    Route::get('/doacoes-e-estoque', function () {
        $kpis = [
            [
                'label' => 'Itens em estoque',
                'value' => '221',
                'context' => 'Unidades disponíveis para distribuição',
                'trend' => '+34',
                'trendType' => 'up',
                'icon' => 'inventory-2-o',
                'tone' => 'rose',
            ],
            [
                'label' => 'Doações no mês',
                'value' => '18',
                'context' => 'Entradas registradas em agosto',
                'trend' => '+6',
                'trendType' => 'up',
                'icon' => 'card-giftcard-o',
                'tone' => 'green',
            ],
            [
                'label' => 'Distribuições',
                'value' => '27',
                'context' => 'Entregas realizadas no mês',
                'trend' => '+12%',
                'trendType' => 'up',
                'icon' => 'volunteer-activism-o',
                'tone' => 'blue',
            ],
            [
                'label' => 'Itens críticos',
                'value' => '4',
                'context' => 'Abaixo do estoque mínimo',
                'trend' => '+1',
                'trendType' => 'down',
                'icon' => 'report-problem-o',
                'tone' => 'amber',
            ],
        ];

        $materials = [
            ['id' => 'fralda-p', 'description' => 'Fralda tamanho P', 'category' => 'Fraldas', 'quantity' => '42 pacotes', 'status' => 'Normal', 'last_movement' => 'Entrada em 10/08/2026'],
            ['id' => 'fralda-m', 'description' => 'Fralda tamanho M', 'category' => 'Fraldas', 'quantity' => '18 pacotes', 'status' => 'Baixo', 'last_movement' => 'Distribuição em 08/08/2026'],
            ['id' => 'leite-em-po', 'description' => 'Leite em pó', 'category' => 'Alimentação', 'quantity' => '32 latas', 'status' => 'Crítico', 'last_movement' => 'Entrada em 09/08/2026'],
            ['id' => 'kit-higiene', 'description' => 'Kit higiene bebê', 'category' => 'Higiene', 'quantity' => '21 kits', 'status' => 'Baixo', 'last_movement' => 'Distribuição em 10/08/2026'],
            ['id' => 'lenco-umedecido', 'description' => 'Lenço umedecido', 'category' => 'Higiene', 'quantity' => '20 pacotes', 'status' => 'Normal', 'last_movement' => 'Ajuste em 05/08/2026'],
            ['id' => 'roupas-rn', 'description' => 'Roupas RN', 'category' => 'Roupas', 'quantity' => '46 peças', 'status' => 'Normal', 'last_movement' => 'Entrada em 07/08/2026'],
            ['id' => 'pomada-assaduras', 'description' => 'Pomada para assaduras', 'category' => 'Higiene', 'quantity' => '8 unidades', 'status' => 'Crítico', 'last_movement' => 'Distribuição em 04/08/2026'],
            ['id' => 'manta-infantil', 'description' => 'Manta infantil', 'category' => 'Roupas', 'quantity' => '12 unidades', 'status' => 'Normal', 'last_movement' => 'Entrada em 02/08/2026'],
        ];

        $stock = [
            ['label' => 'Fraldas', 'available' => 78, 'used' => 52, 'minimum' => 50],
            ['label' => 'Higiene', 'available' => 41, 'used' => 39, 'minimum' => 45],
            ['label' => 'Alimentação', 'available' => 32, 'used' => 68, 'minimum' => 40],
            ['label' => 'Roupas', 'available' => 70, 'used' => 28, 'minimum' => 25],
        ];

        $alerts = [
            ['title' => 'Leite em pó abaixo do mínimo', 'description' => '32 unidades disponíveis para mínimo operacional de 40.', 'tone' => 'red'],
            ['title' => 'Kits de higiene exigem reposição', 'description' => 'Categoria higiene está com 41 unidades disponíveis.', 'tone' => 'amber'],
            ['title' => 'Fraldas tamanho P regularizadas', 'description' => 'Entrada de 24 pacotes registrada hoje.', 'tone' => 'blue'],
        ];

        $recent = [
            ['time' => '15:10', 'title' => 'Entrada de 24 pacotes de fralda P.', 'meta' => 'Doação registrada por Mariana Fernandes'],
            ['time' => '11:45', 'title' => '3 kits de higiene distribuídos.', 'meta' => 'Entrega registrada por Camila Rocha'],
            ['time' => '09:20', 'title' => 'Alerta de estoque crítico atualizado.', 'meta' => 'Leite em pó abaixo do mínimo'],
        ];

        $search = trim((string) request('q', ''));
        $status = request('status', 'all');
        $category = request('category', 'all');

        $filteredMaterials = collect($materials)
            ->when($status !== 'all', fn ($items) => $items->where('status', $status))
            ->when($category !== 'all', fn ($items) => $items->where('category', $category))
            ->when($search !== '', function ($items) use ($search) {
                $lowerSearch = mb_strtolower($search);

                return $items->filter(function ($material) use ($lowerSearch) {
                    return str_contains(mb_strtolower($material['description']), $lowerSearch)
                        || str_contains(mb_strtolower($material['category']), $lowerSearch);
                });
            })
            ->map(function ($material) {
                $materialId = $material['id'];
                unset($material['id']);

                $material['_actions'] = [
                    'view' => route('donations.show', $materialId),
                    'items' => [
                        [
                            'icon' => 'visibility-o',
                            'route' => route('donations.show', $materialId),
                            'title' => 'Visualizar',
                        ],
                        [
                            'icon' => 'volunteer-activism-o',
                            'route' => '#',
                            'title' => 'Distribuir',
                        ],
                        [
                            'icon' => 'delete-o',
                            'route' => '#',
                            'title' => 'Excluir',
                            'variant' => 'danger',
                        ],
                    ],
                ];

                return $material;
            })
            ->values()
            ->all();

        $totalStock = array_sum(array_column($stock, 'available')) + array_sum(array_column($stock, 'used'));
        $categories = collect($materials)->pluck('category')->unique()->values()->all();

        return view('pages.donations.index', [
            'materials' => $filteredMaterials,
            'kpis' => $kpis,
            'stock' => $stock,
            'totalStock' => $totalStock,
            'alerts' => $alerts,
            'recent' => $recent,
            'search' => $search,
            'status' => $status,
            'category' => $category,
            'categories' => $categories,
        ]);
    })->name('donations.index');

    Route::get('/doacoes-e-estoque/{item}', function (string $item) {
        $items = [
            'fralda-p' => ['description' => 'Fralda tamanho P', 'category' => 'Fraldas', 'quantity' => '42 pacotes', 'status' => 'Normal', 'minimum' => '30 pacotes', 'monthly_demand' => '36 pacotes', 'last_movement' => 'Entrada em 10/08/2026', 'unit' => 'pacotes'],
            'fralda-m' => ['description' => 'Fralda tamanho M', 'category' => 'Fraldas', 'quantity' => '18 pacotes', 'status' => 'Baixo', 'minimum' => '28 pacotes', 'monthly_demand' => '34 pacotes', 'last_movement' => 'Distribuição em 08/08/2026', 'unit' => 'pacotes'],
            'leite-em-po' => ['description' => 'Leite em pó', 'category' => 'Alimentação', 'quantity' => '32 latas', 'status' => 'Crítico', 'minimum' => '40 latas', 'monthly_demand' => '52 latas', 'last_movement' => 'Entrada em 09/08/2026', 'unit' => 'latas'],
            'kit-higiene' => ['description' => 'Kit higiene bebê', 'category' => 'Higiene', 'quantity' => '21 kits', 'status' => 'Baixo', 'minimum' => '25 kits', 'monthly_demand' => '30 kits', 'last_movement' => 'Distribuição em 10/08/2026', 'unit' => 'kits'],
            'lenco-umedecido' => ['description' => 'Lenço umedecido', 'category' => 'Higiene', 'quantity' => '20 pacotes', 'status' => 'Normal', 'minimum' => '20 pacotes', 'monthly_demand' => '28 pacotes', 'last_movement' => 'Ajuste em 05/08/2026', 'unit' => 'pacotes'],
            'roupas-rn' => ['description' => 'Roupas RN', 'category' => 'Roupas', 'quantity' => '46 peças', 'status' => 'Normal', 'minimum' => '20 peças', 'monthly_demand' => '24 peças', 'last_movement' => 'Entrada em 07/08/2026', 'unit' => 'peças'],
            'pomada-assaduras' => ['description' => 'Pomada para assaduras', 'category' => 'Higiene', 'quantity' => '8 unidades', 'status' => 'Crítico', 'minimum' => '18 unidades', 'monthly_demand' => '22 unidades', 'last_movement' => 'Distribuição em 04/08/2026', 'unit' => 'unidades'],
            'manta-infantil' => ['description' => 'Manta infantil', 'category' => 'Roupas', 'quantity' => '12 unidades', 'status' => 'Normal', 'minimum' => '10 unidades', 'monthly_demand' => '8 unidades', 'last_movement' => 'Entrada em 02/08/2026', 'unit' => 'unidades'],
        ];

        $stockItem = $items[$item] ?? $items['leite-em-po'];

        $kpis = [
            ['label' => 'Quantidade atual', 'value' => $stockItem['quantity'], 'context' => 'Disponível para distribuição', 'trend' => null, 'trendType' => 'up', 'icon' => 'inventory-2-o', 'tone' => 'rose'],
            ['label' => 'Estoque mínimo', 'value' => $stockItem['minimum'], 'context' => 'Limite operacional recomendado', 'trend' => null, 'trendType' => 'down', 'icon' => 'report-problem-o', 'tone' => $stockItem['status'] === 'Crítico' ? 'amber' : 'blue'],
            ['label' => 'Demanda mensal', 'value' => $stockItem['monthly_demand'], 'context' => 'Média esperada para distribuição', 'trend' => '+8%', 'trendType' => 'up', 'icon' => 'volunteer-activism-o', 'tone' => 'green'],
            ['label' => 'Situação', 'value' => $stockItem['status'], 'context' => $stockItem['last_movement'], 'trend' => null, 'trendType' => 'up', 'icon' => 'check', 'tone' => $stockItem['status'] === 'Crítico' ? 'amber' : 'blue'],
        ];

        $movements = [
            ['date' => '10/08/2026 15:10', 'type' => 'Entrada', 'quantity' => '24 '.$stockItem['unit'], 'origin' => 'Doação espontânea', 'responsible' => 'Mariana Fernandes', 'status' => 'Entrada'],
            ['date' => '08/08/2026 11:45', 'type' => 'Saída', 'quantity' => '5 '.$stockItem['unit'], 'origin' => 'Distribuição para beneficiária', 'responsible' => 'Camila Rocha', 'status' => 'Distribuído'],
            ['date' => '05/08/2026 09:20', 'type' => 'Ajuste', 'quantity' => '-2 '.$stockItem['unit'], 'origin' => 'Conferência de estoque', 'responsible' => 'Luzilene Zimmerman', 'status' => 'Saída'],
        ];

        $distributions = [
            ['date' => '10/08/2026', 'beneficiary' => 'Maria da Silva', 'quantity' => '2 '.$stockItem['unit'], 'responsible' => 'Camila Rocha', 'status' => 'Distribuído'],
            ['date' => '08/08/2026', 'beneficiary' => 'Ana Souza', 'quantity' => '1 '.$stockItem['unit'], 'responsible' => 'Mariana Fernandes', 'status' => 'Distribuído'],
            ['date' => '04/08/2026', 'beneficiary' => 'Juliana Martins', 'quantity' => '2 '.$stockItem['unit'], 'responsible' => 'Fernanda Souza', 'status' => 'Distribuído'],
        ];

        $history = [
            ['date' => '10/08/2026', 'type' => 'Entrada registrada', 'description' => 'Nova entrada adicionada ao estoque.', 'responsible' => 'Mariana Fernandes', 'icon' => 'card-giftcard-o'],
            ['date' => '08/08/2026', 'type' => 'Distribuição registrada', 'description' => 'Material entregue para beneficiária acompanhada.', 'responsible' => 'Camila Rocha', 'icon' => 'volunteer-activism-o'],
            ['date' => '05/08/2026', 'type' => 'Conferência de estoque', 'description' => 'Saldo ajustado após contagem física.', 'responsible' => 'Luzilene Zimmerman', 'icon' => 'check'],
        ];

        $tab = request('tab', 'overview');

        return view('pages.donations.show', compact(
            'item',
            'stockItem',
            'kpis',
            'movements',
            'distributions',
            'history',
            'tab'
        ));
    })->name('donations.show');

    Route::get('/relatorios', function () {
        $startDate = request('start_date', now()->startOfMonth()->toDateString());
        $endDate = request('end_date', now()->endOfMonth()->toDateString());
        $section = request('section', 'all');
        $location = request('location', 'all');

        $summaryKpis = [
            ['label' => 'Atendimentos realizados', 'value' => '42', 'context' => 'No período selecionado', 'trend' => '+18,4%', 'trendType' => 'up', 'icon' => 'content-paste-o', 'tone' => 'rose'],
            ['label' => 'Bombas em uso', 'value' => '10', 'context' => '8 empréstimos e 2 aluguéis', 'trend' => '+3', 'trendType' => 'up', 'icon' => 'milk', 'tone' => 'blue'],
            ['label' => 'Distribuições registradas', 'value' => '27', 'context' => 'Materiais entregues às beneficiárias', 'trend' => '+12%', 'trendType' => 'up', 'icon' => 'volunteer-activism-o', 'tone' => 'green'],
            ['label' => 'Alertas críticos', 'value' => '7', 'context' => 'Estoque, devoluções e pendências operacionais', 'trend' => '+2', 'trendType' => 'down', 'icon' => 'report-problem-o', 'tone' => 'amber'],
        ];

        $attendanceChart = [
            'percent' => '82%',
            'values' => [
                ['month' => 'Abr', 'total' => 50, 'target' => 38],
                ['month' => 'Mai', 'total' => 37, 'target' => 42],
                ['month' => 'Jun', 'total' => 34, 'target' => 45],
                ['month' => 'Jul', 'total' => 46, 'target' => 50],
                ['month' => 'Ago', 'total' => 42, 'target' => 55],
            ],
        ];

        $attendancePipeline = [
            ['label' => 'Triagem', 'value' => 23, 'percent' => 100],
            ['label' => 'Agendado', 'value' => 12, 'percent' => 52],
            ['label' => 'Realizado', 'value' => 42, 'percent' => 82],
            ['label' => 'Em andamento', 'value' => 5, 'percent' => 22],
        ];

        $pumpMetrics = [
            ['label' => 'Disponíveis', 'value' => 8, 'percent' => 40],
            ['label' => 'Empréstimos ativos', 'value' => 8, 'percent' => 40],
            ['label' => 'Aluguéis ativos', 'value' => 2, 'percent' => 10],
            ['label' => 'Manutenção', 'value' => 2, 'percent' => 10],
        ];

        $pumpContracts = [
            ['type' => 'Empréstimo', 'active' => '8', 'overdue' => '3', 'renewals' => '4', 'revenue' => 'Sem cobrança', 'status' => 'Pendente'],
            ['type' => 'Aluguel', 'active' => '2', 'overdue' => '0', 'renewals' => '2', 'revenue' => 'R$ 220,00', 'status' => 'Normal'],
        ];

        $stock = [
            ['label' => 'Fraldas', 'available' => 78, 'used' => 52, 'minimum' => 50],
            ['label' => 'Higiene', 'available' => 41, 'used' => 39, 'minimum' => 45],
            ['label' => 'Alimentação', 'available' => 32, 'used' => 68, 'minimum' => 40],
            ['label' => 'Roupas', 'available' => 70, 'used' => 28, 'minimum' => 25],
        ];

        $stockRisks = [
            ['title' => 'Leite em pó em nível crítico', 'description' => '32 latas disponíveis para demanda mensal de 52.', 'tone' => 'red'],
            ['title' => 'Kits de higiene abaixo do mínimo', 'description' => 'Reposição recomendada para manter o atendimento da semana.', 'tone' => 'amber'],
            ['title' => 'Fraldas P regularizadas', 'description' => 'Entrada recente elevou o saldo acima do mínimo.', 'tone' => 'blue'],
        ];

        $stockMovements = [
            ['category' => 'Fraldas', 'available' => '78', 'distributed' => '52', 'minimum' => '50', 'status' => 'Normal'],
            ['category' => 'Higiene', 'available' => '41', 'distributed' => '39', 'minimum' => '45', 'status' => 'Baixo'],
            ['category' => 'Alimentação', 'available' => '32', 'distributed' => '68', 'minimum' => '40', 'status' => 'Crítico'],
            ['category' => 'Roupas', 'available' => '70', 'distributed' => '28', 'minimum' => '25', 'status' => 'Normal'],
        ];

        $totalStock = array_sum(array_column($stock, 'available')) + array_sum(array_column($stock, 'used'));

        return view('pages.reports.index', compact(
            'startDate',
            'endDate',
            'section',
            'location',
            'summaryKpis',
            'attendanceChart',
            'attendancePipeline',
            'pumpMetrics',
            'pumpContracts',
            'stock',
            'totalStock',
            'stockRisks',
            'stockMovements'
        ));
    })->name('reports.index');
});
