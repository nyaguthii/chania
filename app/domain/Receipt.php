<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
	
    public function payment(){

    	return $this->belongsTo(Payment::class);
    }
}
