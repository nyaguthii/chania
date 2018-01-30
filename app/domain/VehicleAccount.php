<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class VehicleAccount extends Model
{
    public function vehicle(){
    	return $this->belongsTo(Vehicle::class);
    }

    public function transactions(){

    	return $this->hasMany(VehicleTransaction::class);
    }
}
