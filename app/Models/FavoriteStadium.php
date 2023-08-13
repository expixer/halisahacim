<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteStadium extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'stadium_id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
}
