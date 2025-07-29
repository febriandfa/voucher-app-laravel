<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MVoucherTypeController;
use App\Http\Controllers\OutletController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');

    Route::resources([
        'm-voucher-type' => MVoucherTypeController::class,
        'outlet' => OutletController::class,
    ]);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
