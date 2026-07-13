<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    public function loadOverlay($source): ?\Intervention\Image\Image
    {
        if (empty($source)) return null;

        if (filter_var($source, FILTER_VALIDATE_URL)) {
            $path = parse_url($source, PHP_URL_PATH);
            if (str_starts_with($path, '/storage/')) {
                $relativePath = preg_replace('#^/storage/#', '', $path);
                $localPath = storage_path('app/public/' . $relativePath);
                if (file_exists($localPath)) {
                    return Image::read($localPath);
                }
            }

            $tempDir = storage_path('app/public/game_temp');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            $tempFile = $tempDir . '/' . md5($source) . '.tmp';

            if (!file_exists($tempFile)) {
                $ch = curl_init($source);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_TIMEOUT        => 5,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                ]);
                $data = curl_exec($ch);
                curl_close($ch);

                if ($data === false || strlen($data) < 100) return null;
                file_put_contents($tempFile, $data);
            }

            return Image::read($tempFile);
        }

        $localPath = storage_path('app/public/' . ltrim($source, '/'));
        if (file_exists($localPath)) {
            return Image::read($localPath);
        }

        return null;
    }
}
