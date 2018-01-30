<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function customer(){

        return $this->belongsTo(Customer::class);
    }

    public function orderLines(){
        
        return $this->hasMany(OrderLine::class);
    }
}
