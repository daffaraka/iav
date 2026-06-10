<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'jawaban',
        'kategori',
        'tiket_id',
        'is_pinned',
        'is_published',
        'view_count',
        'vote_count',
        'order',
        'created_by',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_published' => 'boolean',
    ];

    /**
     * Relasi ke tiket (nullable).
     */
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    /**
     * Relasi ke user pembuat.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke interaksi FAQ.
     */
    public function interactions()
    {
        return $this->hasMany(FqInteraction::class);
    }

    /**
     * Relasi ke vote FAQ.
     */
    public function votes()
    {
        return $this->hasMany(FqVote::class);
    }

    /**
     * Scope: hanya yang published.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope: hanya yang pinned.
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope: filter berdasarkan kategori.
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Cek apakah user sudah vote.
     */
    public function isVotedBy(User $user): bool
    {
        return $this->votes()->where('user_id', $user->id)->exists();
    }
}
