<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

/**
 * AUTH
 */
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
});


/**
 * USER
 */
Route::middleware([AuthMiddleware::class])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::get('/{id}', [UserController::class, 'show'])->name('userDetail');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('deleteUser');
});

/**
 * WALLET
 */
Route::middleware([AuthMiddleware::class])->prefix('wallets')->group(function () {
    Route::post('/transfer', [WalletController::class, 'transfer'])->name('transferFunds');
});


/**
 * TRANSACTIONS
 */
Route::middleware([AuthMiddleware::class])->prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/{id}', [TransactionController::class, 'show'])->name('transactionDetails');
    Route::patch('/{id}', [TransactionController::class, 'update'])->name('updateTransaction');
    Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('deleteTransaction');
});
