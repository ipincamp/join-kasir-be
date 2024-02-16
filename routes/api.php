<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\OwnerController;
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
Route::post('/login', [AuthController::class, 'login']); // passed

/** Protected routes */
Route::middleware(['auth:sanctum'])->group(function () {
    /** Auth */
    Route::controller(AuthController::class)->group(function () {
        Route::get('/profile', 'profile'); // passed
        Route::post('/logout', 'logout'); // passed
    });

    /** Toko */
    Route::controller(TokoController::class)->group(function () {
        Route::get('/tokos', 'index'); // passed
        Route::post('/tokos', 'store'); // passed
        Route::get('/tokos/{id}', 'show'); // passed
    });

    /** Admin */
    Route::controller(AdminController::class)->middleware('ability:admin')->group(function () {
        Route::patch('/users/{id}/password', 'updatePassword');
        Route::delete('/users/{id}', 'destroy');
    });

    /** Owner */
    Route::controller(OwnerController::class)->group(function () {
        Route::get('/owners', 'index'); // passed
        Route::post('/owners', 'store'); // passed
        Route::patch('/owners/{id}', 'update');
    });

    /** Leader */
    Route::controller(LeaderController::class)->group(function () {
        Route::get('/leaders', 'index'); // passed
        Route::post('/leaders', 'store'); // passed
        Route::patch('/leaders/{id}', 'update');
    });

    /** Cashier */
    Route::controller(CashierController::class)->group(function () {
        Route::get('/cashiers', 'index'); // passed
        Route::post('/cashiers', 'store'); // passed
        Route::patch('/cashiers/{id}', 'update');
    });
});
