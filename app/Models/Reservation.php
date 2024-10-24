<?php

namespace App\Models;

use Carbon\Carbon;
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
        'price' => 'double',
    ];

    public function getMatchDateTimeAttribute(): string
    {
        return Carbon::parse($this->match_date)->format('Y-m-d').' '.Carbon::parse($this->match_time)->format('H:i:s');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stadium(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Stadium::class);
    }

    public function scopeActiveMatches($query): void
    {
        $now = Carbon::now();
        $query->with('stadium')->where('match_date', '>=', $now->format('Y-m-d'));

        if ($now->format('Y-m-d') === $this->match_date) {
            $query->where('match_time', '>=', $now->format('H:i:s'));
        }
        $query->orderBy('match_date', 'desc');
    }

    public function scopeOldMatches($query)
    {
        $now = Carbon::now();

        $query->with('stadium')
            ->where('match_date', '<=', $now->format('Y-m-d'))
            ->where('match_time', '<=', $now->format('H:i:s'))
            ->orderBy('match_date', 'desc');

        return $query;
    }
}
