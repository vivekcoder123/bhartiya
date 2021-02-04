<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceformField extends Model
{
    use HasFactory;
    public function attribute(){
        return $this->hasOne('App/Models/ServiceFormAttribute','id','attribute_type_id');
    }
}
