<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiSk extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'nama_file',
        'path_file',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
