<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;

Route::get('/products', [ProductController::class, 'index']);

Route::apiResource('cart', CartController::class);
Route::post('checkout', [OrderController::class, 'store']);
