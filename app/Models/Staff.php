<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    const SINGLE = "S";
    const MARRIED = "M";

    protected $table = 'staff';
    protected $guarded = ["id"];
    const PERMISSIONS = ['Services','Staffs','Users','Clients'];

    public function designation(){
    	return $this->hasOne('App\Models\Designation','id','designation_id');
    }

    public function reportTo(){
    	return $this->hasOne('App\Models\Staff','id','report_to_id');
    }

    public function location(){
    	return $this->hasOne('App\Models\Location','id','location_id');
    }

    public function services(){
    	return $this->belongsToMany('App\Models\Service','staff_services','staff_id','service_id');
    }

    public function incentives(){
    	return $this->hasMany('App\Models\StaffIncentive','staff_id','id');
    }

    public function targets(){
    	return $this->hasMany('App\Models\StaffBusinessTarget','staff_id','id');
    }

}
