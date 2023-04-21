<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SystemSetting extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'setting_systems';

    /**
     * @var array
     */
    protected $fillable = ['system_name_ja', 'system_name_en', 'type_name_ja', 'type_name_en', 'disclosure_info_ja', 'disclosure_info_en', 'footer', 'map_scale', 'latitude', 'longitude'];

}
