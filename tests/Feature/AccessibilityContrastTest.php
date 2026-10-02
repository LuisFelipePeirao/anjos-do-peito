<?php

function contrastRatio(string $foreground, string $background): float
{
    $toLuminance = function (string $color): float {
        $channels = array_map(
            fn (string $channel): float => hexdec($channel) / 255,
            str_split(ltrim($color, '#'), 2),
        );

        $linearChannels = array_map(
            fn (float $channel): float => $channel <= 0.04045
                ? $channel / 12.92
                : (($channel + 0.055) / 1.055) ** 2.4,
            $channels,
        );

        return (0.2126 * $linearChannels[0])
            + (0.7152 * $linearChannels[1])
            + (0.0722 * $linearChannels[2]);
    };

    $luminances = [$toLuminance($foreground), $toLuminance($background)];

    return (max($luminances) + 0.05) / (min($luminances) + 0.05);
}

it('uses AA text contrast for home actions, sidebar identity, and status badges', function () {
    $pairs = [
        'primary action' => ['#ffffff', '#c73570'],
        'sidebar identity' => ['#a62d5b', '#fdecef'],
        'positive trend' => ['#197a4b', '#e8f8ee'],
        'negative trend' => ['#b42336', '#fdecec'],
        'empty stock' => ['#b42336', '#fdecec'],
    ];

    foreach ($pairs as $name => [$foreground, $background]) {
        expect(contrastRatio($foreground, $background))
            ->toBeGreaterThanOrEqual(4.5, "{$name} must meet WCAG AA for normal text");
    }

    $dashboardCard = view('components.cards.dashboard-card', [
        'label' => 'Atendimentos',
        'value' => 12,
        'tone' => 'rose',
        'context' => 'Hoje',
        'icon' => 'dashboard-o',
        'arrow' => 'down',
        'percent' => '+1',
    ])->render();

    expect($dashboardCard)
        ->toContain('text-[#a62d5b]')
        ->toContain('text-[#b42336]');

    $pageInfo = view('components.app.page-info', [
        'title' => 'Visão geral',
        'description' => 'Resumo',
        'firstButton' => ['label' => 'Novo atendimento', 'link' => '#', 'icon' => 'add'],
    ])->render();

    $stockDistribution = view('components.chart.stock-distribution', [
        'title' => 'Estoque',
        'description' => 'Resumo',
        'data' => [['label' => 'Fraldas', 'available' => 0, 'used' => 1, 'minimum' => 1]],
    ])->render();

    $datatable = view('components.tables.datatable', [
        'header' => ['Item', 'Situação'],
        'data' => [['name' => 'Manutenção', 'status' => 'Em andamento']],
        'showActions' => false,
    ])->render();

    expect($pageInfo)
        ->toContain('bg-[#c73570]');

    expect($stockDistribution)
        ->toContain('text-[#b42336]');

    expect($datatable)
        ->toContain('bg-[#e8f8ee] text-[#197a4b]');
});

it('uses the accessible primary color for every primary action', function () {
    $viewFiles = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(resource_path('views')),
    );

    foreach ($viewFiles as $viewFile) {
        if (! $viewFile->isFile() || $viewFile->getExtension() !== 'php') {
            continue;
        }

        $contents = file_get_contents($viewFile->getPathname());

        expect(preg_match('/<(?:a|button|input)\\b[^>]*bg-\\[#ef5b97\\][^>]*text-white/s', $contents))
            ->toBe(0, "{$viewFile->getPathname()} must not use the low-contrast primary action color");
    }
});

it('uses an AA amber badge for pending report items', function () {
    $html = view('pages.reports.index', [
        'startDate' => '2026-10-01',
        'endDate' => '2026-10-31',
        'section' => 'all',
        'location' => 'all',
        'locationOptions' => [],
        'reportKpis' => [],
        'pumpOverview' => [],
        'pumpContractChart' => [],
        'pumpDueDates' => [[
            'status' => 'Pendente',
            'pump' => 'BL-001',
            'type' => 'Empréstimo',
            'beneficiary' => 'Maria',
            'expires_at' => '10/10/2026',
            'renewal_at' => '05/10/2026',
        ]],
        'attendanceModalityChart' => [],
        'professionalChart' => [],
        'stockCoverageChart' => [],
        'donationSources' => [],
    ])->render();

    expect($html)->toContain('bg-[#fff7e6] text-[#8a4b00]');
});

it('does not use the low-contrast rose color in views', function () {
    $viewFiles = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(resource_path('views')),
    );

    foreach ($viewFiles as $viewFile) {
        if ($viewFile->isFile() && $viewFile->getExtension() === 'php') {
            expect(file_get_contents($viewFile->getPathname()))
                ->not->toContain('#bf5d6f');
        }
    }
});

it('uses only the accessible status text palette in views', function () {
    $legacyStatusColors = ['#23845a', '#b76b00', '#b77910', '#c2414b', '#2677b8', '#2f66d0'];
    $viewFiles = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(resource_path('views')),
    );

    foreach ($viewFiles as $viewFile) {
        if (! $viewFile->isFile() || $viewFile->getExtension() !== 'php') {
            continue;
        }

        $contents = file_get_contents($viewFile->getPathname());

        foreach ($legacyStatusColors as $color) {
            expect($contents)->not->toContain("text-[{$color}]");
        }
    }
});
