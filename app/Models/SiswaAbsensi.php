<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiswaAbsensi extends Model
{
    use HasFactory;

    protected $table = 'siswa_absensis'; // pastikan ini sesuai dengan nama tabel di database

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
        'foto_masuk',
        'foto_pulang',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Siswa melalui User
    public function siswa()
    {
        return $this->hasOneThrough(
            \App\Models\Siswa::class, // Model tujuan akhir
            \App\Models\User::class,  // Model penghubung
            'id',                     // Foreign key di tabel users (untuk absensi.user_id)
            'email',                  // Foreign key di tabel siswa (untuk users.email)
            'user_id',                // Local key di tabel siswa_absensis
            'email'                   // Local key di tabel users
        );
    }
}
