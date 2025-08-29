<?php

// app/Models/ExamQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
   protected $fillable = [
        'exam_id',
        'question_text',
        'point',
        'question_type',
        'image_path', // tambahkan ini
    ];


  public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function options()
    {
        return $this->hasMany(ExamQuestionOption::class, 'exam_question_id');
    }
}

