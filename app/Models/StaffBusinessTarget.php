<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffBusinessTarget extends Model
{
    use HasFactory;
    protected $table = 'staff_business_targets';
    protected $guarded = ["id"];

    public function service(){
    	return $this->hasOne('App\Models\Service','id','service_id');
    }
}
