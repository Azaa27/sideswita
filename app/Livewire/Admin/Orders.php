<?php
namespace App\Livewire\Admin;
use App\Models\Transaction; use Livewire\Attributes\Layout; use Livewire\Component;
#[Layout('layouts.store')]
class Orders extends Component { public function updateStatus(int $id,string $status){abort_unless(in_array($status,['pending','confirmed','completed','cancelled']),422);Transaction::findOrFail($id)->update(['status'=>$status]);$this->dispatch('toast', type: 'success', message: 'Status pesanan diperbarui.');} public function render(){return view('livewire.admin.orders',['orders'=>Transaction::with(['user','items.product'])->latest()->paginate(15)]);} }
