<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinLog extends Model
{
    use HasFactory;

    protected $table = 'join_logs';

    protected $fillable = [
        'family_id', 'prefecture_id', 'place_id', 'status', 'access_datetime'
    ];
}
