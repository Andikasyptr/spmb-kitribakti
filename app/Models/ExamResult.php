<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', // ID siswa
        'exam_id',
        'score'
    ];

    // Relasi ke user (untuk nama)
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    // Relasi ke siswa (untuk kelas)
    public function student()
    {
        return $this->belongsTo(Siswa::class, 'student_id', 'id'); 
        // asumsinya Siswa.user_id mengacu ke users.id
    }
}
