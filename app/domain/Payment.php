<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    
    public function receipt(){
    	return $this->hasOne(Receipt::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    
    /*public function paymentSchedule(){

    	return $this->belongsTo(PaymentSchedule::class);
    }
    
    public function credit(){
    	return $this->hasOne(Credit::class);
    }

    public function vehicleCredit(){
    	return $this->hasOne(VehicleCredit::class);
    }*/
}
