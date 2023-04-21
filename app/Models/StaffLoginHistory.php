<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLoginHistory extends Model
{
    use HasFactory;

    protected $table = 'staff_login_histories';

    protected $fillable = [
        'user_id', 'place_id', 'login_datetime',
    ];
}
