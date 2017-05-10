<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    public function policy(){

    	return $this->belongsTo(Policy::class);
    }
}
