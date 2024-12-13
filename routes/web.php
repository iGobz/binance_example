<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TickersController;
use App\Http\Controllers\UserTickersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments');
    Route::post('/payments', [PaymentsController::class, 'store'])->name('payments.store');

    Route::get('/tickers', [TickersController::class, 'show' ])->name('tickers');
    Route::post('/ticker', [UserTickersController::class, 'toggle'])->name('ticker.toggle');
    Route::delete('/ticker', [UserTickersController::class, 'destroy'])->name('ticker.destroy');
});

require __DIR__.'/auth.php';
