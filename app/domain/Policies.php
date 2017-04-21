<?php

namespace App\domain;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\domain\Policy;

class Policies
{
	
	public function all(){

        return Policy::all();
    }

	
	
    
    
}
