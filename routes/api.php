<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SyncApiController;
use Illuminate\Support\Facades\Route;

// Public Auth
Route::post('/login', [AuthController::class, 'login']);

// Protected API Routes (Bearer Token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Products
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/barcode/{barcode}', [ProductApiController::class, 'barcode']);

    // Members
    Route::get('/members', [MemberApiController::class, 'index']);
    Route::get('/members/{id}', [MemberApiController::class, 'show']);

    // Orders / POS Transactions
    Route::get('/orders', [OrderApiController::class, 'index']);
    Route::post('/orders', [OrderApiController::class, 'store']);

    // Offline POS Sync Engine
    Route::get('/sync/down', [SyncApiController::class, 'syncDown']);
    Route::post('/sync/up', [SyncApiController::class, 'syncUp']);
});
