<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Policy;
use App\domain\Refund;
use Carbon\Carbon;

class RefundsController extends Controller
{
	
  public function __construct()
    {
        $this->middleware('auth');
    }
  public function index(){

		$refunds=Refund::latest()->paginate(30);

		return view('refunds.index',['refunds'=>$refunds]);
	}
    public function create(Policy $policy){
    	return view('refunds.create',['policy'=>$policy]);
    }

    public function store(Policy $policy,Request $request){


    	$this->validate($request,[
    		'amount'=>'required|numeric',
    		'transaction_date'=>'required|date'
    		]);
    	//dd($policy);
      $date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
      $refund = new Refund();
      $refund->amount=$request['amount'];
      $refund->transaction_date=$date;
      $policy->refund()->save($refund);

      	session()->flash('message','Refund made successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('policies.show',['customer'=>$policy->customer->id,'policy'=>$policy->id]);  


    }

    public function edit(Refund $refund){



    	return view('refunds.edit',['refund'=>$refund]);


    }

    public function update(Refund $refund,Request $request){
    	$this->validate($request,[
    		'amount'=>'required|numeric',
    		'transaction_date'=>'required|date'
    		]);
    	//dd($policy);
      $date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);

      $refund->amount=$request['amount'];
      $refund->transaction_date=$request['transaction_date'];

      session()->flash('message','Refund edited successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('refunds.index'); 

    }
}
