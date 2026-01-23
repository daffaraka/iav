<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Wig;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_karyawan',
        'name',
        'email',
        'password',
        'username',
        'nip',
        'unit',
        'jenjang',
        'departemen',
        'no_hp',
        'jabatan',
        'kelas',
        'sub_kelas',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'unit' => 'string',
            'jenjang' => 'string',
        ];
    }


    public function wigs()
    {
        return $this->hasMany(Wig::class);
    }

    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }
}
