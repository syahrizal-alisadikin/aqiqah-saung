<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/forbodden', [HomeController::class, 'error'])->name('forbodden');

route::prefix('dashboard')
    ->middleware('auth')
    ->group(function () {
        Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('keuangan', KeuanganController::class,['except' => ['show']]);
        Route::resource('orders', OrderController::class,['except' => ['show']]);
        Route::resource('profile', ProfileController::class,['except' => ['show']]);
        Route::get('/keuangan/pengeluaran', [KeuanganController::class, 'pengeluaran'])->name('pengeluaran.index');
        Route::get('/forbodden', [HomeController::class, 'error'])->name('forbodden');
    });
