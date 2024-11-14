<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Stadium extends Model {
    use HasFactory;

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

    protected $casts = [
        'recording' => 'boolean',
    ];

    public function firm(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Firm::class);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Comment::class);
    }

    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Reservation::class);
    }

    public function favoriteStadiums(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(FavoriteStadium::class);
    }

    public function images(): MorphMany {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function   features(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(StadiumFeatures::class);
    }

    //$date format: 2021-05-03
    public function getAvailableHours($date = null): bool|string
    {
        $date = Carbon::createFromFormat('Y-m-d', $date) ?? Carbon::now();
        $availableHours = [];

        // Başlangıç ve bitiş saatlerini oluştur
        $startTime = Carbon::createFromFormat('H:i:s', $this->opening_time)
            ->setDateFrom($date)
            ->setSecond(0);

        $endTime = Carbon::createFromFormat('H:i:s', $this->closing_time)
            ->setDateFrom($date)
            ->setSecond(0);

        // Eğer başlangıç saati, bitiş saatinden sonra ise bitiş saatini ertesi güne al
        if ($startTime > $endTime) {
            $endTime->addDay();
        }

        // Seçilen tarihe ait tüm rezervasyonları al
        $reservations = Reservation::where('stadium_id', $this->id)
            ->where('match_date', $date->format('Y-m-d'))
            ->pluck('match_time')
            ->toArray();

        $currentDateTime = Carbon::now()->addMinutes(30);
        $isTomorrow = false;

        while ($startTime <= $endTime) {
            // Saat ve durum verisini ayarla
            $hour = [
                'saat' => $startTime->format('H:i'),
                'durum' => in_array($startTime->format('H:i') . ':00', $reservations) ? 'dolu' : 'bos',
                'fiyat' => $this->daytime_price,
                'zaman' => $isTomorrow ? 'ertesi gun' : 'bugun',
            ];

            // Geçmiş saatleri belirle
            if ($startTime < $currentDateTime) {
                $hour['durum'] = 'gecmis';
            }

            // Günü değiştirirken 'ertesi gun' bilgisi ekle
            if (!$isTomorrow && $startTime->format('H:i') === '00:00') {
                $isTomorrow = true;
                $hour['zaman'] = 'ertesi gun';
            }

            $availableHours[] = $hour;
            $startTime->addHour();
        }

        return json_encode($availableHours);
    }

    //$duration: gün sayısı
    public function getAvailableHoursForDuration($date = null, $duration = 7): bool|string {
        $availableHours = [];
        $startDate = Carbon::createFromFormat('Y-m-d', $date) ?? Carbon::now();

        for ($i = 0; $i < $duration; $i++) {
            $currentDate = $startDate->copy()
                ->addDays($i);
            $hours = $this->getAvailableHours($currentDate->format('Y-m-d'));
            $availableHours[] = [
                'gun' => $currentDate->format('Y-m-d'),
                'saatler' => json_decode($hours),
            ];
        }

        return json_encode($availableHours);
    }


    //todo: düzeltilmeli
    public function getProperPrice($date) {
        if ($date->format('H:i') >= $this->daytime_start && $date->format('H:i') < $this->nighttime_start) {
            $price = $this->daytime_price;
        } elseif ($date->format('H:i') >= $this->nighttime_start && $date->format('H:i') < $this->nighttime_end) {
            $price = $this->nighttime_price;
        } else {
            $price = $this->daytime_price;
        }

        return $price;
    }

    public function scopeFilter($query, array $filters): void {
        $query->when($filters['search'] ?? false, fn($query, $search) => $query->where(fn($query) => $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')));

        $query->when($filters['feature'] ?? false, fn($query, $feature) => $query->whereHas('features', fn($query) => $query->where('name', $feature)));

        /*        $query->when($filters['date'] ?? false,
                    fn($query, $date) => $query->whereHas(
                        'reservations',
                        fn($query) => $query->whereIn('match_date', $date)
                    )
                );*/

        $query->when($filters['city'] ?? false, fn($query, $city) => $query->where('city', $city));

        $query->when($filters['state'] ?? false, fn($query, $state) => $query->whereIn('state', $state));

        $query->when($filters['price'] ?? false, fn($query, $price) => $query->where('daytime_price', '<=', $price)
            ->orWhere('nighttime_price', '<=', $price));

        $query->when($filters['daytime_price'] ?? false, fn($query, $price) => $query->where('daytime_price', '<=', $price));

        $query->when($filters['nighttime_price'] ?? false, fn($query, $price) => $query->where('nighttime_price', '<=', $price));

        $query->when($filters['sort'] ?? false, fn($query, $sort) => $query->orderBy($sort, 'asc'));

        $query->when($filters['sort_desc'] ?? false, fn($query, $sort) => $query->orderBy($sort, 'desc'));

        $query->when($filters['stadiums'] ?? false, fn($query, $stadiums) => $query->whereIn('id', $stadiums));

        $query->when($filters['time'] ?? false, fn($query) => $query->whereRaw(count($filters['time']) * count($filters['date']) . ' > (select count(*) from `reservations` where `stadia`.`id` = `reservations`.`stadium_id` and match_date in ' . "('" . implode("', '", $filters['date']) . "') and match_time in ('" . implode("', '", $filters['time']) . "'))"));

    }
}
