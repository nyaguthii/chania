<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function materialTransactions(){
        return $this->hasMany(MaterialTransaction::class);
    }
    public function orderLines(){
        return $this->hasMany(OrderLines::class);
    }
}
