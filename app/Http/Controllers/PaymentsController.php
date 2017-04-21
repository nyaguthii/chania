<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\domain\PaymentSchedule;
use App\domain\Payment;
use App\domain\Receipt;
use App\domain\Customer;
use App\Http\Requests\PaymentRequest;
use Carbon\Carbon;

class PaymentsController extends Controller
{
	
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Customer $customer){

        $policies= $customer->policies()->orderBy('id', 'desc')->get();

		return view('payments.index',compact('customer','policies'));

	}
	public function show(){

	}
    public function edit(Customer $customer,Payment $payment){

        return view('payments.edit',['payment'=>$payment]);

    }
    public function update(Customer $customer,Payment $payment,PaymentRequest $paymentRequest){
        
        $paymentSchedule=$payment->paymentSchedule;

        if($paymentRequest['amount'] > $paymentSchedule->amount){

            return redirect()->back()->withErrors('Amount is greater Than premium');
        }
        
        /*$amount_to_deduct=$payment->amount;
        
        $amount_paid=$paymentSchedule->amount_paid;
        $amount_paid=$amount_paid-$amount_to_deduct;

        $amount_paid=$amount_paid+$paymentRequest['amount'];*/
        
        $amount_paid=$paymentSchedule->amount_paid+$paymentRequest['amount']-$payment->amount;

        if($amount_paid > $paymentSchedule->amount ){

            return redirect()->back()->withErrors('Total payment will be greater Than premium');

         }
         $transactionDate=Carbon::createFromFormat('m/d/Y',$paymentRequest['transaction_date']);

         $payment->amount=$paymentRequest['amount'];
         $payment->transaction_date=$transactionDate;
         $payment->save();
         $paymentSchedule->amount_paid=$amount_paid;
         //$paymentSchedule->save();

         if($paymentSchedule->amount == $amount_paid){
            $paymentSchedule->status="paid";
            //$paymentSchedule->save();
         }elseif($paymentSchedule->amount > $amount_paid){
            $paymentSchedule->status="open";
            //$paymentSchedule->save();
         }

         $paymentSchedule->save();

         $receipt=$payment->receipt;
         $receipt->amount=$payment->amount;
         $receipt->save();
         
         session()->flash('message','payment edited successfully');
         return redirect()->route('payments.index',['customer'=>$customer]);


    }
    public function create(PaymentSchedule $paymentSchedule){

    	//dd($paymentSchedule);

    	return view('payments.create',compact('paymentSchedule'));
    }

    public function store(PaymentSchedule $paymentSchedule,PaymentRequest $paymentRequest){

    	//dd($paymentSchedule);
        

    	if($paymentRequest['amount'] > $paymentSchedule->amount){

    		return redirect()->back()->withErrors('Amount is greater Than premium');
    	}

     $transactionDate=Carbon::createFromFormat('m/d/Y',$paymentRequest['transaction_date']);

     $payment = new Payment();
     $payment->amount=$paymentRequest['amount'];
     $payment->transaction_date=$transactionDate;
     $amount_paid=$paymentSchedule->amount_paid;
     $paymentSchedule->amount_paid=$amount_paid+$paymentRequest['amount'];

     if($amount_paid+$paymentRequest['amount'] > $paymentSchedule->amount ){

     	return redirect()->back()->withErrors('Total payment will be greater Than premium');

     }

 	 if($paymentSchedule->amount == $paymentSchedule->amount_paid){
 	 	$paymentSchedule->status="paid";
 	 	//$paymentSchedule->save();
 	 }
     $paymentSchedule->save();
 	 $paymentSchedule->payments()->save($payment);
 	 $receipt= new Receipt();
 	 $receipt->amount=$payment->amount;
 	 $payment->receipt()->save($receipt);
 

     

      session()->flash('message','payment created successfully');
      $customer=$paymentSchedule->policy->customer;
      //return view('policies.show',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);
      return redirect()->route('policies.generate',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);
    }

    public function showDailyForm(){


        $today=Carbon::now()->toDateString();
        //$payments=DB::table('payments')->whereDate('created_at',$today)->get();

         $payments=Payment::whereDate('transaction_date',$today)->get();

        //dd($payments);
        

        return view('payments.daily',['payments'=>$payments]);
    }

    public function getDaily(Request $request){

        $this->validate($request,[
          'date'=>'required|date'
            ]);

        $date=Carbon::createFromFormat('m/d/Y',$request['date'])->toDateString();
        
        
        $payments=Payment::whereDate('transaction_date',$date)->get();
        
        return view('payments.daily',['payments'=>$payments]);

    }

    public function showRangeForm(){

     return view('payments.range');
   

    }
    public function getRange(Request $request){



        $this->validate($request,[
           'start_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:start_date',
            ]);
        $start_date=Carbon::createFromFormat('m/d/Y',$request['start_date']);
        $end_date=Carbon::createFromFormat('m/d/Y',$request['end_date']);
       

        if($request['is_member']=="all"){
           
            $payments=DB::table('payments')->select('*', 'payments.id as pid')
                ->join('payment_schedules','payments.payment_schedule_id','=','payment_schedules.id')
                ->join('policies','payment_schedules.policy_id','=','policies.id')
                ->join('customers','policies.customer_id','=','customers.id')
                ->join('vehicles','policies.vehicle_id','=','vehicles.id')
                ->whereBetween('payments.transaction_date',[$start_date,$end_date])
                ->paginate(20);
        }else{
            $payments=DB::table('payments')->select('*', 'payments.id as pid')
                ->join('payment_schedules','payments.payment_schedule_id','=','payment_schedules.id')
                ->join('policies','payment_schedules.policy_id','=','policies.id')
                ->join('customers','policies.customer_id','=','customers.id')
                ->join('vehicles','policies.vehicle_id','=','vehicles.id')
                 ->whereBetween('payments.transaction_date',[$start_date,$end_date])
                ->where('customers.is_member',$request['is_member'])->paginate(20);


                /*$payments=Payment::whereBetween('transaction_date',[$start_date,$end_date])
                ->whereHas('paymentSchedule',function($query) use ($request){
                    $query->whereHas('policy',function($query) use ($request){
                        $query->whereHas('customer',function($query) use ($request){
                            $query->where('is_member',$request['is_member']);
                        });
                    });
                    
                })
                ->paginate(20);
                dd($payments);*/


        }
        
        
       
        return view('payments.range',['payments'=>$payments]);

    }


}

