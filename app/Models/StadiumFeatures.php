<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StadiumFeatures extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'stadium_id',
        'name',
        'value',
        'is_active',
        'is_required',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_required' => 'boolean',
    ];

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
}
