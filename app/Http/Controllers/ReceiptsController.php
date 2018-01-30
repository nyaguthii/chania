<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Receipt;
use App\domain\Payment;
use App\domain\Vehicle;
use DB;

class ReceiptsController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function show(Payment $payment){

       $receipt=$payment->receipt;

       if($payment->vehicle_id){
        $vehicle=Vehicle::where('id',$payment->vehicle_id)->first();
        //$vehicle=DB::table('vehicles')->select('*')->where('id','=',$payment->vehicle_id)->get();
        //dd($vehicle);
        //return redirect(\URL::previous());
       }else{
           $vehicle="";
       }
       
    	return view('receipts.show',['receipt'=>$receipt,'vehicle'=>$vehicle]);

    }
    public function print(Receipt $receipt){
        

    }
}
