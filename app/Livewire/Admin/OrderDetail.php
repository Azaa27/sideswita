<?php

namespace App\Livewire\Admin;

use App\Models\Transaction;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.store')]
class OrderDetail extends Component
{
    public Transaction $transaction;

    public function mount(Transaction $transaction): void
    {
        $this->transaction = $transaction->load('user', 'items.product.category');
    }

    public function updateStatus(string $status): void
    {
        abort_unless(in_array($status, ['pending', 'confirmed', 'completed', 'cancelled']), 422);
        $this->transaction->update(['status' => $status]);
        $this->transaction->refresh();
        $this->dispatch('toast', type: 'success', message: 'Status pesanan diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.order-detail');
    }
}
