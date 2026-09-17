<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Curated public YouTube references. These are IDs rather than iframe markup,
     * keeping the database safe and allowing the source to be updated by an admin.
     */
    private const VIDEO_IDS = [
        'PW-01' => 'ODr3OCHB8S8', // Desa Wisata Jalatrang
        'PW-02' => 'rFyVKjtmEpM', // Trekking Jawa Barat
        'PW-03' => 'YUHGb7GkkBM', // Kampung Adat Kuta, Ciamis
        'PW-04' => 'WTNIiRpYSoY', // Wisata sawah
        'PW-05' => '2BboZLvlbqw', // Desa Wisata Jalatrang, Ciamis
        'MD-01' => 'VLhb6vY2Szo', // Kebun kopi Ciamis
        'MD-02' => 'GgxDAUlCrMk', // Gula aren tradisional Jawa Barat
        'MD-03' => 'Vk8zXs90v-s', // Produksi keripik singkong
        'MD-04' => '6XVyZTQqAzU', // Anyaman bambu
        'MD-05' => 'rvty2lMd3LY', // Batik Ciamis
        'MD-06' => 'K3RGVrI26MM', // Madu hutan
        'MD-07' => 'RJtUtecKkZk', // Tas daun pandan
        'MD-08' => 'wTFVNTGEt2E', // Topi pandan
    ];

    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('youtube_video_id', 20)->nullable()->after('image');
        });

        foreach (self::VIDEO_IDS as $code => $videoId) {
            DB::table('products')->where('code', $code)->update(['youtube_video_id' => $videoId]);
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('youtube_video_id');
        });
    }
};
