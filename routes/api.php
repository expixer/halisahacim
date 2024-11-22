<?php

use App\Http\Controllers\Api\V1;
use App\Http\Controllers\Api\V1\Auth;
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
Route::middleware(['cors', 'api'])->group(function () {
    Route::post('auth/register', Auth\RegisterController::class);
    Route::post('auth/login', Auth\LoginController::class);
    Route::get('cities', [V1\CityController::class, 'index']);
    Route::post('apply-for-panel', [V1\EmailController::class, 'applyForPanel']);

    Route::get('cities/{city}', [V1\StateController::class, 'index']);
    Route::get('stadiums/search', [V1\StadiumSearchController::class, 'index']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('active-matches', [V1\MatchController::class, 'ActiveMatches']);
        Route::get('old-matches', [V1\MatchController::class, 'OldMatches']);

        Route::post('verify-mobile-code', [Auth\VerifyMobileController::class, 'verifyMobileCode']);
        Route::get('resend-mobile-code', [Auth\VerifyMobileController::class, 'resendVerifyCode']);
        Route::get('profile', [Auth\ProfileController::class, 'show']);
        Route::get('profile/address', [Auth\ProfileController::class, 'getAddress']);
        Route::put('profile', [Auth\ProfileController::class, 'update']);
        Route::put('update-address', [Auth\ProfileController::class, 'updateAddress']);
        Route::put('email-update', [Auth\ProfileController::class, 'updateEmail']);
        Route::put('password', Auth\PasswordUpdateController::class);
        Route::post('auth/logout', Auth\LogoutController::class);

        Route::middleware(['verify.mobile'])->group(function () {
            Route::apiResource('images', V1\ImageController::class);
            Route::apiResource('stadiums', V1\StadiumController::class);
            Route::get('reservations/get-available', [V1\ReservationController::class, 'getAvailableHours']);
            Route::get('reservations/get-available-duration', [V1\ReservationController::class, 'getAvailableHoursForDuration']);
            Route::apiResource('reservations', V1\ReservationController::class);
            Route::apiResource('favorites', V1\FavoriteStadiumController::class);
            /* Route::get('reservations/{reservation}/cancel', [V1\ReservationController::class, 'cancel']);
            Route::get('reservations/{reservation}/approve', [V1\ReservationController::class, 'approve']);
            Route::get('reservations/{reservation}/reject', [V1\ReservationController::class, 'reject']);
            */
        });
    });

});
