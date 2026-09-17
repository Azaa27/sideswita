<?php
namespace App\Services;
use App\Models\AssociationRule;
use App\Models\Product;
class RecommendationService { public function forProductIds(array $ids, int $limit=4) { $ids=array_unique($ids); $recommended=AssociationRule::query()->where('is_active',true)->whereIn('antecedent_product_id',$ids)->whereNotIn('consequent_product_id',$ids)->with('consequent.category')->orderByDesc('lift_ratio')->get()->pluck('consequent')->unique('id')->take($limit); return $recommended->isNotEmpty() ? $recommended : Product::query()->where('is_active',true)->whereNotIn('id',$ids)->orderByDesc('stock')->with('category')->take($limit)->get(); } }
