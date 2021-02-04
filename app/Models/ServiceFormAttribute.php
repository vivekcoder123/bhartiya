<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFormAttribute extends Model
{
    use HasFactory;
    public function attribute_type(){
        return $this->hasOne(AttributeType::class,'id','attribute_type_id');
    }
}
