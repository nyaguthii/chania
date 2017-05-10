<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class CreditPayment extends Model
{
    public function customer(){

    	return $this->belongsTo(Customer::class);
    }
    public function creditReceipt(){

    	return $this->hasOne(CreditReceipt::class);
    }
}
