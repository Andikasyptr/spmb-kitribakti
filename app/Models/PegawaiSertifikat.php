<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiSertifikat extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'nama_sertifikat',
        'path_file',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
