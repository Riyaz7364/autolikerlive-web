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

    protected static function booted(): void
    {
        $flush = function () {
            \Illuminate\Support\Facades\Cache::forget('listings_all_mini');
            \Illuminate\Support\Facades\Cache::forget('homepage_linked_posts_v1');
        };
        static::saved($flush);
        static::deleted($flush);
    }
}
