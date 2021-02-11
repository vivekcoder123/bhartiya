<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StaffIncentive extends Model
{
    use HasFactory;
    protected $table = 'staff_incentives';
    protected $guarded = ["id"];

    public function getCreatedAtAttribute($value){
    	return Carbon::parse($value)->format("j M Y");
    }
}
