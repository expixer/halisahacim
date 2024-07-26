<?php
use App\Http\Controllers\Auth\VerifyMobileController;
use App\Http\Controllers\TempController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::view('verify-mobile', 'auth.verify-mobile')->name('verification-mobile.notice');
Route::post('verify-mobile', [VerifyMobileController::class, '__invoke'])
    ->middleware(['throttle:6,1'])
    ->name('verification.verify-mobile');
