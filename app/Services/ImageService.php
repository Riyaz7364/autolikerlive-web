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
                    return $this->readImage($localPath);
                }
            }

            $isSvg = str_ends_with(strtolower($path), '.svg') || str_contains($source, 'iconify');

            $tempDir = storage_path('app/public/game_temp');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $ext = $isSvg ? '.svg' : '.tmp';
            $tempFile = $tempDir . '/' . md5($source) . $ext;

            if (!file_exists($tempFile)) {
                $ch = curl_init($source);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_TIMEOUT        => 10,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                ]);
                $data = curl_exec($ch);
                curl_close($ch);

                if ($data === false || strlen($data) < 10) return null;
                file_put_contents($tempFile, $data);
            }

            if ($isSvg && extension_loaded('imagick')) {
                $pngFile = $tempDir . '/' . md5($source) . '.png';
                if (!file_exists($pngFile)) {
                    $configPath = 'C:\\tools\\php84\\config_imagemagick';
                    if (!is_dir($configPath)) {
                        $configPath = 'C:\\xampp\\php\\config_imagemagick';
                    }
                    if (is_dir($configPath)) {
                        putenv("MAGICK_CONFIGURE_PATH={$configPath}");
                    }
                    $imagick = new \Imagick();
                    $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
                    $imagick->readImage($tempFile);
                    $imagick->setImageFormat('png32');
                    $imagick->resizeImage(256, 256, \Imagick::FILTER_LANCZOS, 1);
                    $imagick->writeImage($pngFile);
                    $imagick->clear();
                }
                return Image::read($pngFile);
            }

            return $this->readImage($tempFile);
        }

        $localPath = storage_path('app/public/' . ltrim($source, '/'));
        if (file_exists($localPath)) {
            return $this->readImage($localPath);
        }

        return null;
    }

    protected function readImage(string $path): ?\Intervention\Image\Image
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($ext === 'svg' && extension_loaded('imagick')) {
            $pngFile = storage_path('app/public/game_temp') . '/' . md5($path) . '.png';
            if (!file_exists($pngFile)) {
                $configPath = 'C:\\tools\\php84\\config_imagemagick';
                if (!is_dir($configPath)) {
                    $configPath = 'C:\\xampp\\php\\config_imagemagick';
                }
                if (is_dir($configPath)) {
                    putenv("MAGICK_CONFIGURE_PATH={$configPath}");
                }
                $imagick = new \Imagick();
                $imagick->setBackgroundColor(new \ImagickPixel('transparent'));
                $imagick->readImage($path);
                $imagick->setImageFormat('png32');
                $imagick->resizeImage(256, 256, \Imagick::FILTER_LANCZOS, 1);
                $imagick->writeImage($pngFile);
                $imagick->clear();
            }
            return Image::read($pngFile);
        }

        return Image::read($path);
    }
}
