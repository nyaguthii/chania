<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class DailyPayment extends Model 
{
    //use Auditable;

    protected $auditInclude = [
        'vehicle_id',
        'amount',
        'transaction_date'
    ];
    public function vehicle(){

    	return $this->belongsTo(Vehicle::class);
    }
    public function receipt(){

    	return $this->hasOne(DailyReceipt::class);
    }
}
