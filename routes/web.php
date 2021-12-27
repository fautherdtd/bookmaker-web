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

    Route::prefix('bk')->group(function () {
        Route::get('/', [\App\Http\Controllers\BkController::class, 'index'])->name('bk');
        Route::get('/show/{id}', [\App\Http\Controllers\BkController::class, 'show'])->name('show');
    });

    Route::prefix('payments')->group(function () {
        Route::get('/', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payments');
    });
});
