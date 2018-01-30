<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\PaymentType;
use App\domain\Customer;
use App\domain\Credit;
use Carbon\Carbon;
use DB;

class TyreCreditsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Customer $customer){
        $credits=DB::table('credits')
        ->select('id','transaction_date','amount','creation_method','type')
        ->where('type','TYRE')
        ->where('customer_id',$customer->id)
        ->orderBy('id','desc')
        ->paginate(50);
        return view('tyres.credits.index',['credits'=>$credits,'customer'=>$customer]);
    }
    public function create(Customer $customer){

        $paymentTypes=DB::table('payment_types')
        ->select('name')
        ->where('name','TYRE')
        ->get();
        return view('tyres.credits.create',['paymentTypes'=>$paymentTypes,'customer'=>$customer]);
    }
    public function store(Customer $customer,Request $request){

        $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required',
            'description'=>'required',
            'amount'=>'required'
        ]);

        $credit = new Credit();
        $credit->amount=$request['amount'];
        $credit->description=$request['description'];
        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $credit->type=$request['type'];
        $credit->creation_method="Manual";
        $credit->created_by=auth()->id();
        
        $customer->credits()->save($credit);


        return redirect()->route('customers.tyres.show',['customer'=>$customer->id])->with('message','Due Amount Added');

    }

    public function edit(Credit $credit){
        $paymentTypes=DB::table('payment_types')
        ->select('name')
        ->where('name','TYRE')
        ->get();

        return view('tyres.credits.edit',['paymentTypes'=>$paymentTypes,'credit'=>$credit]);


    }
    public function update(Request $request,Credit $credit){
        $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required',
            'description'=>'required',
            'amount'=>'required'
        ]);

        $credit->amount=$request['amount'];
        $credit->description=$request['description'];
        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $credit->type=$request['type'];
        $credit->creation_method="Manual";
        $credit->edited_by=auth()->id();
        $credit->save();
        
        return redirect()->route('tyres.credits.index',['customer'=>$credit->customer->id])->with('message','Credit Edited Successfully');

    }
    public function delete(Credit $credit){
        return view('tyres.credits.delete',['credit'=>$credit]);

    }
    public function destroy(Credit $credit){
        $credit->delete();
        return redirect()->route('tyres.credits.index',['customer'=>$credit->customer->id])->with('message','Credit Deleted Successfully');
    }

    
}
