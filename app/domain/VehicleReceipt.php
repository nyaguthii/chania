<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class VehicleReceipt extends Model
{
    public function vehicleTransaction(){
    	return $this->belongsTo(VehicleTransaction::class);
    }
}
