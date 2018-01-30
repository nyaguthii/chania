<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Customer extends Model
{
     protected $fillable = ['type', 'firstname', 'lastname','middlename','insured_id','address','contact','is_member'];


     public function policies(){

     	return $this->hasMany(Policy::class);
     }

     public function vehicles(){

     	return $this->hasMany(Vehicle::class);
     }
     public function payments(){
         return $this->hasMany(Payment::class);
     }

     public function paymentSchedules(){

     	return $this->hasManyThrough('App\domain\PaymentSchedule','App\domain\Policy');
     }

     public function getPayments(){

     	return $payments=DB::table('payments')
        //->join('payment_schedules','payments.payment_schedule_id','=','payment_schedules.id')
        //->join('policies','payment_schedules.policy_id','=','policies.id')->where('policies.customer_id','=',$this->id)
        ->get();
     }
     public function credits(){

        return $this->hasMany(Credit::class);
     }
     public function creditPayments(){
        
        return $this->hasMany(CreditPayment::class);
     }

     public function orders(){
         return $this->hasMany(Order::class);
     }

     public function difference(){
        $payments=$this->payments->where('type','INSURANCE')->sum('amount');
        $credits=$this->credits->where('type','INSURANCE')->sum('amount');

        return $payments-$credits;    
     }


}
