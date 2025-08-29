<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Siswa;

/**
 * @property \App\Models\Siswa $siswa
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        ];
    }
        public function profileAdmin()
    {
        return $this->hasOne(ProfileAdmin::class); // Pastikan nama modelnya sesuai
    }
        public function profileGuru()
    {
        return $this->hasOne(ProfileGuru::class);
    }
    
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'email', 'email',);
    }
    

   // User.php
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id');
    }


    
    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class, 'kelas_id');
    }




}
