<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });
    Route::middleware(['auth'])->group(function () {
        Route::post('logout', 'destroy')->name('logout');
    });
});
