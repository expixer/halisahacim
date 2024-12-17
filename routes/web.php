<?php
use App\Http\Controllers\Auth\VerifyMobileController;
use App\Models\User;
use App\Notifications\FirebaseNotification;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
  $user = User::first(); // Kullanıcı ID'si ile kullanıcıyı bulun
  if ($user && $user->fcm_token) {
    $user->notify(new FirebaseNotification());
    return response()->json(['message' => 'Bildirim gönderildi.']);
  }
  return response()->json(['error' => 'Kullanıcı bulunamadı veya FCM token eksik.'], 404);

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
