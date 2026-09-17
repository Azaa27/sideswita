<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateProductAssets extends Command
{
    protected $signature = 'media:generate-product-assets';
    protected $description = 'Generate local visual source assets then optimize them to WebP';

    public function handle(): int
    {
        if (! extension_loaded('gd')) { $this->error('Ekstensi PHP GD diperlukan untuk menghasilkan gambar.'); return self::FAILURE; }
        $source = public_path('images/source'); if (! is_dir($source)) mkdir($source, 0755, true);
        $palettes = [
            'pw-01'=>['1b5e48','8dcf8a','f8d66d'], 'pw-02'=>['103b4c','2d7580','b5e48c'], 'pw-03'=>['542a46','c76b75','f5c16c'], 'pw-04'=>['476b48','a5c984','e8c77d'], 'pw-05'=>['1e4d61','4f9da6','f4d35e'],
            'md-01'=>['38220f','8b5e34','d8ad67'], 'md-02'=>['6b3f1d','b77939','efc276'], 'md-03'=>['b14d2f','e97b4b','f3c46b'], 'md-04'=>['755037','b28a5c','e7c892'], 'md-05'=>['294d75','5a86b3','e0b05b'], 'md-06'=>['b57220','e4a43c','f5df91'], 'md-07'=>['5b6d3b','9ab36e','e1db9b'], 'md-08'=>['48624a','83a05a','e4d59b'], 'hero-jalatrang'=>['073d35','1d7660','e2be68'],
        ];
        foreach ($palettes as $name => $palette) $this->makeArtwork($source.'/'.$name.'.png', $palette);
        $this->call('media:optimize', ['--width'=>1400, '--quality'=>82]);
        copy(public_path('images/products/hero-jalatrang.webp'), public_path('images/hero-jalatrang.webp'));
        $this->info('Visual asset Jalatrang berhasil dibuat.');
        return self::SUCCESS;
    }

    private function makeArtwork(string $file, array $palette): void
    {
        [$width, $height] = [1400, 900]; $img = imagecreatetruecolor($width, $height);
        $start = $this->rgb($palette[0]); $end = $this->rgb($palette[1]);
        for ($y=0; $y<$height; $y++) { $ratio=$y/$height; $r=(int)($start[0]*(1-$ratio)+$end[0]*$ratio); $g=(int)($start[1]*(1-$ratio)+$end[1]*$ratio); $b=(int)($start[2]*(1-$ratio)+$end[2]*$ratio); imageline($img,0,$y,$width,$y,imagecolorallocate($img,$r,$g,$b)); }
        $accent=$this->rgb($palette[2]); $a=imagecolorallocatealpha($img,$accent[0],$accent[1],$accent[2],55); $light=imagecolorallocatealpha($img,255,255,255,95);
        imagefilledellipse($img,1100,80,700,700,$a); imagefilledellipse($img,180,820,800,430,$a);
        for($i=0;$i<5;$i++) { $offset=$i*120; imagefilledarc($img,650,$height+80-$offset,1700,690,190,350,$light,IMG_ARC_PIE); }
        imagepng($img,$file,6); imagedestroy($img);
    }
    private function rgb(string $hex): array { return [hexdec(substr($hex,0,2)),hexdec(substr($hex,2,2)),hexdec(substr($hex,4,2))]; }
}
