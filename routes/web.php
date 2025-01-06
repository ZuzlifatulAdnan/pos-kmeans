<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\KmeansController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/beranda');

Route::middleware(['auth'])->group(function () {
  // Beranda
    Route::resource('beranda', BerandaController::class);
    // kasir
    Route::resource('kasir', KasirController::class);
    Route::resource('order', OrderController::class);
    // Kmeans
    Route::resource('kmeans', KmeansController::class);
    // produk
    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriProdukController::class);

    // Route::get('/pemesanan/export', [PemesananController::class, 'export'])->name('pemesanan.export');
    // Route::get('/peminjaman/riwayat', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    // Route::get('/peminjaman/riwayat/detail/{id}', [PeminjamanController::class, 'detail'])->name('peminjaman.detail');
    // Route::get('/peminjaman/input', [PeminjamanController::class, 'input'])->name('peminjaman.input');
    // Route::post('/peminjaman/input', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    // Route::get('/peminjaman/proses', [PeminjamanController::class, 'proses'])->name('peminjaman.proses');
    // Route::get('/peminjaman/proses/edit/{pemesanan}', [PeminjamanController::class, 'editProses'])->name('peminjaman.editProses');
    // Route::patch('/peminjaman/proses/{pemesanan}', [PeminjamanController::class, 'updateProses'])->name('peminjaman.updateProses');
    // Route::get('/peminjaman/terima', [PeminjamanController::class, 'terima'])->name('peminjaman.terima');
    // Route::get('/peminjaman/terima/edit/{pemesanan}', [PeminjamanController::class, 'editTerima'])->name('peminjaman.editTerima');
    // Route::patch('/peminjaman/terima/{pemesanan}', [PeminjamanController::class, 'updateTerima'])->name('peminjaman.updateTerima');

    // Route::resource('ruangan', RuanganController::class);
    // Pembayaran
    Route::resource('pembayaran', PembayaranController::class);
    // User
    Route::resource('user', UserController::class);
    // Profile
    // Route::resource('profile', ProfileController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password-form');
    Route::post('profile/change-password/{user}', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});
