<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ExportController;
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
  // Export
  Route::resource('export', ExportController::class);
  // Beranda
  Route::resource('beranda', BerandaController::class);
  // kasir
  Route::resource('kasir', KasirController::class);
  Route::get('/kasir/order/{orderId}', [KasirController::class, 'show'])->name('kasir.show');
  Route::get('/kasir/cetak-nota/{orderId}', [KasirController::class, 'cetakNota'])->name('kasir.cetakNota');
  // order
  Route::resource('order', OrderController::class);
  Route::delete('/order/{order}/produk/{orderProduk}', [OrderController::class, 'removeProduct'])->name('order.removeProduct');

  // Kmeans
  Route::resource('kmeans', KmeansController::class);
  // produk
  Route::resource('produk', ProdukController::class);
  Route::resource('kategori', KategoriProdukController::class);

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
