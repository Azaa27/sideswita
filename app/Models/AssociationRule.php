<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AssociationRule extends Model { protected $fillable=['antecedent_product_id','consequent_product_id','support','confidence','lift_ratio','is_active']; public function antecedent(){return $this->belongsTo(Product::class,'antecedent_product_id');} public function consequent(){return $this->belongsTo(Product::class,'consequent_product_id');} }
