<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Customer;
use App\domain\Credit;
use App\domain\PaymentType;
use Carbon\Carbon;

class CreditsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Customer $customer){

        $credits=$customer->credits()->where('type','INSURANCE')->orderBy('id','desc')->paginate(50);

        $payments=$customer->payments()->where('type','INSURANCE')->orderBy('id','desc')->get();
        return view('customers.credits.index',['customer'=>$customer,'credits'=>$credits,'payments'=>$payments]);

    }

    public function create(Customer $customer){

        $paymentTypes=PaymentType::all();
    	return view('customers.credits.create',['customer'=>$customer,'paymentTypes'=>$paymentTypes]);
    }
    public function store(Customer $customer,Request $request){

    	//if()

    	$this->validate($request,[
    		'transaction_date'=>'required',
            'amount'=>'required',
            'description'=>'required',
            'type'=>'required'
    		]);

        $credit = new Credit();
        $credit->amount=$request['amount'];
        $credit->description=$request['description'];
        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $credit->type=$request['type'];
        $credit->creation_method="Manual";
        $credit->created_by=auth()->id();
        
        $customer->credits()->save($credit);


        return redirect()->route('credits.index',['customer'=>$customer->id])->with('message','Due Amount Added');


    }
    public function edit(Credit $credit){
        $paymentTypes=PaymentType::all();
        return view('customers.credits.edit',['credit'=>$credit,'paymentTypes'=>$paymentTypes]);

    }
    public function update(Credit $credit,Request $request){

        $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required|numeric',
            'description'=>'required'
            ]);

        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $credit->amount=$request['amount'];
        $credit->description=$request['description'];

        $credit->save();

        return redirect()->route('credits.index',['customer'=>$credit->customer->id])->with('message','Credit Amount Edited');
    }
}
