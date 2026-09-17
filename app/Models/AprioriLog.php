<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AprioriLog extends Model { protected $fillable=['triggered_by','triggered_by_user_id','total_transactions','total_frequent_itemsets','total_rules_generated','execution_time_ms','status','error_message']; }
