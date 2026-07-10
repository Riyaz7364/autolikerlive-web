<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'username',
        'profile_pic',
        'dob',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($session) {
            if (!$session->username) {
                $session->username = static::generateUniqueUsername($session->name ?? 'user');
            }
        });
    }

    private static function generateUniqueUsername(string $name): string
    {
        $base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        if (strlen($base) < 3) $base .= 'user';

        $username = $base;
        $suffix = 1;
        while (static::where('username', $username)->exists()) {
            $suffix++;
            $username = $base . $suffix;
        }
        return $username;
    }
}
