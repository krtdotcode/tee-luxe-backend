<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('users', \App\Http\Controllers\UserController::class);

// Auth routes
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

// Public routes
Route::apiResource('categories', \App\Http\Controllers\CategoryController::class)->only(['index', 'show']);
Route::apiResource('products', \App\Http\Controllers\ProductController::class)->only(['index', 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::apiResource('cart', \App\Http\Controllers\CartController::class);
    Route::apiResource('orders', \App\Http\Controllers\OrderController::class)->only(['index', 'store', 'show']);
});

?>
