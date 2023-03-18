<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    protected $guarded = [];
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
}
