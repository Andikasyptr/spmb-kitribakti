<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kelas;

class ProfileSiswa extends Model
{
    use HasFactory;

    protected $table = 'profile_siswa';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'nisn',
        'nik',
        'no_kk',
        'ttl',
        'tahun_masuk',
        'nis',
        'no_ijazah',
        'kelas_id',
        'jurusan',
        'asal_sekolah',
        'alamat',
        'no_hp',

        // Data Ayah
        'nama_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',

        // Data Ibu
        'nama_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',

        'alamat_orang_tua',

        // File Uploads
        'file_skl',
        'file_ijazah',
        'file_ktp_orang_tua',
        'file_kk',
        'file_foto',
    ];

    /**
     * Relasi ke tabel users.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel kelas (jika kelas_id digunakan).
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
