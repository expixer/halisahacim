<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [];

    public function stadiums()
    {
        return $this->hasMany(Stadium::class);
    }
}
