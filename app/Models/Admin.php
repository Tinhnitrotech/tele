<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'admins';

    /**
     * @var string
     */
    protected $guarded = 'admin';

    /**
     * @var array
     */
    protected $fillable = ['name', 'name_kana', 'email', 'image', 'password', 'birthday', 'gender', 'first_login'];

}
