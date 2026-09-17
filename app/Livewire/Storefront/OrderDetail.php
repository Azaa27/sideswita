<?php

namespace App\Livewire\Storefront;

use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.store')]
class OrderDetail extends Component
{
    public Transaction $transaction;

    public function mount(Transaction $transaction): void
    {
        abort_unless($transaction->user_id === auth()->id(), 403);
        $this->transaction = $transaction->load('items.product.category');
    }

    public function render()
    {
        return view('livewire.storefront.order-detail');
    }
}
