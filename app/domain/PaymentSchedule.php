<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    protected $fillable = ['type', 'amount', 'amount_paid','policy_id','due_date','status','lifeline_status'];

    public function policy(){

    	return $this->belongsTo(Policy::class);
    }

    public function vehicleCredit(){

    	return $this->hasOne(VehicleCredit::class);
    }
    public function credit(){
        return $this->hasOne(Credit::class);
    }

    
}
