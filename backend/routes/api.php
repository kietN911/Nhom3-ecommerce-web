<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/products', [ProductController::class, 'index']);
Route::post('/checkout', [OrderController::class, 'checkout']);

Route::prefix('admin')->group(function (): void {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/products', [AdminController::class, 'products']);
    Route::post('/products', [AdminController::class, 'storeProduct']);
    Route::post('/products/{product}', [AdminController::class, 'updateProduct']);
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct']);
    Route::get('/users', [AdminController::class, 'users']);
    Route::patch('/users/{user}/toggle', [AdminController::class, 'toggleUser']);
    Route::get('/orders', [AdminController::class, 'orders']);
    Route::patch('/orders/{order}/confirm', [AdminController::class, 'confirmOrder']);
});
