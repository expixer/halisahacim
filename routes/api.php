<?php

use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Api\V1;
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
Route::middleware(['cors'])->group(function () {
    Route::post('auth/register', Auth\RegisterController::class);
    Route::post('auth/login', Auth\LoginController::class);

    Route::middleware(['auth:sanctum', 'verify.mobile'])->group(function () {
        Route::get('profile', [Auth\ProfileController::class, 'show']);
        Route::put('profile', [Auth\ProfileController::class, 'update']);
        Route::put('password', Auth\PasswordUpdateController::class);
        Route::post('auth/logout', Auth\LogoutController::class);
    });
    Route::apiResource('stadiums', V1\StadiumController::class);

});
