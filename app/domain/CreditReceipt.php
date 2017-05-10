<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class CreditReceipt extends Model
{
    public function creditPayment(){

    	return $this->belongsTo(CreditPayment::class);
    }
}
