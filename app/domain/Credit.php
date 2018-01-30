<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    public function customer(){

    	return $this->belongsTo(Customer::class);
    }
    public function payment(){

    	return $this->belongsTo(Payment::class);
    }
    public function paymentSchedule(){

        return $this->belongsTo(PaymentSchedule::class);
    }
}
