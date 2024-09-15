<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Middleware\JWTTokenIsValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/update-token', 'update_token');
});

Route::controller(TransaksiController::class)->middleware([JWTTokenIsValid::class])->group(function () {
    Route::post('/transfer', 'transfer');
});
