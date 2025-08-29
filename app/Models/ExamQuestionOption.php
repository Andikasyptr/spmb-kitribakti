<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestionOption extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi Laravel)
    protected $table = 'exam_question_options';

    // Mass assignable fields
   protected $fillable = [
        'exam_question_id',
        'option_label',
        'option_text',
        'is_correct',
        'image_path',
    ];

     protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Relasi ke soal (ExamQuestion)
     */
    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'exam_question_id');
    }
}
