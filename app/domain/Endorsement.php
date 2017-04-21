<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Endorsement extends Model
{   

	protected $fillable = ['type', 'amount', 'description','policy_id'];
    
    public function policy(){

    	return $this->belongsTo(Policy::class);
    }

    public function commission(){
    	return $this->hasOne(Commission::class);
    }
    public function calculateCommission($rate){
     
     
     
    }
}
