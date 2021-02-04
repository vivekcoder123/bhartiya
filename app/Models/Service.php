<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    public function banks(){
        return $this->belongsToMany(
            Bank::class,
            'service_banks',
            'service_id',
            'bank_id'
        );
    }
    public function fields(){
        return $this->belongsToMany(
            ServiceFormAttribute::class,
            'serviceform_fields',
            'service_id',
            'service_form_attribute_id'
        );
    }
}
