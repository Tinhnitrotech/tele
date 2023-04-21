<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supply extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'supplies';

    protected $dates = ['deleted_at'];

    protected $fillable = ['place_id', 'm_supply_id', 'number'];

    /**
     * Relationships MasterMaterial
     */
    public function masterMaterial()
    {
        return $this->hasOne(MasterMaterial::class);
    }
}
