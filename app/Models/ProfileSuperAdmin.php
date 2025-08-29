<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProfileSuperadmin extends Model
{
    use HasFactory;

    protected $table = 'profile_superadmin';

    protected $fillable = [
        'user_id',
        'email',
        'foto',
        'alamat',
        'nik',
        'no_hp',
    ];

    /**
     * Relasi ke model User (setiap profile_superadmin dimiliki oleh satu user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
