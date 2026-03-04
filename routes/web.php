<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products');
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::post('/midtrans/callback', [App\Http\Controllers\ChatController::class, 'midtransCallback']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.send');
    
    // Placeholder Bayar
    Route::get('/invoice/{id}/pay', function($id) {
        return "Halaman Upload Bukti Bayar ID: $id (Coming Soon)";
    })->name('invoice.pay');
    Route::get('/invoice/{id}/confirm', [ChatController::class, 'showConfirmForm'])->name('invoice.confirm');
    Route::post('/invoice/{id}/confirm', [ChatController::class, 'processConfirm'])->name('invoice.process');
    Route::get('/invoice/{id}/payment', [ChatController::class, 'showPayment'])->name('invoice.payment');
    Route::post('/invoice/{id}/payment', [ChatController::class, 'processPayment'])->name('invoice.payment.process');
    Route::post('/chat/product/{id}', [ChatController::class, 'sendProductMessage'])->name('chat.send_product');
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::delete('/customers/{id}', [AdminController::class, 'customerDestroy'])->name('admin.customers.destroy');

    // Produk
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'productEdit'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminController::class, 'productUpdate'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'productDestroy'])->name('admin.products.destroy');

    // Chat & Invoice
    Route::get('/chat/{user_id?}', [AdminController::class, 'chat'])->name('admin.chat');
    Route::post('/chat/reply/{user_id}', [AdminController::class, 'chatReply'])->name('admin.chat.reply');
    
    // Route Baru: Buat Invoice
    Route::post('/chat/invoice/{user_id}', [AdminController::class, 'createInvoice'])->name('admin.chat.invoice');
    Route::post('/invoice/{id}/approve', [AdminController::class, 'approveInvoice'])->name('admin.invoice.approve');

    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');

    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('admin.settings.update');
});