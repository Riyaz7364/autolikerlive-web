<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatBlock extends Model
{
    protected $fillable = ['ip', 'guest_token', 'reason'];
}
