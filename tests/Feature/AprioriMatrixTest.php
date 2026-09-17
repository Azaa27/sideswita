<?php

namespace Tests\Feature;

use App\Livewire\Admin\Apriori;
use App\Models\AprioriConfig;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AprioriMatrixTest extends TestCase
{
    use RefreshDatabase;

    public function test_matrix_only_shows_completed_transactions_as_binary_rows(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Paket Wisata', 'slug' => 'paket-wisata']);
        $firstProduct = Product::create([
            'category_id' => $category->id,
            'code' => 'PW-01',
            'name' => 'Edukasi Pertanian',
            'slug' => 'pw-01-edukasi-pertanian',
            'price' => 75000,
            'stock' => 10,
            'image' => 'images/hero-jalatrang.webp',
            'is_active' => true,
        ]);
        $secondProduct = Product::create([
            'category_id' => $category->id,
            'code' => 'PW-02',
            'name' => 'Alam Trekking',
            'slug' => 'pw-02-alam-trekking',
            'price' => 85000,
            'stock' => 10,
            'image' => 'images/hero-jalatrang.webp',
            'is_active' => true,
        ]);
        AprioriConfig::create(['min_support' => .10, 'min_confidence' => .60]);

        $completed = Transaction::create([
            'user_id' => $user->id,
            'transaction_code' => 'DONE-01',
            'visitor_name' => 'Pengunjung Selesai',
            'visit_date' => now()->toDateString(),
            'total_price' => 75000,
            'status' => 'completed',
        ]);
        $completed->items()->create(['product_id' => $firstProduct->id, 'quantity' => 2, 'price' => 75000, 'subtotal' => 150000]);

        $pending = Transaction::create([
            'user_id' => $user->id,
            'transaction_code' => 'PENDING-01',
            'visitor_name' => 'Pengunjung Pending',
            'visit_date' => now()->toDateString(),
            'total_price' => 85000,
            'status' => 'pending',
        ]);
        $pending->items()->create(['product_id' => $secondProduct->id, 'quantity' => 1, 'price' => 85000, 'subtotal' => 85000]);

        Livewire::test(Apriori::class)
            ->call('toggleMatrix')
            ->assertSee('Matriks transaksi biner')
            ->assertSee('DONE-01')
            ->assertDontSee('PENDING-01')
            ->assertSee('PW-01')
            ->assertSee('PW-02');
    }
}
