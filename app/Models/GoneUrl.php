<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoneUrl extends Model
{
    protected $fillable = ['path', 'note'];

    public static function normalize(string $path): string
    {
        return strtolower(trim($path, '/'));
    }

    public static function isGone(string $path): bool
    {
        $path = self::normalize($path);
        if ($path === '') {
            return false;
        }

        return self::where('path', $path)->exists();
    }

    public static function record(string $path, ?string $note = null): void
    {
        $path = self::normalize($path);
        if ($path === '') {
            return;
        }

        self::firstOrCreate(['path' => $path], ['note' => $note]);
    }
}
