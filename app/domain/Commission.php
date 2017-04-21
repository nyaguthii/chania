<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    public function endorsement(){

    	return $this->belongsTo(Endorsement::class);
    }

    public function payments(){

    	return $this->hasMany(CommissionPayment::class);
    }
}
