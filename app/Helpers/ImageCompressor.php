<?php

namespace App\Helpers;

class ImageCompressor
{
    public static function resizeAndCompress($sourcePath, $destinationPath, $maxWidth = 1280, $maxSizeKB = 200){
        list($width, $height, $type) = getimagesize($sourcePath);

        // Create source image
        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($sourcePath);
                break;

            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($sourcePath);

                // Remove transparency (white background)
                $noAlpha = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($noAlpha, 255, 255, 255);
                imagefilledrectangle($noAlpha, 0, 0, $width, $height, $white);
                imagecopy($noAlpha, $src, 0, 0, 0, 0, $width, $height);

                $src = $noAlpha;
                break;

            default:
                return false;
        }

        // -----------------------------
        // 1. RESIZE TO MAX WIDTH
        // -----------------------------
        if ($width > $maxWidth) {
            $ratio = $maxWidth / $width;
            $newWidth = $maxWidth;
            $newHeight = round($height * $ratio);
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // -----------------------------
        // 2. COMPRESS UNTIL TARGET SIZE
        // -----------------------------
        $tempFile = $destinationPath . '.tmp';
        $quality = 90;

        while ($quality >= 10) {

            // Save temporary compressed version
            imagejpeg($resized, $tempFile, $quality);

            // Check size
            $fileSizeKB = filesize($tempFile) / 1024;

            if ($fileSizeKB <= $maxSizeKB) {
                // Final save
                imagejpeg($resized, $destinationPath, $quality);
                unlink($tempFile);
                imagedestroy($src);
                imagedestroy($resized);
                return true;
            }

            // Reduce quality by 5%
            $quality -= 5;
        }

        // Save with last possible quality
        imagejpeg($resized, $destinationPath, 10);
        unlink($tempFile);

        imagedestroy($src);
        imagedestroy($resized);

        return true;
    }
}
