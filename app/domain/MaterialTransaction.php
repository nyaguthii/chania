<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;


class MaterialTransaction extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    } 
    public function orderLine(){
        return $this->hasOne(OrderLine::class);
    }
}
