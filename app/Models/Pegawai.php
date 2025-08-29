<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'nip',
        'jabatan',
        'no_hp',
        'alamat',
        'ttl',
        'tahun_masuk',
        'jenis_pegawai',
        'foto',
        'senin',
        'selasa',
        'rabu',
        'kamis',
        'jumat',
    ];

    // Relasi ke tabel sk
    public function sks()
    {
        return $this->hasMany(PegawaiSk::class);
    }

    // Relasi ke tabel sertifikat
    public function sertifikats()
    {
        return $this->hasMany(PegawaiSertifikat::class);
    }

    // Relasi ke tabel guru_mapel
    public function mapels()
    {
        return $this->hasMany(GuruMapel::class);
    }

    // Relasi ke tabel guru_detail
    public function guruDetail()
    {
        return $this->hasOne(GuruDetail::class);
    }

    /**
     * Accessor agar bisa ambil array mata_pelajaran[] langsung di Blade
     * Misalnya: old('mata_pelajaran', $pegawai->mata_pelajaran)
     */
    public function getMataPelajaranAttribute()
    {
        return $this->mapels->pluck('mata_pelajaran')->toArray();
    }

    /**
     * Accessor untuk jumlah_hari_mengajar dari tabel guru_details
     */
    public function getJumlahHariMengajarAttribute()
    {
        return $this->guruDetail->jumlah_hari_mengajar ?? null;
    }

    /**
     * Accessor untuk jumlah_kelas_mengajar dari tabel guru_details
     */
    public function getJumlahKelasMengajarAttribute()
    {
        return $this->guruDetail->jumlah_kelas_mengajar ?? null;
    }

    /**
     * Accessor untuk wali_kelas dari tabel guru_details
     */
    public function getWaliKelasAttribute()
    {
        return $this->guruDetail->wali_kelas ?? null;
    }
    public function getJumlahJamAttribute()
    {
        return $this->senin + $this->selasa + $this->rabu + $this->kamis + $this->jumat;
    }

    
}
