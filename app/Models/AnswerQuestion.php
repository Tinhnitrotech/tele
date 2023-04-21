<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerQuestion extends Model
{
    use HasFactory;

    protected $table = 'answer_questions';

    protected $fillable = [
        'question_id', 'family_id', 'type', 'answer'
    ];
}
