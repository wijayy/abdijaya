<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/tambah-produk', [ProdukController::class, 'index'])->name('produk.tambah');
    Route::post('/tambah-produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/edit/{id}/produk', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/edit/{id}/produk', [ProdukController::class, 'update'])->name('produk.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
