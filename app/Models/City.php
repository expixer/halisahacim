<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
