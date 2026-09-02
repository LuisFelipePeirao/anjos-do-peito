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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockMovementController;
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

    Route::get('/movimentacoes', [StockMovementController::class, 'index'])->name('movements.index');
    Route::get('/movimentacoes/nova', [StockMovementController::class, 'create'])->name('movements.create');
    Route::post('/movimentacoes', [StockMovementController::class, 'store'])->name('movements.store');
    Route::get('/movimentacoes/{movement}', [StockMovementController::class, 'show'])->name('movements.show');

    Route::get('/relatorios', [ReportController::class, 'index'])->name('reports.index');
});
