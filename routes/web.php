<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('bk')->name('bk.')->group(function () {
        Route::get('/', [\App\Http\Controllers\BkController::class, 'index'])->name('index');
        Route::get('/show/{id}', [\App\Http\Controllers\BkController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\BkController::class, 'edit'])->name('edit');
        Route::put('/store/{id}', [\App\Http\Controllers\BkController::class, 'store'])->name('store');
    });

    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PaymentController::class, 'index'])->name('index');
        Route::get('/show/{id}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\PaymentController::class, 'edit'])->name('edit');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
    });
});
