<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AprioriConfig extends Model { protected $fillable=['min_support','min_confidence','schedule_enabled','schedule_interval_hours','last_calculated_at','total_rules_last_run']; protected function casts():array{return ['schedule_enabled'=>'boolean','last_calculated_at'=>'datetime'];} }
