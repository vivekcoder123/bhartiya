<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corporate extends Model
{
    use HasFactory;
    protected $table = 'corporate';
    protected $guarded = "id";
    
    public function location(){
        return $this->hasOne('App\Models\Location','id','location_id');
    }

}
