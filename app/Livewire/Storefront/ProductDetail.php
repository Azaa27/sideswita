<?php
namespace App\Livewire\Storefront;
use App\Models\CartItem; use App\Models\Product; use App\Services\RecommendationService; use Livewire\Attributes\Layout; use Livewire\Component;
#[Layout('layouts.store')]
class ProductDetail extends Component { public Product $product; public int $quantity=1; public function mount(Product $product){ abort_unless($product->is_active, 404); $this->product=$product;} public function add(){ abort_unless(auth()->check(),403); $item=CartItem::firstOrNew(['user_id'=>auth()->id(),'product_id'=>$this->product->id]); $item->quantity=($item->exists?$item->quantity:0)+$this->quantity; $item->save(); $this->dispatch('cart-updated'); $this->dispatch('toast', type: 'success', message: 'Produk ditambahkan ke keranjang.'); } public function render(RecommendationService $recommendations){ return view('livewire.storefront.product-detail',['recommendations'=>$recommendations->forProductIds([$this->product->id])]); } }
