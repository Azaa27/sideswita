<?php

namespace App\Livewire\Storefront;

use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.store')]
class Orders extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.storefront.orders', [
            'orders' => Transaction::query()
                ->where('user_id', auth()->id())
                ->withCount('items')
                ->latest()
                ->paginate(10),
        ]);
    }
}
