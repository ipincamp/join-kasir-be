<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/** Public routes */
Route::post('/login', [AuthController::class, 'login']);

/** Protected routes */
Route::middleware(['auth:sanctum'])->group(function () {
    /** Auth */
    Route::controller(AuthController::class)->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/logout', 'logout');
    });

    /** Toko */
    Route::controller(TokoController::class)->group(function () {
        Route::get('/tokos', 'index');
        Route::post('/tokos', 'store');
        Route::get('/tokos/{id}', 'show');
    });
});
