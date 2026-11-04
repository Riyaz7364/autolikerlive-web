<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdSetting extends Model
{
    protected $connection = 'mysql';

    protected $table = 'ad_settings';

    public $timestamps = false;

    protected $fillable = ['key', 'value'];
}
