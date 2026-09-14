<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AppRelease extends Model
{
    protected $fillable = [
        'app_name',
        'name',
        'version',
        'release_code',
        'changelog',
        'tagline',
        'apk_path',
        'apk_original_name',
        'apk_size',
        'icon_path',
        'is_active',
        'force_update',
    ];

    protected $casts = [
        'release_code' => 'integer',
        'apk_size' => 'integer',
        'is_active' => 'boolean',
        'force_update' => 'boolean',
    ];

    /**
     * Normalise the lookup key: lowercase, spaces/dashes -> underscore.
     */
    public static function normalizeKey(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '_', $value);
        return trim($value, '_');
    }

    public function getDownloadUrlAttribute(): ?string
    {
        if (! $this->apk_path) {
            return null;
        }

        return route('apk.download.app', ['appName' => $this->app_name]);
    }

    /**
     * Public-facing file name, e.g. "AutoLikerLive_7.apk".
     * Only used for the download response — the stored file keeps its internal name.
     */
    public function getDownloadFilenameAttribute(): string
    {
        $base = str_replace(' ', '', $this->name ?? '');
        $base = preg_replace('/[^A-Za-z0-9._-]+/', '', $base);
        if (! $base) {
            $base = $this->app_name;
        }

        return $base . '_' . (int) $this->release_code . '.apk';
    }

    /**
     * Web-accessible icon URL (or null when no icon uploaded).
     */
    public function getIconUrlAttribute(): ?string
    {
        if (! $this->icon_path) {
            return null;
        }

        return Storage::disk('public')->url($this->icon_path);
    }

    public function toApiArray(): array
    {
        return [
            'app_name' => $this->app_name,
            'name' => $this->name,
            'version' => $this->version,
            'release_code' => (int) $this->release_code,
            // aliases — different app versions use different keys
            'build' => $this->version,
            'version_code' => (int) $this->release_code,
            'update' => $this->updated_at?->format('d M, Y'),
            'changelog' => $this->changelog,
            'tagline' => $this->tagline,
            'force_update' => (bool) $this->force_update,
            'is_active' => (bool) $this->is_active,
            'apk_file' => $this->apk_original_name,
            'apk_size' => $this->apk_size,
            'icon_url' => $this->icon_url,
            'download_filename' => $this->download_filename,
            'link' => $this->apk_original_name,
            'download_url' => $this->download_url,
        ];
    }
}
