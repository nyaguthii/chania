<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Commission;
use App\domain\CommissionPayment;
use Carbon\Carbon;

class CommissionPaymentsController extends Controller
{
    public function create(Commission $commission){
    	return view('commissions.payments.create',['commission'=>$commission]);
    }

    public function store(Commission $commission,Request $request){


    	$this->validate($request,[
    		'transaction_date'=>'required|date',
    		'amount'=>'required|numeric'
    		]);

    	if($request['amount'] >$commission->amount){
    		return redirect()->back()->withErrors('Amount is greater Than commission Amount');

    	}elseif($commission->payments->sum('amount') + $request['amount'] >$commission->amount ){

    		return redirect()->back()->withErrors('Total commission will be greater Than commission Amount');
    	}

    	$date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	$commissionPayment = new CommissionPayment();
    	$commissionPayment->transaction_date=$date;
    	$commissionPayment->amount=$request['amount'];
    	
    	$commission->payments()->save($commissionPayment);

    	session()->flash('message','payment added successfully');
         return redirect()->route('commissions.index');



    }
}
