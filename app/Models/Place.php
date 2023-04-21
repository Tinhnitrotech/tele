<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Place extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'places';

    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tel',
        'zip_code',
        'prefecture_id',
        'address',
        'zip_code_default',
        'prefecture_id_default',
        'address_default',
        'total_place',
        'active_flg',
        'full_status',
        'name_en',
        'prefecture_en_id',
        'address_en',
        'prefecture_default_en_id',
        'address_default_en',
        'altitude'
    ];


    public function setIncrement($value)
    {
        $this->incrementing = $value;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function family()
    {
        return $this->hasMany(Family::class);
    }

    public function person()
    {
        return $this->hasManyThrough(Person::class, Family::class);
    }

    public function map()
    {
        return $this->hasOne(Map::class);
    }

    public function supplies()
    { return $this->belongsToMany(MasterMaterial::class, 'supplies','place_id','m_supply_id')
        ->select('place_id','m_supply_id','number');
    }

    public function supplyNote()
    { return $this->hasOne(SupplyNote::class,'place_id','id');
    }
}
