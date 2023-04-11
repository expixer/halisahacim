<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'imageable_id',
        'imageable_type',
    ];

    protected $hidden = [
        'id',
        'imageable_id',
        'imageable_type',
        'created_at',
        'updated_at',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }


    public function getPathAttribute($value)
    {
        return asset('storage/' . $value);
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = strtolower($value);
    }

    public static function getImageableType($type)
    {
        return match ($type) {
            'stadium' => Stadium::class,
            'firm' => Firm::class,
            'user' => User::class,
            default => Stadium::class,
        };
    }
}
