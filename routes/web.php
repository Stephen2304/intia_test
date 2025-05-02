<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InsurancePolicyController;
use App\Http\Controllers\InsuranceTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/insurance-policies', [InsurancePolicyController::class, 'index'])->name('insurance_policies.index');
    Route::get('/insurance-types', [InsuranceTypeController::class, 'index'])->name('insurance_types.index');

    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::post('/insurance-policies', [InsurancePolicyController::class, 'store'])->name('insurance_policies.store');
    Route::post('/insurance-types', [InsuranceTypeController::class, 'store'])->name('insurance_types.store');

    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::put('/insurance-policies/{insurance_policy}', [InsurancePolicyController::class, 'update'])->name('insurance_policies.update');
    Route::put('/insurance-types/{insurance_type}', [InsuranceTypeController::class, 'update'])->name('insurance_types.update');

    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::delete('/insurance-policies/{insurance_policy}', [InsurancePolicyController::class, 'destroy'])->name('insurance_policies.destroy');
    Route::delete('/insurance-types/{insurance_type}', [InsuranceTypeController::class, 'destroy'])->name('insurance_types.destroy');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes protégées pour les branches (admin uniquement)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
    Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
    Route::put('/branches/{branch}', [BranchController::class, 'update'])->name('branches.update');
    Route::delete('/branches/{branch}', [BranchController::class, 'destroy'])->name('branches.destroy');
});

// Autres routes


require __DIR__.'/auth.php';
