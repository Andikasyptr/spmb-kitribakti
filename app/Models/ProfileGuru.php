<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProfileGuru extends Model
{
    use HasFactory;

    protected $table = 'profile_guru';

    protected $fillable = [
        'user_id',
        'email',
        'foto',
        'alamat',
        'nik',
        'no_hp',
    ];

    /**
     * Relasi ke model User (setiap profile_guru dimiliki oleh satu user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
