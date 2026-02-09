<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Data produk sekarang diambil dari Database melalui ProductController.
| Tidak ada lagi array hardcoded di sini agar backend bisa berjalan.
|
*/

// --- HALAMAN PUBLIK (Bisa diakses siapa saja) ---

// Halaman Utama (Home)
Route::get('/', [ProductController::class, 'home'])->name('home');

// Halaman List Semua Produk & Filter
Route::get('/produk', [ProductController::class, 'index'])->name('products');

// Halaman Detail Produk
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('product.detail');


// --- AUTHENTICATION (Login, Register, Logout) ---

Route::middleware('guest')->group(function () {
    // Menampilkan Form Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    // Proses Login
    Route::post('/login', [AuthController::class, 'login']);

    // Menampilkan Form Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    // Proses Register
    Route::post('/register', [AuthController::class, 'register']);
});

// Proses Logout (Hanya bisa jika sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// --- HALAMAN KHUSUS USER LOGIN ---
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.send');
});


// --- HALAMAN KHUSUS ADMIN ---
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    
    Route::get('/admin/dashboard', function () {
        return "<h1>Selamat Datang di Dashboard Admin</h1><p>Di sini nanti tempat tambah/edit produk.</p><a href='/'>Kembali ke Home</a>";
    })->name('admin.dashboard');

});

Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Manajemen Produk
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('admin.products.store');
    
    Route::get('/products/{id}/edit', [AdminController::class, 'productEdit'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminController::class, 'productUpdate'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'productDestroy'])->name('admin.products.destroy');

    Route::get('/chat/{user_id?}', [App\Http\Controllers\AdminController::class, 'chat'])->name('admin.chat');
    
    // Kirim balasan ke user
    Route::post('/chat/reply/{user_id}', [App\Http\Controllers\AdminController::class, 'chatReply'])->name('admin.chat.reply');

});