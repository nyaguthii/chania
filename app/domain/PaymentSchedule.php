<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    protected $fillable = ['type', 'amount', 'amount_paid','policy_id','due_date','status','lifeline_status'];

    public function policy(){

    	return $this->belongsTo(Policy::class);
    }

    public function payments(){

    	return $this->hasMany(Payment::class);
    }
    
}
