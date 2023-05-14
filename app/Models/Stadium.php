<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Stadium extends Model
{
    protected $fillable = [
        'name',
        'firm_id',
        'address',
        'city',
        'state',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website',
        'facebook',
        'instagram',
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

    public function firm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function favoriteStadiums(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FavoriteStadium::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    //$date format: 2021-05-03
    public function getAvailableHours($date = null): bool|string
    {
        $availableHours = array();
        $date = Carbon::createFromFormat('Y-m-d', $date) ?? Carbon::now();
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . $this->opening_time)->setMinute(0)->setSecond(0);
        $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . $this->closing_time)->setMinute(0)->setSecond(0);

        if ($startTime > $endTime) {
            $endTime->addDay();
        }

        $startTimeForloop = $startTime->copy();
        while ($startTimeForloop <= $endTime) {
            $hour = array(
                "saat" => $startTimeForloop->format('H:i'),
                "durum" => "bos"
            );

            $hour['fiyat'] = $this->daytime_price; //$this->setProperPrice($start_time);


            if (!$startTimeForloop->lt($date->copy()->setHour(24)->setMinute(0)->setSecond(0))) {
                $hour['zaman'] = 'ertesi gun';
            } else {
                $hour['zaman'] = 'bugun';
            }

            if ($startTimeForloop < Carbon::now()->addMinutes(30)) {
                $hour['durum'] = 'gecmis';
            }
            $availableHours[] = $hour;
            $startTimeForloop->addHour();
        }

        // Seçilen bir tarihe ait tüm rezervasyonları çekelim.
        $reservations = Reservation::where('stadium_id', $this->id)
            ->where('match_date', $date->format('Y-m-d'))
            ->pluck('match_time')
            ->toArray();

        $availableHours = array_map(function ($saat) use ($reservations) {
            // array_search ile rezervasyonların içinde belirli bir saatin olup olmadığını kontrol edelim.
            if (array_search($saat['saat'] . ':00', $reservations) !== false) {
                $saat['durum'] = 'dolu';
            }
            return $saat;
        }, $availableHours);

        return json_encode($availableHours);
    }

    //$duration: gün sayısı
    public function getAvailableHoursForDuration($date = null, $duration = 7): bool|string
    {
        $availableHours = array();
        $startDate = Carbon::createFromFormat('Y-m-d', $date) ?? Carbon::now();

        for ($i = 0; $i < $duration; $i++) {
            $currentDate = $startDate->copy()->addDays($i);
            $hours = $this->getAvailableHours($currentDate->format('Y-m-d'));
            $availableHours[] = array(
                'gun' => $currentDate->format('Y-m-d'),
                'saatler' => json_decode($hours),
            );
        }

        return json_encode($availableHours);
    }

    //gündüz veya gece tarifesine göre fiyatı ayarlar
    //todo: düzeltilmeli
    public function setProperPrice($date)
    {
        if ($date->format('H:i') >= $this->daytime_start && $date->format('H:i') < $this->nighttime_start) {
            $price = $this->daytime_price;
        } elseif ($date->format('H:i') >= $this->nighttime_start && $date->format('H:i') < $this->nighttime_end) {
            $price = $this->nighttime_price;
        } else {
            $price = $this->daytime_price;
        }
        return $price;
    }

    /*    public function scopeFilter($query, array $filters): void
        {
            $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where(fn($query) =>
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')
            )
            );

            $query->when($filters['category'] ?? false, fn($query, $category) =>
            $query->whereHas('category', fn ($query) =>
            $query->where('slug', $category)
            )
            );

            $query->when($filters['author'] ?? false, fn($query, $author) =>
            $query->whereHas('author', fn ($query) =>
            $query->where('username', $author)
            )
            );
        }*/
}
