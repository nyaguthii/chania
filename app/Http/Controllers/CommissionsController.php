<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\PaymentSchedule;

class CommissionsController extends Controller
{
    public function index(){

    	$commissions=PaymentSchedule::where('status','paid')->orderBy('id','desc')->paginate(50);
    	return view('commissions.index',['commissions'=>$commissions]);

    }
}
