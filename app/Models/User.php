<?php

namespace App\Models;

use App\Traits\MustVerifyMobile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Interfaces\MustVerifyMobile as IMustVerifyMobile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements IMustVerifyMobile
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use MustVerifyMobile;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'mobile_verified_at',
        'mobile_verify_code',
        'mobile_attempts_left',
        'mobile_last_attempt_date',
        'mobile_verify_code_sent_at',
        'is_admin',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'mobile_verify_code',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'number_verified_at' => 'datetime',
        'mobile_verify_code_sent_at' => 'datetime',
        'mobile_last_attempt_date' => 'datetime'
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function routeNotificationForNetgsm()
    {
        return $this->mobile_number;
    }

    public function routeNotificationForVonage($notification)
    {
        return $this->mobile_number;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
