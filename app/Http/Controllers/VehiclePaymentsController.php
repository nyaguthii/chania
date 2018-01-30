<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Vehicle;
use Carbon\Carbon;
use App\domain\DailyReceipt;
use App\domain\DailyPayment;

class VehiclePaymentsController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}
    public function create(Vehicle $vehicle){

    	return view('vehicles.payments.create',compact('vehicle'));
    }

    public function store(Vehicle $vehicle,Request $request){

    	if($request['type']==="Debit"){
           $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required:numeric',
            'place'=>'required',
            'description'=>'required',
            'type'=>'required',
            'receipt_no'=>'required|unique:daily_receipts'
            ]); 
        }else{

          $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required:numeric',
            'place'=>'required',
            'description'=>'required',
            'type'=>'required'
            ]);   
        }

        

    	$dailyPayment=new DailyPayment();
    	$dailyPayment->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	$dailyPayment->amount=$request['amount'];
    	$dailyPayment->place=$request['place'];
    	$dailyPayment->description=$request['description'];
        $dailyPayment->type=$request['type'];
        if($request['type']==="Debit"){
          $dailyPayment->statement_impact="add";  
        }elseif($request['type']==="Credit"){
            $dailyPayment->statement_impact="minus";
        }

        $vehicle->dailyPayments()->save($dailyPayment);

        if($request['type']==="Debit"){
            $receipt=new DailyReceipt();
            $receipt->receipt_no=$request['receipt_no'];
            $receipt->amount=$request['amount'];
            $dailyPayment->receipt()->save($receipt);
        }

    	

    	
    	

    	return redirect()->route('customers.vehicles.show',['customer'=>$vehicle->customer->id,'vehicle'=>$vehicle->id])->with('message','Payment Added');

    }
    public function edit(DailyPayment $dailyPayment){

        return view('vehicles.payments.edit',['dailyPayment'=>$dailyPayment]);

    }

    public function update(DailyPayment $dailyPayment,Request $request){

        if($request['type']==="Debit"){
           $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required:numeric',
            'place'=>'required',
            'description'=>'required',
            'type'=>'required',
            'receipt_no'=>'required'
            ]); 
        }else{

          $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required:numeric',
            'place'=>'required',
            'description'=>'required',
            'type'=>'required'
            ]);   
        }

        
        if($dailyPayment->type==="Debit"){
            if($request['type']==="Credit"){
               $dailyPayment->receipt->delete();
            
               $dailyPayment->statement_impact="minus";
               $dailyPayment->save();

            }elseif($request['type']==="Debit"){
                $receipt= $dailyPayment->receipt;
                $receipt->receipt_no=$request['receipt_no'];
                $receipt->amount=$request['amount'];
                $receipt->save();
            }


        }elseif($dailyPayment->type==="Credit"){
            if($request['type']==="Debit"){
                $receipt=new DailyReceipt();
                $receipt->receipt_no=$request['receipt_no'];
                $receipt->amount=$request['amount'];
                $dailyPayment->receipt()->save($receipt);
                $dailyPayment->statement_impact="add";
            }

        }
        $dailyPayment->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $dailyPayment->amount=$request['amount'];
        $dailyPayment->place=$request['place'];
        $dailyPayment->description=$request['description'];
        $dailyPayment->type=$request['type']; 

        $dailyPayment->save();
        
        
        return redirect()->route('customers.vehicles.show',['customer'=>$dailyPayment->vehicle->customer->id,'vehicle'=>$dailyPayment->vehicle->id])->with('message','Payment Edited Successfully');

    }
}
