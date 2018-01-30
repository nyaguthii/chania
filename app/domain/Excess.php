<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Excess extends Model
{
    public function claim(){
    	return $this->belongsTo(Claim::class);
    }
}
