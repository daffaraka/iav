<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FqInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'featured_question_id',
        'visitor_id',
        'ip_address',
        'clicked_at',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    /**
     * Relasi ke FeaturedQuestion.
     */
    public function featuredQuestion()
    {
        return $this->belongsTo(FeaturedQuestion::class);
    }
}
