<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentCallbackController;

Route::get('/pricing', [PricingController::class, 'index']);
Route::post('/pricing', [PricingController::class, 'store']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('kategori', KategoriController::class);
Route::apiResource('produk', ProdukController::class);
Route::apiResource('transaksi', TransaksiController::class);
Route::post('/midtrans-callback', [PaymentCallbackController::class, 'handle']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pricing', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API pricing hidup'
    ]);
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);