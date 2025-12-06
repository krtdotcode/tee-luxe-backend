<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('users', \App\Http\Controllers\UserController::class);

Route::apiResource('categories', \App\Http\Controllers\CategoryController::class)->only(['index', 'show']);
Route::apiResource('products', \App\Http\Controllers\ProductController::class)->only(['index', 'show']);

?>
