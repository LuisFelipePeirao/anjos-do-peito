<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DonationStockController;
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

    Route::get('/doacoes-e-estoque', [DonationStockController::class, 'index'])->name('donations.index');
    Route::get('/doacoes-e-estoque/material/novo', [DonationStockController::class, 'createMaterial'])->name('donations.materials.create');
    Route::post('/doacoes-e-estoque/material', [DonationStockController::class, 'storeMaterial'])->name('donations.materials.store');
    Route::get('/doacoes-e-estoque/doadores/novo', [DonationStockController::class, 'createDonor'])->name('donations.donors.create');
    Route::post('/doacoes-e-estoque/doadores', [DonationStockController::class, 'storeDonor'])->name('donations.donors.store');
    Route::get('/doacoes-e-estoque/doacoes/nova', [DonationStockController::class, 'createDonation'])->name('donations.create');
    Route::post('/doacoes-e-estoque/doacoes', [DonationStockController::class, 'storeDonation'])->name('donations.store');
    Route::get('/doacoes-e-estoque/distribuicoes/nova', [DonationStockController::class, 'createDistribution'])->name('donations.distributions.create');
    Route::post('/doacoes-e-estoque/distribuicoes', [DonationStockController::class, 'storeDistribution'])->name('donations.distributions.store');
    Route::get('/doacoes-e-estoque/{material}', [DonationStockController::class, 'show'])->name('donations.show');
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
