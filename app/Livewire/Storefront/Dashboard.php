<?php

namespace App\Livewire\Storefront;

use App\Models\CartItem;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $orders = Transaction::query()->where('user_id', auth()->id());

        return view('livewire.storefront.dashboard', [
            'cartCount' => CartItem::where('user_id', auth()->id())->sum('quantity'),
            'pendingCount' => (clone $orders)->where('status', 'pending')->count(),
            'orderCount' => (clone $orders)->count(),
            'latestOrder' => $orders->latest()->first(),
        ]);
    }
}
