<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TransactionItem extends Model { protected $fillable=['product_id','quantity','price','subtotal']; public function product(){return $this->belongsTo(Product::class);} public function transaction(){return $this->belongsTo(Transaction::class);} }
