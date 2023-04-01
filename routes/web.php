<?php

use App\Http\Controllers\Auth\VerifyMobileController;
use App\Http\Controllers\TempController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('gitpull', [TempController::class, 'gitpull']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'verify.mobile',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::view('verify-mobile','auth.verify-mobile')->name('verification-mobile.notice');
Route::post('verify-mobile', [VerifyMobileController::class, '__invoke'])
    ->middleware(['throttle:6,1'])
    ->name('verification.verify-mobile');
