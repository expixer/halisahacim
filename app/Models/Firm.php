<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Firm extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'updated_at',
    ];

    public function stadiums()
    {
        return $this->hasMany(Stadium::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
