<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\VehicleAccount;
use App\domain\VehicleTransaction;
use App\domain\VehicleReceipt;
use Carbon\Carbon;

class VehicleTransactionsController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function create(VehicleAccount $vehicleAccount){
    	return view('vehicles.transactions.create',compact('vehicleAccount'));
    }
    public function store(VehicleAccount $vehicleAccount,Request $request){

    	$this->validate($request,[
    		'transaction_date'=>'required',
    		'amount'=>'required:numeric',
    		'place'=>'required',
    		'description'=>'required',
    		'type'=>'required'
    		]);

    	$vehicleTransaction=new VehicleTransaction();
    	$vehicleTransaction->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	
    	$vehicleTransaction->place=$request['place'];
    	$vehicleTransaction->description=$request['description'];
    	$vehicleTransaction->type=$request['type'];
    	if($vehicleTransaction->type == "Credit"){
    		$vehicleTransaction->amount=$request['amount']*-1;
    	}else{
    		$vehicleTransaction->amount=$request['amount'];
    	}
    	$vehicleAccount->transactions()->save($vehicleTransaction);
    	$vehicleAccount->current_balance=$vehicleAccount->current_balance+$vehicleTransaction->amount;

    	$receipt=new VehicleReceipt();
    	$receipt->receipt_no=$request['receipt_no'];
    	$receipt->amount=$request['amount'];

    	$vehicleAccount->save();
    	$vehicleTransaction->vehicleReceipt()->save($receipt);

    	return redirect()->route('vehicles.show',['customer'=>$vehicleAccount->vehicle->customer->id,'vehicle'=>$vehicleAccount->vehicle->id])->with('message','Payment Added');

    }

    public function edit(VehicleTransaction $vehicleTransaction){
    	return view('vehicles.transactions.edit',['vehicleTransaction'=>$vehicleTransaction]);
    }
    public function update(VehicleTransaction $vehicleTransaction,Request $request){

    	$this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required:numeric',
            'place'=>'required',
            'description'=>'required',
            'receipt_no'=>'required'
            ]);

    	$vehicleTransaction->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	
    	$vehicleTransaction->place=$request['place'];
    	$vehicleTransaction->description=$request['description'];
    	$vehicleTransaction->type=$request['type'];
    	if($vehicleTransaction->type == "Credit"){
    		$vehicleTransaction->amount=$request['amount']*-1;
    	}else{
    		$vehicleTransaction->amount=$request['amount'];
    	}
    	$vehicleTransaction->save();
    	$vehicleAccount->current_balance=$vehicleAccount->current_balance+$vehicleTransaction->amount;

    	$receipt=new VehicleReceipt();
    	$receipt->receipt_no=$request['receipt_no'];
    	$receipt->amount=$request['amount'];

    	$vehicleAccount->save();
    	$vehicleTransaction->vehicleReceipt()->save($receipt);

    	return redirect()->route('vehicles.show',['customer'=>$vehicleAccount->vehicle->customer->id,'vehicle'=>$vehicleAccount->vehicle->id])->with('message','Payment Added');



    }
}
