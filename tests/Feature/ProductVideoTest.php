<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductVideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_normalizes_supported_youtube_urls_and_rejects_other_hosts(): void
    {
        $videoId = 'dQw4w9WgXcQ';

        $this->assertSame($videoId, Product::normalizeYoutubeVideoId($videoId));
        $this->assertSame($videoId, Product::normalizeYoutubeVideoId("https://www.youtube.com/watch?v={$videoId}"));
        $this->assertSame($videoId, Product::normalizeYoutubeVideoId("https://youtu.be/{$videoId}"));
        $this->assertSame($videoId, Product::normalizeYoutubeVideoId("https://www.youtube-nocookie.com/embed/{$videoId}"));
        $this->assertNull(Product::normalizeYoutubeVideoId("https://example.test/embed/{$videoId}"));
    }

    public function test_product_detail_exposes_a_lazy_privacy_enhanced_video_player(): void
    {
        $category = Category::create(['name' => 'Paket Wisata', 'slug' => 'paket-wisata']);
        $product = Product::create([
            'category_id' => $category->id,
            'code' => 'PW-99',
            'name' => 'Produk Uji Video',
            'slug' => 'pw-99-produk-uji-video',
            'description' => 'Produk untuk pengujian video.',
            'price' => 10000,
            'stock' => 10,
            'image' => 'images/hero-jalatrang.webp',
            'youtube_video_id' => 'dQw4w9WgXcQ',
            'is_active' => true,
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Video pendukung')
            ->assertSee('youtube-nocookie.com/embed/dQw4w9WgXcQ', false)
            ->assertSee('Putar video');
    }

    public function test_the_fresh_demo_catalog_has_a_video_for_every_seeded_product(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(13, Product::count());
        $this->assertSame(13, Product::whereNotNull('youtube_video_id')->count());
    }
}
