<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
	protected $fillable = ['registration', 'year', 'make','model'];

	
    public function customer(){

    	return $this->belongsTo(Customer::class);
    }
    public function policies(){

    	return $this->hasMany(Policy::class);
    }
    public function getVehicleByRegistration($registration){

    	return $this->where('registration',$registration);


    }
}
