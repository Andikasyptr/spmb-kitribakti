<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status_masuk',
        'status_pulang',
        'status_hari',
        'keterangan',
        'dibuat_oleh',
        'lokasi_masuk',
        'lokasi_pulang',
         'foto_masuk',          // ✅ Tambahkan ini
        'foto_pulang',   // ✅ Tambahkan 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pegawai()
{
    return $this->hasOneThrough(
        \App\Models\Pegawai::class,
        \App\Models\User::class,
        'id',        // Foreign key di User untuk Absensi (user_id)
        'email',     // Foreign key di Pegawai untuk User (email)
        'user_id',   // Foreign key di Absensi
        'email'      // Local key di User
    );
}

    
}