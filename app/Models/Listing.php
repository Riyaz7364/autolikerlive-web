<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'listings';
    public $timestamps = false;

    protected $fillable = ['name', 'post_id', 'type'];
}
