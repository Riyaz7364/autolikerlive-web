<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoLead extends Model
{
    protected $table = 'demo_leads';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'project_type',
        'budget',
        'message',
        'source',
        'status',
        'ip_address',
        'user_agent',
    ];
}
