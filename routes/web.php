<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\AdminUserManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProdukController;
use App\Http\Controllers\Admin\AdminTransaksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ChatbotController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\User;

require __DIR__.'/auth.php';

// =====================
// HALAMAN PUBLIC
// =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

// =====================
// HALAMAN STATIS (BANTUAN)
// =====================
Route::get('/bantuan/pengembalian', fn() => view('pages.bantuan.pengembalian'))->name('bantuan.pengembalian');
Route::get('/bantuan/cara-pesan',   fn() => view('pages.bantuan.cara-pesan'))->name('bantuan.cara-pesan');
Route::get('/bantuan/pengiriman',   fn() => view('pages.bantuan.pengiriman'))->name('bantuan.pengiriman');
Route::get('/bantuan/faq',          fn() => view('pages.bantuan.faq'))->name('bantuan.faq');
Route::get('/bantuan/kontak',       fn() => view('pages.bantuan.kontak'))->name('bantuan.kontak');

// Chatbot Route
Route::post('/chatbot/tanya', [ChatbotController::class, 'tanyaChatbot'])->name('chatbot.tanya');

Route::prefix('ongkir')->middleware('throttle:ongkir')->group(function () {
    Route::get('/search', [OngkirController::class, 'searchDestination'])->name('ongkir.search');
    Route::post('/calculate', [OngkirController::class, 'calculate'])->name('ongkir.calculate');
});

// =====================
// ROUTE YANG BUTUH LOGIN
// =====================
Route::middleware('auth')->group(function () {
    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::post('/beli-langsung', [KeranjangController::class, 'beliLangsung'])->name('beli-langsung');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::post('/keranjang/{id}/toggle-check', [KeranjangController::class, 'toggleCheck'])->name('keranjang.toggle.check');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{id}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move.cart');

    // Checkout & Transaksi
    Route::get('/checkout', [TransaksiController::class, 'checkout'])->name('transaksi.checkout');
    Route::post('/checkout', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/success/{id?}', [TransaksiController::class, 'success'])->name('transaksi.success');
    Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi/{id}/cancel', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    Route::post('/transaksi/{id}/received', [TransaksiController::class, 'received'])->name('transaksi.received');
    Route::post('/transaksi/{id}/upload-bukti', [TransaksiController::class, 'uploadBukti'])->name('transaksi.upload.bukti');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});

// =====================
// ROUTE ADMIN
// =====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Route Kategori
    Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class)->except(['create', 'show', 'edit', 'update']);

    // Route Produk
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('produk.edit');
    Route::patch('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
    Route::patch('/produk/{id}/toggle-status', [AdminProdukController::class, 'toggleStatus'])->name('produk.toggle-status');

    Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [AdminTransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi/{id}/update-status', [AdminTransaksiController::class, 'updateStatus'])->name('transaksi.update.status');

    // Route Manajemen User (Pembeli/Pelanggan)
    Route::get('/users', [AdminUserManagementController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [AdminUserManagementController::class, 'update'])->name('users.update');
    Route::patch('/users/{id}/toggle', [AdminUserManagementController::class, 'toggleStatus'])->name('users.toggle');
    Route::post('/users/{id}/reset-password', [AdminUserManagementController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{id}', [AdminUserManagementController::class, 'destroy'])->name('users.destroy');
});

// =====================
// GOOGLE LOGIN
// =====================
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'password' => Hash::make(Str::random(16)),
        ]
    );

    Auth::login($user);

    return redirect()->route('home');
});

// =====================
// WEBHOOK MIDTRANS (Tanpa auth & CSRF)
// =====================
Route::post('/webhook/midtrans', [MidtransWebhookController::class, 'handle'])->name('webhook.midtrans');

// =====================
// DEBUG ROUTE (Hapus di production!)
// =====================
Route::get('/laporan-data', function () {
    return response()->json(['ok' => true, 'total' => \App\Models\Transaksi::count()]);
});

// =====================
// ROUTE KHUSUS SUPERADMIN
// =====================
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/cek-pangkat', function () {
        return "Selamat! Kamu login sebagai: " . auth()->user()->role;
    })->name('cek');

    // CRUD MANAJEMEN ADMIN
    Route::get('/manage-admin', [AdminManagementController::class, 'index'])->name('manage');
    Route::post('/manage-admin', [AdminManagementController::class, 'store'])->name('store'); 
    Route::delete('/manage-admin/{id}', [AdminManagementController::class, 'destroy'])->name('delete');
    
    // Log Aktivitas
    Route::get('/logs', function() {
        $logs = \DB::table('logs')->orderBy('created_at', 'desc')->get();
        return view('admin.logs', compact('logs'));
    })->name('logs');
});

// =====================
// PROGRAMMATIC MIGRATION RUNNERS (Aman & Instan)
// =====================
Route::get('/run-migration-securely', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate');
        return "<h3>✓ Migrasi Berhasil Dijalankan!</h3><pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre><br><a href='/admin/users' style='padding: 10px 20px; background: #EAB308; color: #fff; text-decoration: none; border-radius: 8px; font-weight: bold;'>Kembali ke Manajemen Pelanggan</a>";
    } catch (\Exception $e) {
        return "<h3>✗ Gagal Migrasi:</h3><pre>" . $e->getMessage() . "</pre>";
    }
});

Route::get('/run-fresh-seed-securely', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true]);
        return "<h3>✓ Rebuild Database & Seeding Berhasil!</h3><pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre><br><a href='/admin/users' style='padding: 10px 20px; background: #EAB308; color: #fff; text-decoration: none; border-radius: 8px; font-weight: bold;'>Kembali ke Manajemen Pelanggan</a>";
    } catch (\Exception $e) {
        return "<h3>✗ Gagal Fresh Seed:</h3><pre>" . $e->getMessage() . "</pre>";
    }
});