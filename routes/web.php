<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman harga
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');

// Detail produk
Route::get('/product/{type}/{id}', [HomeController::class, 'productDetail'])->name('product.detail');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Halaman keranjang (sementara)
Route::get('/cart', function () {
    return view('cart');
})->name('cart')->middleware('auth');

// Logout
Route::post('/logout', function () {
    // Logout logic here
    return redirect('/');
})->name('logout');