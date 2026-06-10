<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FqVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'featured_question_id',
        'user_id',
    ];

    /**
     * Relasi ke FeaturedQuestion.
     */
    public function featuredQuestion()
    {
        return $this->belongsTo(FeaturedQuestion::class);
    }

    /**
     * Relasi ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
