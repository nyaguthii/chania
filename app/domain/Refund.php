<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public function policy(){

    	return $this->belongsTo(Policy::class);
    }
}
