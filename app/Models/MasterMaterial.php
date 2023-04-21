<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'm_supplies';

    protected $dates = ['deleted_at'];

    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['name', 'unit'];

    public function setIncrement($value)
    {
        $this->incrementing = $value;
    }
}
