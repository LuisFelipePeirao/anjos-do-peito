<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ícones principais</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#f5f6f8] font-sans text-[#111827]">
    @php
        $groups = [
            [
                'title' => 'Destaques do sistema',
                'description' => 'Áreas e informações mais presentes na operação.',
                'featured' => true,
                'icons' => [
                    ['component' => 'gmdi-content-paste-o', 'label' => 'Atendimentos', 'tone' => 'rose'],
                    ['component' => 'gmdi-report-problem-o', 'label' => 'Alertas', 'tone' => 'amber'],
                    ['component' => 'gmdi-volunteer-activism-o', 'label' => 'Doações', 'tone' => 'green'],
                    ['component' => 'gmdi-inventory-2-o', 'label' => 'Estoque', 'tone' => 'blue'],
                    ['component' => 'gmdi-calendar-month-o', 'label' => 'Agenda', 'tone' => 'blue'],
                    ['component' => 'gmdi-people-o', 'label' => 'Beneficiárias', 'tone' => 'rose'],
                ],
            ],
            [
                'title' => 'Navegação',
                'description' => 'Acesso às áreas principais e movimentação entre telas.',
                'icons' => [
                    ['component' => 'gmdi-dashboard-o', 'label' => 'Início'],
                    ['component' => 'lucide-milk', 'label' => 'Bombas de leite'],
                    ['component' => 'gmdi-bar-chart-o', 'label' => 'Relatórios'],
                    ['component' => 'gmdi-account-circle-o', 'label' => 'Usuários'],
                    ['component' => 'gmdi-arrow-left', 'label' => 'Voltar'],
                    ['component' => 'gmdi-logout-o', 'label' => 'Sair'],
                ],
            ],
            [
                'title' => 'Ações',
                'description' => 'Comandos recorrentes em tabelas, filtros e formulários.',
                'icons' => [
                    ['component' => 'gmdi-add', 'label' => 'Adicionar'],
                    ['component' => 'gmdi-search-o', 'label' => 'Pesquisar'],
                    ['component' => 'gmdi-filter-alt-o', 'label' => 'Filtrar'],
                    ['component' => 'gmdi-visibility-o', 'label' => 'Visualizar'],
                    ['component' => 'gmdi-edit-o', 'label' => 'Editar'],
                    ['component' => 'gmdi-delete-o', 'label' => 'Excluir', 'danger' => true],
                ],
            ],
            [
                'title' => 'Estados e indicadores',
                'description' => 'Retornos visuais, prazos e tendências do sistema.',
                'icons' => [
                    ['component' => 'gmdi-check', 'label' => 'Concluído'],
                    ['component' => 'gmdi-info-o', 'label' => 'Informação'],
                    ['component' => 'gmdi-warning-amber-o', 'label' => 'Atenção'],
                    ['component' => 'gmdi-schedule-o', 'label' => 'Pendente'],
                    ['component' => 'gmdi-trending-up-o', 'label' => 'Crescimento'],
                    ['component' => 'gmdi-trending-down-o', 'label' => 'Queda'],
                ],
            ],
        ];

        $tones = [
            'rose' => 'bg-[#fdecef] text-[#bf5d6f]',
            'amber' => 'bg-[#fff3d6] text-[#b77910]',
            'green' => 'bg-[#e8f8ee] text-[#23845a]',
            'blue' => 'bg-[#e8f4ff] text-[#2677b8]',
        ];
    @endphp

    <main class="mx-auto w-full max-w-6xl px-6 py-8">
        <header class="mb-6 flex items-end justify-between border-b border-[#dfe3e8] pb-5">
            <div>
                <p class="text-xs font-semibold uppercase text-[#bf5d6f]">Anjos do Peito</p>
                <h1 class="mt-1 text-3xl font-bold text-[#111827]">Ícones principais</h1>
                <p class="mt-1 text-sm text-[#667085]">Seleção dos símbolos mais utilizados e reconhecíveis do sistema.</p>
            </div>
            <span class="text-sm font-semibold text-[#667085]">24 ícones</span>
        </header>

        <div class="overflow-hidden rounded-lg border border-[#dfe3e8] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.06)]">
            @foreach ($groups as $group)
                <section @class(['border-t border-[#e8eaed] first:border-t-0'])>
                    <div class="flex items-baseline justify-between gap-5 border-b border-[#e8eaed] bg-[#fbfaf9] px-5 py-3">
                        <h2 class="text-sm font-bold text-[#111827]">{{ $group['title'] }}</h2>
                        <p class="text-xs text-[#667085]">{{ $group['description'] }}</p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6">
                        @foreach ($group['icons'] as $icon)
                            @php
                                $featured = $group['featured'] ?? false;
                                $iconTone = $tones[$icon['tone'] ?? ''] ?? 'bg-[#f2f4f7] text-[#475467]';
                                $iconTone = ($icon['danger'] ?? false) ? 'bg-[#fff1f1] text-[#c2414b]' : $iconTone;
                            @endphp

                            <div class="flex min-h-28 flex-col items-center justify-center gap-2.5 border-b border-r border-[#e8eaed] p-4 text-center lg:border-b-0">
                                <span @class([
                                    'inline-flex items-center justify-center rounded-lg',
                                    $featured ? 'h-13 w-13' : 'h-11 w-11',
                                    $iconTone,
                                ])>
                                    <x-dynamic-component
                                        :component="$icon['component']"
                                        @class([$featured ? 'h-7 w-7' : 'h-6 w-6'])
                                    />
                                </span>
                                <span class="text-xs font-semibold text-[#344054]">{{ $icon['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </main>
</body>
</html>
