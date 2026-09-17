<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeMedia extends Command
{
    protected $signature = 'media:optimize {--width=1400 : Lebar maksimum output WebP} {--quality=82 : Kualitas WebP 0-100}';
    protected $description = 'Convert PNG/JPEG product sources into optimized WebP assets';

    public function handle(): int
    {
        if (! extension_loaded('gd')) { $this->error('Ekstensi PHP GD diperlukan untuk optimasi gambar.'); return self::FAILURE; }
        $sourcePath = public_path('images/source'); $outputPath = public_path('images/products');
        if (! is_dir($sourcePath)) { $this->warn('Folder sumber gambar belum ada: '.$sourcePath); return self::SUCCESS; }
        if (! is_dir($outputPath)) mkdir($outputPath, 0755, true);
        $converted = 0;
        foreach (glob($sourcePath.'/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE) as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $image = in_array($extension, ['jpg','jpeg']) ? @imagecreatefromjpeg($file) : @imagecreatefrompng($file);
            if (! $image) { $this->warn('Tidak dapat membaca '.$file); continue; }
            $width = imagesx($image); $height = imagesy($image); $maxWidth = (int) $this->option('width');
            $newWidth = min($width, $maxWidth); $newHeight = (int) round($height * ($newWidth / $width));
            $canvas = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $target = $outputPath.'/'.pathinfo($file, PATHINFO_FILENAME).'.webp';
            imagewebp($canvas, $target, (int) $this->option('quality'));
            imagedestroy($image); imagedestroy($canvas); $converted++;
        }
        $this->info("{$converted} gambar berhasil dikonversi menjadi WebP.");
        return self::SUCCESS;
    }
}
