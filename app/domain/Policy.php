<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Policy extends Model
{
	protected $fillable = ['policy_no', 'effective_date', 'carrier','agent','insured_id','type'];
    //public $incrementing=false;
	//protected $primaryKey ='policy_no';
	

	protected $dates = ['effective_date','expiry_date'];


	
    public function customer(){
    	return $this->belongsTo(Customer::class);
    }
    /*public function setEffectiveDateAttribute($date){

    	$this->attributes['effective_date']=Carbon::createFromFormat('m/d/Y',$date);
    }
*/
    
    public function getVehicleById($id){

       $vehicle=Vehicle::findOrFail($id);
       return $vehicle->registration;

    }

    public function endorsements(){
    	return $this->hasMany(Endorsement::class);
    }

    public function getDurationAttribute($value){

        return $value;

    }

    public function paymentSchedules(){

        return $this->hasMany(PaymentSchedule::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function payments()
    {
        return $this->hasManyThrough('App\domain\Payment', 'App\domain\PaymentSchedule');
    }

    

    public function calcutateExpiryDate(){

        $duration = getDurationAttribute();
        $x=0;
        switch ($duration) {
            case 'Annual':
                $x=12;
                break;
            case 'Semi Annual':
                $x=6;
                break;
            case 'Quartely':
                $x=3;
            case 'Monthly':
                $x=1;
                break;
        }
        

        setExpiryDateAttribute(Carbon::now()->addMonths(x));
    }
    
    public function getTotalCommission(){
        $totalCommission=0;
        foreach($this->endorsements as $endorsement){

         $totalCommission=$totalCommission + $endorsement->commission->amount;

        }

        return $totalCommission;
    }

    public function checkPaymentSchedule(){

            if(count($this->paymentSchedules)>0){
                return true;

        }else{
            return false;
        }
    }

    public function refund(){
        return $this->hasOne(Refund::class);
    }
    public function claims(){
        return $this->hasMany(Claim::class);
    }

    public function suspensions(){

        return $this->hasMany(Suspension::class);
    }
    public function cancellation(){
        return $this->hasOne(Cancellation::class);
    }
}
