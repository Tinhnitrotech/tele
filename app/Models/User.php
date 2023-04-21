<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $guarded = 'staff';

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'image', 'password', 'birthday', 'first_login', 'address','tel','prefecture_id','zip_code'];

    public function places()
    {
        return $this->belongsToMany(Refuge::class, 'staff_login_histories', 'user_id', 'place_id')
            ->select(['places.name', 'staff_login_histories.login_datetime'])
            ->where('deleted_at', '=' , null)
            ->orderBy('staff_login_histories.login_datetime','desc');
    }
}
