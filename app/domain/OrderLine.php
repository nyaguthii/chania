<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    public function order(){
        return $this->belongTo(Order::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function materialTransaction(){
        return $this->belongsTo(MaterialTransaction::class);
    }
}
