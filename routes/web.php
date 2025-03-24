<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/tambah-produk', [ProdukController::class, 'index'])->name('produk.tambah');
    Route::post('/tambah-produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/edit/{id}/produk', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/edit/{id}/produk', [ProdukController::class, 'update'])->name('produk.update');
    Route::get('/produk/{id}/detail', [ProdukController::class, 'show'])->name('produk.show');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    
    Route::get('/history', [ProdukHistoryController::class, 'index'])->name('history');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/tambah', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/tambah', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}/edit', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
