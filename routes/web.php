<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GoogleController;
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
Route::post('auth/ontap', [GoogleController::class, 'onTapGoogle'])->name('google.ontap');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
route::prefix('dashboard')
    ->middleware('auth')
    ->group(function () {
        Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('keuangan', KeuanganController::class, ['except' => ['show']]);
        Route::resource('orders', OrderController::class, ['except' => ['show']]);
        Route::get('orders/pdf/{id}', [OrderController::class, 'pdf'])->name('orders.pdf');
        Route::post('orders/excel/', [OrderController::class, 'OrderExcel'])->name('orders-excel');
        Route::post('orders/pdf/', [OrderController::class, 'OrderPdf'])->name('orders-pdf');
        Route::resource('products', ProductController::class)->middleware('admin');
        Route::resource('invoice', InvoiceController::class)->middleware('admin');
        Route::get('products-stock/{id}', [ProductController::class, 'stock'])->name('product-stock')->middleware('admin');
        Route::post('stock-product', [ProductController::class, 'StockProduct'])->name('stock.store')->middleware('admin');
        Route::post('products-rekanan/{id}', [ProductController::class, 'harga'])->name('harga-rekanan')->middleware('admin');
        Route::resource('users', UserController::class)->middleware('admin');
        Route::resource('profile', ProfileController::class, ['except' => ['show']]);
        Route::get('/keuangan/pengeluaran', [KeuanganController::class, 'pengeluaran'])->name('pengeluaran.index');
        Route::post('/keuangan/pengeluaran', [KeuanganController::class, 'pengeluaranStore'])->name('keuangan.pengeluaran');
        Route::get('/forbodden', [HomeController::class, 'error'])->name('forbodden');
    });
