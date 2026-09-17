<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Storefront\Catalog;
use App\Livewire\Storefront\Cart;
use App\Livewire\Storefront\Checkout;
use App\Livewire\Storefront\ProductDetail;
use App\Livewire\Storefront\Orders as StorefrontOrders;
use App\Livewire\Storefront\OrderDetail as StorefrontOrderDetail;
use App\Livewire\Storefront\Dashboard as StorefrontDashboard;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\Apriori;
use App\Livewire\Admin\OrderDetail as AdminOrderDetail;

Route::view('/', 'welcome')->name('home');
Route::get('/katalog', Catalog::class)->name('catalog');
Route::view('/galeri', 'livewire.storefront.galeri')->name('gallery');
Route::get('/produk/{product:slug}', ProductDetail::class)->name('products.show');
Route::get('/keranjang', Cart::class)->middleware('auth')->name('cart');
Route::get('/checkout', Checkout::class)->middleware('auth')->name('checkout');
Route::get('/pesanan-saya', StorefrontOrders::class)->middleware('auth')->name('orders.index');
Route::get('/pesanan-saya/{transaction}', StorefrontOrderDetail::class)->middleware('auth')->name('orders.show');

Route::get('dashboard', StorefrontDashboard::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/produk', Products::class)->name('products');
    Route::get('/pesanan', Orders::class)->name('orders');
    Route::get('/pesanan/{transaction}', AdminOrderDetail::class)->name('orders.show');
    Route::get('/apriori', Apriori::class)->name('apriori');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
