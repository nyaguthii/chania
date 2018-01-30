<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    public function policy(){
    	
    	return $this->belongsTo(Policy::class);
    }
}
