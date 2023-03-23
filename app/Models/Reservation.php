<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stadium_id',
        'match_date',
        'match_time',
        'match_type',
        'match_duration',
        'match_team',
        'match_team2',
        'price',
        'payment_method',
        'payment_status',
        'payment_id',
        'payment_url',
        'status',
        'notes',
        'phone',
        'email',
    ];

    protected $casts = [
        'match_date' => 'date',
        'price' => 'double',
    ];

    public function getMatchDateTimeAttribute()
    {
        return $this->match_date->format('Y-m-d') . ' ' . $this->match_time->format('H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }


}
