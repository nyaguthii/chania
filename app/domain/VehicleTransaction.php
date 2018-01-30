<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class VehicleTransaction extends Model
{
    public function vehicleAccount(){

    	return $this->belongsTo(VehicleAccount::class);
    }

    public function vehicleReceipt(){

    	return $this->hasOne(VehicleReceipt::class);
    }

   
}
