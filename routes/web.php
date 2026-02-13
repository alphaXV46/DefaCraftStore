<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProdukController;
use App\Http\Controllers\Admin\AdminTransaksiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController; // Pastikan ini di-import

// ... routes ...

// Halaman Home (Public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Produk (Public)
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

// Route yang butuh Login
Route::middleware('auth')->group(function () {
    // Keranjang (existing)
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::post('/keranjang/{id}/toggle-check', [KeranjangController::class, 'toggleCheck'])->name('keranjang.toggle.check');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    // Perbaiki rute: tanpa {id} di URL, karena ID dikirim via JSON body
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{id}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move.cart');

    // Checkout & Transaksi
    Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');
    Route::post('/checkout', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/success', [TransaksiController::class, 'success'])->name('transaksi.success');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Riwayat Pesanan
    Route::get('/pesanan', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
    Route::post('/pesanan/{id}/upload-bukti', [TransaksiController::class, 'uploadBukti'])->name('transaksi.upload.bukti');
});

// Route Admin (Butuh login & role admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // CRUD Produk
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('produk.edit');
    Route::patch('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');

    // Kelola Transaksi
    Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [AdminTransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi/{id}/update-status', [AdminTransaksiController::class, 'updateStatus'])->name('transaksi.update.status');
});

require __DIR__.'/auth.php';