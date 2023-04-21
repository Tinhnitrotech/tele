<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'families';

    /**
     * @var array
     */
    protected $fillable = ['family_code', 'place_id', 'address', 'address_default','zip_code', 'prefecture_id', 'tel', 'join_date', 'out_date', 'note', 'password', 'is_public', 'public_info', 'language_register', 'qr_code'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function person()
    {
        return $this->hasMany(Person::class)->orderBy('is_owner');
    }
}
