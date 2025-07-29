<?php

use App\Http\Controllers\ClaimVoucherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MVoucherTypeController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\SendVoucherController;
use App\Http\Controllers\TransactionVoucherReceiptController;
use App\Http\Controllers\TransactionVoucherUsageController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::post('/claim-voucher', [ClaimVoucherController::class, 'store'])
    ->name('claim-voucher.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');

    Route::resources([
        'm-voucher-type' => MVoucherTypeController::class,
        'outlet' => OutletController::class,
        'voucher' => VoucherController::class,
        'recipient' => RecipientController::class,
        'send-voucher' => SendVoucherController::class,
        'voucher-receipt' => TransactionVoucherReceiptController::class,
        'voucher-usage' => TransactionVoucherUsageController::class,
    ]);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
