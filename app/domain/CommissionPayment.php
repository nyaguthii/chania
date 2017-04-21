<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class CommissionPayment extends Model
{
    public function commission(){

    	return $this->belongsTo(Commission::class);
    }
}
