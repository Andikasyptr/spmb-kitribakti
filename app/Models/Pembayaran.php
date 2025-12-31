<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Siswa;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'nisn',
        'bukti_pembayaran',
        'nominal',
        'status',
    ];

    /**
     * Relasi ke tabel users
     * Setiap pembayaran dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel siswas
     * Setiap pembayaran terhubung ke satu siswa (melalui user_id)
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'user_id', 'user_id');
    }
}
