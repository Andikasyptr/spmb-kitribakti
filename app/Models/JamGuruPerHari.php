<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamGuruPerHari extends Model
{
    protected $table = 'jamguru_perhari';

    protected $fillable = [
        'pegawai_id', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'minggu_ke', 'tahun',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
