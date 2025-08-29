<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'nisn',
        'nis', // baru
        'nik',
        'jenis_kelamin',
        'agama',
        'no_kk',
        'ttl',
        'tahun_masuk',
        'tahun_ajaran',
        'kelas_id',
        'kode_kelas',
        'jurusan',
        'asal_sekolah',
        'alamat',
        'status',
        'no_hp',
        'nama_ayah',
        'nama_ibu',
        'alamat_orang_tua',

        // Tambahan baru
        'no_ijazah',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'nik_ayah',
        'nik_ibu',
        'penghasilan_ayah',
        'penghasilan_ibu',

        // File upload
        'file_skl',
        'file_ijazah',
        'file_ktp_orang_tua',
        'file_kk',
        'file_foto',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
