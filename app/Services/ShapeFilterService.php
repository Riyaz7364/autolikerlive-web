<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;

class ShapeFilterService
{
    public function apply(\Intervention\Image\Image $image, string $filter): \Intervention\Image\Image
    {
        if ($filter !== 'circle') return $image;

        $tempDir = storage_path('app/public/game_temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $inputFile  = $tempDir . '/temp_' . uniqid() . '.png';
        $outputFile = $tempDir . '/circle_' . uniqid() . '.png';

        $image->save($inputFile);
        $this->makeCircularImage($inputFile, $outputFile, min($image->width(), $image->height()));
        $result = Image::read($outputFile);

        @unlink($inputFile);
        @unlink($outputFile);

        return $result;
    }

    public function makeCircularImage($input, $output, $size = 500)
    {
        $info = getimagesize($input);
        if (!$info) throw new \Exception('Could not read image for circle filter.');

        switch ($info['mime']) {
            case 'image/jpeg': $src = imagecreatefromjpeg($input); break;
            case 'image/png':  $src = imagecreatefrompng($input);  break;
            case 'image/webp': $src = imagecreatefromwebp($input); break;
            case 'image/gif':  $src = imagecreatefromgif($input);  break;
            default: throw new \Exception('Unsupported image type for circle filter.');
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);
        $crop = min($srcW, $srcH);
        $srcX = (int)(($srcW - $crop) / 2);
        $srcY = (int)(($srcH - $crop) / 2);

        $dst = imagecreatetruecolor($size, $size);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
        imagefill($dst, 0, 0, $transparent);

        imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $size, $size, $crop, $crop);

        $radius = $size / 2;
        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $dx = $x - $radius;
                $dy = $y - $radius;
                if (($dx * $dx + $dy * $dy) > ($radius * $radius)) {
                    imagesetpixel($dst, $x, $y, $transparent);
                }
            }
        }

        imagepng($dst, $output);
        imagedestroy($src);
        imagedestroy($dst);
    }
}
