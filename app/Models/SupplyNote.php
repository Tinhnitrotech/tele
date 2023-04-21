<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyNote extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'supply_notes';

    /**
     * @var array
     */
    protected $fillable = ['place_id', 'comment', 'note'];
}
