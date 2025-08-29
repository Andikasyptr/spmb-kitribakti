<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'jumlah_kelas_mengajar',
        'wali_kelas',
        'jumlah_hari_mengajar',
        'jumlah_jam',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
