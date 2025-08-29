<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'exam_id',
        'question_id',
        'option_id',
        'is_correct',
    ];

    // Relasi ke User (Siswa)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relasi ke Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relasi ke Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relasi ke Option
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
