<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapel_id',
        'title',
        'description',
        'duration',
        'total_questions',
        'kelas',
        'user_id',
        'teacher_id',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Pegawai::class, 'teacher_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }

}
