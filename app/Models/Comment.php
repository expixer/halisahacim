<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [];

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
}
