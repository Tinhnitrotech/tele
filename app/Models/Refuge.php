<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refuge extends Model
{
    use HasFactory;

    protected $table = 'places';

    public function staffs()
    {
        return $this->belongsToMany(User::class,'staff_login_histories','place_id','user_id');
    }
}
