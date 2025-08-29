<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
    ];

    public function siswas()
{
    return $this->hasMany(\App\Models\Siswa::class, 'kelas_id');
}

    public function exams()
    {
        return $this->hasMany(Exam::class, 'kelas_id');
    }

}