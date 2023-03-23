<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    protected $fillable = [
        'name',
        'firm_id',
        'description',
        'opening_time',
        'closing_time',
        'daytime_start',
        'nighttime_start',
        'nighttime_end',
        'daytime_price',
        'nighttime_price',
        'recording',
    ];

    protected $hidden = [];
    use HasFactory;

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getAvailableHours($date = null)
    {
        $saatler = array();
        $date = $date ?? Carbon::now()->format('Y-m-d');
        $start_time = Carbon::createFromFormat('H:i:s', $this->opening_time)->setMinute(0)->setSecond(0);
        $end_time = Carbon::createFromFormat('H:i:s', $this->closing_time)->setMinute(0)->setSecond(0);

        if ($start_time > $end_time) {
            $end_time->addDay();
        }

        while ($start_time <= $end_time) {
            $saat = array(
                "saat" => $start_time->format('H:i'),
                "durum" => "bos"
            );
            $saatler[] = $saat;
            $start_time->addHour();
        }

        $saatler = array_map(function ($saat) use ($date) {
            if (Reservation::where('stadium_id', $this->id)->where('match_date', $date)->where('match_time', $saat['saat'])->exists()) {
                $saat['durum'] = 'dolu';
            }
            return $saat;
        }, $saatler);

        return json_encode($saatler);
    }
}
