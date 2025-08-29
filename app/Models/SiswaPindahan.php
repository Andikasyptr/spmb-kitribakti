<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaPindahan extends Model
{
    use HasFactory;

    protected $table = 'siswa_pindahan'; // nama tabel di database

    protected $guarded = []; // semua kolom bisa diisi secara massal

    public function kelas()
{
    return $this->belongsTo(Kelas::class);
}

}
