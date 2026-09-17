<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model { protected $fillable=['user_id','transaction_code','visitor_name','visit_date','notes','total_price','status','cancelled_reason']; protected function casts():array{return ['visit_date'=>'date','total_price'=>'decimal:2'];} public function user(){return $this->belongsTo(User::class);} public function items(){return $this->hasMany(TransactionItem::class);} }
