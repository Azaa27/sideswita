<?php
namespace App\Livewire\Admin;
use App\Models\AprioriLog; use App\Models\AssociationRule; use App\Models\Product; use App\Models\Transaction; use Livewire\Attributes\Layout; use Livewire\Component;
#[Layout('layouts.store')]
class Dashboard extends Component { public function render(){return view('livewire.admin.dashboard',['productCount'=>Product::count(),'orderCount'=>Transaction::count(),'pendingCount'=>Transaction::where('status','pending')->count(),'revenue'=>Transaction::whereIn('status',['confirmed','completed'])->sum('total_price'),'ruleCount'=>AssociationRule::count(),'latestLog'=>AprioriLog::latest()->first()]);} }
