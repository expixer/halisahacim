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

    public function features(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StadiumFeatures::class);
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

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? false, fn($query, $search) => $query->where(fn($query) => $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
        ));

        $query->when($filters['feature'] ?? false,
            fn($query, $feature) => $query->whereHas(
                'features', fn($query) => $query->where('name', $feature)
            )
        );

        /*        $query->when($filters['date'] ?? false,
                    fn($query, $date) => $query->whereHas(
                        'reservations',
                        fn($query) => $query->whereIn('match_date', $date)
                    )
                );*/

        $query->when($filters['city'] ?? false, fn($query, $city) => $query->where('city', $city));

        $query->when($filters['state'] ?? false, fn($query, $state) => $query->where('state', $state));

        $query->when($filters['price'] ?? false, fn($query, $price) => $query->where('daytime_price', '<=', $price)
            ->orWhere('nighttime_price', '<=', $price)
        );

        $query->when($filters['daytime_price'] ?? false, fn($query, $price) => $query->where('daytime_price', '<=', $price));

        $query->when($filters['nighttime_price'] ?? false, fn($query, $price) => $query->where('nighttime_price', '<=', $price));

        $query->when($filters['sort'] ?? false, fn($query, $sort) => $query->orderBy($sort, 'asc'));

        $query->when($filters['sort_desc'] ?? false, fn($query, $sort) => $query->orderBy($sort, 'desc'));

        $query->when($filters['stadiums'] ?? false, fn($query, $stadiums) => $query->whereIn('id', $stadiums));

        $query->when($filters['time'] ?? false,

            fn($query) => $query->whereRaw(count($filters['time']) * count($filters['date']) .
                " > (select count(*) from `reservations` where `stadia`.`id` = `reservations`.`stadium_id` and match_date in ('" . implode("', '", $filters['date']) . "') and match_time in ('" . implode("', '", $filters['time']) . "'))")

        );

    }
}
