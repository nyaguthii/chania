<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Customer;
use App\domain\Vehicle;
use App\domain\Payment;
use App\domain\Receipt;
use DB;
use App\AfricasTalkingGateway;
use Carbon\Carbon;

class PaymentsApiController extends Controller
{
    
    protected $gateway;
    public function __construct(AfricasTalkingGateway $gateway)
    {
        
        $this->gateway=$gateway;
    }
    public function vehicles(){
        $vehicles=DB::table('vehicles')->select('id','registration')->get();
        return $vehicles;


    }
    public function customers(){
        $customers = DB::table('customers')
        ->select(DB::raw("id,concat(firstname,' ',middlename,' ',lastname) as name"))
        ->where('is_member','=','1')
        ->get();

        return $customers;

    }
    public function types(){
        $types=DB::table('payment_types')->select('id','name')->get();
        return $types;
    }

    public function vPayments(Request $request){


        $registration=$request->input('registration');
        $amount=$request->input('amount');
        $paymentType=$request->input('paymentType');

        $customer=DB::table('vehicles')
        ->join('customers','customer_id','=','customers.id')
        ->select(DB::raw("customers.id as id,customers.member_id,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,vehicles.id as vid"))
        ->where('vehicles.registration','=',$registration)
        ->first();

        $payment = new Payment();
        $payment->transaction_date=Carbon::today();
        $payment->amount=$amount;
        $payment->paid_from=$request->input('place');
        $payment->customer_id=$customer->id;
        $payment->created_by=auth()->id();
        $payment->vehicle_id=$customer->vid;
        $payment->type=$paymentType;
        $message="Paid Kshs ".number_format($request->input('amount'))." for ".$paymentType." Date: ".Carbon::today();
       
        if($payment->save()){
            $receipt = new Receipt();
            $receipt->amount=$amount;
            $payment->receipt()->save($receipt);

        return response()->json([
           'id'=>$receipt->id,
           'customer'=>$customer->name,
           'amount'=>$receipt->amount,
           'registration'=>$registration,
           'servedBy'=>auth()->user()->name,
           'memberId'=>$customer->member_id,
           'paymentType'=>$payment->type]);
        //return $receipt;

        }else{
            return "Not saved";
        }
    }
    public function cPayments(Request $request){


        $name=$request->input('customer');
        $id=$request->input('id');
        $amount=$request->input('amount');
        $paymentType=$request->input('paymentType');

        $customer=Customer::find($id);
        
        $payment = new Payment();
        $payment->transaction_date=Carbon::today();
        $payment->amount=$amount;
        $payment->paid_from=$request->input('place');
        $payment->customer_id=$id;
        $payment->created_by=auth()->id();
        $payment->type=$paymentType;

        //$message="Paid Kshs ".number_format($request->input('amount'))." for ".$paymentType." Date: ".Carbon::today();
       
        if($payment->save()){
            $receipt = new Receipt();
            $receipt->amount=$amount;
            $payment->receipt()->save($receipt);
        
        
        return response()->json([
           'id'=>$receipt->id,
           'customer'=>$name,
           'amount'=>$receipt->amount,
           'servedBy'=>auth()->user()->name,
           'memberId'=>$customer->member_id,
           'paymentType'=>$payment->type]);
        //return $receipt;

        }else{
            return "Not saved";
        }
        
            
            
        
        
        
    }
    
}
