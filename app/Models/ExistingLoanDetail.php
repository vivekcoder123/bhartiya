<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ExistingLoanDetail extends Model
{
    use HasFactory;

    protected $table = 'existing_loan_details';
    protected $guarded = ["id"];

    public function getCreatedAtAttribute($value){
    	return Carbon::parse($value)->format("j M Y");
    }

    
}
