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
    public function dailyPayments(){
        
        return $this->hasMany(DailyPayment::class);
    }

    public function vehicleAccount(){

        return $this->hasOne(VehicleAccount::class);
    }
    public function vehicleCredits(){

        return $this->hasMany(VehicleCredit::class);
    }
    public function totalPremium(){

        $total=0;
        foreach($this->policies as $policy){
            foreach($policy->paymentSchedules as $paymentSchedule){
                $total=$total+$paymentSchedule->amount;
            }
        }
    }

    public function difference(){

        /*$totalMonthly=0;
        foreach($this->policies as $policy){
            foreach($policy->paymentSchedules->where('status','paid') as $paymentSchedule){               
                    $totalMonthly=$totalMonthly+$paymentSchedule->amount;
            }
        }*/

        $totalDaily=$this->dailyPayments()->where('type','Debit')->sum('amount')-$this->dailyPayments()->where('type','Credit')->sum('amount');

        $totalCredit=$this->vehicleCredits()->sum('amount');

        return $totalCredit-$totalDaily;


    }
}
