<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    use HasFactory;

    protected $fillable = ['pegawai_id', 'mata_pelajaran'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
