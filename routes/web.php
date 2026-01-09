<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return view('welcome', [
        'page' => request('page') 
    ]);
});

Route::middleware(['sessionauth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);
});

Route::middleware(['superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/{id}', [App\Http\Controllers\SuperAdminController::class, 'showAdmin'])->name('admin.show');
    Route::put('/admin/{id}/status', [App\Http\Controllers\SuperAdminController::class, 'updateAdminStatus'])->name('admin.updateStatus');
    Route::get('/admin/{id}/produk', [App\Http\Controllers\SuperAdminController::class, 'showAdminProduk'])->name('admin.produk');
    Route::get('/admin/{id}/kategori', [App\Http\Controllers\SuperAdminController::class, 'showAdminKategori'])->name('admin.kategori');
    Route::get('/admin/{id}/edit', [App\Http\Controllers\SuperAdminController::class, 'editAdmin'])->name('admin.edit');
    Route::put('/admin/{id}', [App\Http\Controllers\SuperAdminController::class, 'updateAdmin'])->name('admin.update');
});