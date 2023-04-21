<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'persons';

    /**
     * @var array
     */
    protected $fillable = ['family_id', 'name', 'age', 'gender', 'option', 'note', 'is_owner', 'is_infant'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
