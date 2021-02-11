<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StaffBusinessTarget extends Model
{
    use HasFactory;
    protected $table = 'staff_business_targets';
    protected $guarded = ["id"];

    public function getCreatedAtAttribute($value){
    	return Carbon::parse($value)->format("j M Y");
    }

    public function service(){
    	return $this->hasOne('App\Models\Service','id','service_id');
    }

    public function business_target(){
    	return $this->hasOne('App\Models\BusinessTarget','id','business_target_id');
    }
}
