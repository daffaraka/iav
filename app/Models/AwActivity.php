<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AwActivity extends Model
{
    protected $fillable = [
        'date',
        'user_id',
        'is_facilitator',
        'is_culture_champion',
        'yesterday_activity',
        'aw_value',
        'habits',
        'is_favorite',
    ];

    protected $casts = [
        'date' => 'date',
        'aw_value' => 'array',
        'habits' => 'array',
        'is_facilitator' => 'boolean',
        'is_culture_champion' => 'boolean',
        'is_favorite' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
