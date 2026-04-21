<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['status' => 'Backend is running', 'version' => '1.0.0']);
});
