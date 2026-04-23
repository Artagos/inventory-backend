<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Products endpoints (protected)
Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');
Route::get('products/low-stock', [ProductController::class, 'lowStock'])->middleware('auth:sanctum');

// Categories endpoints (public for now)
Route::apiResource('categories', CategoryController::class);
