<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Customer;
use App\domain\Credit;
use Carbon\Carbon;

class CreditsController extends Controller
{
    
    public function index(Customer $customer){

        $credits=$customer->credits()->orderBy('id','desc')->paginate(20);

        return view('customers.credits.index',compact('customer','credits'));

    }

    public function create(Customer $customer){

    	return view('customers.credits.create',['customer'=>$customer]);
    }
    public function store(Customer $customer,Request $request){

    	//if()

    	$this->validate($request,[
    		'transaction_date'=>'required',
    		'amount'=>'required'
    		]);

        $credit = new Credit();
        $credit->amount=$request['amount'];
        $credit->description=$request['description'];
        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $credit->type="Manual";
        $customer->credits()->save($credit);


        return redirect()->route('credits.index',['customer'=>$customer->id])->with('message','Due Amount Added');


    }
    public function edit(Credit $credit){

        return view('customers.credits.edit',compact('credit'));

    }
    public function update(Credit $credit,Request $request){

        $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required|numeric'
            ]);

        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $credit->amount=$request['amount'];
        $credit->description=$request['description'];

        $credit->save();

        return redirect()->route('credits.index',['customer'=>$credit->customer->id])->with('message','Credit Amount Edited');
    }
}
