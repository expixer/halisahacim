<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'state_id',
    ];

    protected $table = 'state_user';
}
