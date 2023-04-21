<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioAnswer extends Model
{
    use HasFactory;

    protected $table = 'radio_answers';

    protected $fillable = [
        'question_id', 'option',
    ];

}
