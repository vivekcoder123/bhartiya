<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessTarget extends Model
{
    use HasFactory;
    protected $table = 'business_targets';
    protected $guarded = ["id"];
}
