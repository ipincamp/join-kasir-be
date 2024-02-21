<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Toko\SettingTokoController;
use App\Http\Controllers\Toko\TokoController;
use App\Http\Controllers\User\AdminUserController;
use App\Http\Controllers\User\CashierUserController;
use App\Http\Controllers\User\LeaderUserController;
use App\Http\Controllers\User\OwnerUserController;
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

    /** Admin */
    Route::controller(AdminUserController::class)->middleware('ability:admin')->group(function () {
        Route::get('/users', 'allUsers'); // passed
        Route::get('/users/active', 'active'); // passed
        Route::get('/users/deleted', 'deleted'); // passed
        Route::get('/users/{id}/restore', 'restore'); // passed
        Route::patch('/users/{id}/reset', 'resetPassword'); // passed
        Route::delete('/users/{id}/temp', 'tempoRemove'); // passed
        Route::delete('/users/{id}/perm', 'permaRemove'); // passed
    });

    /** Toko */
    Route::controller(TokoController::class)->group(function () {
        Route::get('/tokos', 'index'); // passed
        Route::post('/tokos', 'store'); // passed
        Route::get('/tokos/{id}', 'show'); // passed
        Route::patch('/tokos/{id}', 'update'); // passed
        // Route::delete('/tokos/{id}', 'destroy');
    });

    /** Setting Toko */
    Route::controller(SettingTokoController::class)->group(function () {
        Route::get('/tokos/{kode}/settings', 'show'); // passed
        Route::post('/tokos/{kode}/settings', 'store'); // passed
    });

    /** Owner */
    Route::controller(OwnerUserController::class)->group(function () {
        Route::get('/owners', 'index'); // passed
        Route::post('/owners', 'store'); // passed
        Route::patch('/owners/{id}', 'update'); // passed
    });

    /** Leader */
    Route::controller(LeaderUserController::class)->group(function () {
        Route::get('/leaders', 'index'); // passed
        Route::post('/leaders', 'store'); // passed
        Route::patch('/leaders/{id}', 'update'); // passed
    });

    /** Cashier */
    Route::controller(CashierUserController::class)->group(function () {
        Route::get('/cashiers', 'index'); // passed
        Route::post('/cashiers', 'store'); // passed
        Route::patch('/cashiers/{id}', 'update'); // passed
    });
});
