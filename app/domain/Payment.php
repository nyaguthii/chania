<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function paymentSchedule(){

    	return $this->belongsTo(PaymentSchedule::class);
    }
    public function receipt(){
    	return $this->hasOne(Receipt::class);
    }

    
}
