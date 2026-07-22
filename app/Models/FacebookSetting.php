<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookSetting extends Model
{
    protected $connection = 'mysql';
    protected $table = 'facebook_settings';
    public $timestamps = false;

    protected $fillable = ['lsd', 'fb_cookie'];
}
