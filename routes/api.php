<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\ShopSettingController;
use App\Http\Controllers\User\CashierUserController;
use App\Http\Controllers\User\HeadUserController;
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

/** Public Routes */
Route::post('/login', [AuthController::class, 'store']); //! pass

/** Protected Routes */
Route::middleware(['auth:sanctum'])->group(function () {
    /** Auth */
    Route::controller(AuthController::class)->group(function () {
        Route::get('/profile', 'show'); //! pass
        Route::post('/logout', 'destroy'); //! pass
    });

    /** Shop */
    Route::controller(ShopController::class)->group(function () {
        Route::get('/shops', 'index'); //! pass
        Route::post('/shops', 'store'); //! pass
        Route::get('/shops/{id}', 'show'); //! pass
        Route::patch('/shops/{id}', 'update'); //! pass

        /*
        ? Only admin can access it.
        Route::delete('/shops/{id}', 'destroy'); // pass
        Route::get('/bin/shops', 'trash'); // pass
        Route::patch('/bin/shops/{id}', 'restore'); // pass
        */
    });

    /** Shop - Setting */
    Route::controller(ShopSettingController::class)->group(function () {
        Route::get('/shops/{id}/settings', 'show'); //! pass
        Route::post('/shops/{id}', 'update'); //! pass
    });

    /** User - Owner */
    Route::controller(OwnerUserController::class)->group(function () {
        Route::get('/owners', 'index'); //! pass
        Route::post('/owners', 'store'); //! pass
        Route::get('/owners/{id}', 'show'); //! pass
        Route::patch('/owners/{id}', 'update'); //! pass
    });

    /** User - Head */
    Route::controller(HeadUserController::class)->group(function () {
        Route::get('/heads', 'index'); //! pass
        Route::post('/heads', 'store'); //! pass
        Route::get('/heads/{id}', 'show'); //! pass
        Route::patch('/heads/{id}', 'update'); //! pass
    });

    /** User - Cashier */
    Route::controller(CashierUserController::class)->group(function () {
        Route::get('/cashiers', 'index'); //! pass
        Route::post('/cashiers', 'store'); //! pass
        Route::get('/cashiers/{id}', 'show'); //! pass
        Route::patch('/cashiers/{id}', 'update'); //! pass
    });
});
