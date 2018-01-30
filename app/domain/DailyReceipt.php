<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;


class DailyReceipt extends Model
{
    public function dailyPayment(){

    	return $this->belongsTo(DailyPaymant::class);
    }
}
