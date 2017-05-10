<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\domain\PaymentSchedule;
use App\domain\Payment;
use App\domain\Receipt;
use App\domain\Customer;
use App\domain\Credit;
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
         $paymentSchedule->amount_paid=$amount_paid;
         //$paymentSchedule->save();

         if($paymentSchedule->amount == $amount_paid){
            $paymentSchedule->status="paid";
            //$paymentSchedule->save();
         }elseif($paymentSchedule->amount > $amount_paid){
            $paymentSchedule->status="open";
            //$paymentSchedule->save();
         }
         if($payment->type==="Agency"){
            if($paymentRequest['type']==="Agency"){
                $credit=$payment->credit;
                $credit->amount=$paymentRequest['amount'];
                $credit->save();
                $payment->save();
            }elseif($paymentRequest['type']==="Owner"){ 
              if($payment->credit){
                    $payment->credit->delete();
                }
               $receipt= new Receipt();
               $receipt->amount=$payment->amount;
               $payment->type="Owner";
               $payment->receipt()->save($receipt);
               $payment->save();   
            }
            
         }elseif($payment->type==="Owner"){
            if($paymentRequest['type']==="Agency"){
                $receipt=$payment->receipt;
                $receipt->delete();
            }elseif($paymentRequest['type']==="Owner"){
               $receipt=$payment->receipt;
               $receipt->amount=$payment->amount;
               $receipt->save(); 
            }

         }

         $paymentSchedule->save();

         
         
         
         session()->flash('message','payment edited successfully');
         return redirect()->route('payments.index',['customer'=>$customer]);


    }
    public function create(PaymentSchedule $paymentSchedule){

    	//dd($paymentSchedule);

    	return view('payments.create',compact('paymentSchedule'));
    }

    public function store(PaymentSchedule $paymentSchedule,PaymentRequest $paymentRequest){
 

    	if($paymentRequest['amount'] > $paymentSchedule->amount){

    		return redirect()->back()->withErrors('Amount is greater Than premium');
    	}

         $transactionDate=Carbon::createFromFormat('m/d/Y',$paymentRequest['transaction_date']);

         $payment = new Payment();
         $payment->amount=$paymentRequest['amount'];
         $payment->transaction_date=$transactionDate;
         $payment->type=$paymentRequest['type'];
         $payment->description=$paymentRequest['description'];
         $amount_paid=$paymentSchedule->amount_paid;

         $paymentSchedule->amount_paid=$amount_paid+$paymentRequest['amount'];

         if($amount_paid+$paymentRequest['amount'] > $paymentSchedule->amount ){

         	return redirect()->back()->withErrors('Total payment will be greater Than premium');

         }

     	 if($paymentSchedule->amount == $paymentSchedule->amount_paid){
     	 	$paymentSchedule->status="paid";
     	 	//$paymentSchedule->save();
     	 }

         
         $paymentSchedule->payments()->save($payment);
         $paymentSchedule->save();
         //dd($payment);

         if($paymentRequest['type']==="Agency"){
            $credit=new Credit();
            $credit->amount=$paymentRequest['amount'];
            $credit->description="Agency Payment for ".$paymentSchedule->policy->policy_no." date Due ".$paymentSchedule->due_date;
            $credit->customer_id=$paymentSchedule->policy->customer->id;
            $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$paymentRequest['transaction_date']);
            $credit->type="Auto";

            //before the associating the credit to payment
            //$customer=$paymentSchedule->policy->customer;
            //$customer->credits()->save($credit);
            $payment->credit()->save($credit);

            
         }elseif($paymentRequest['type']==="Owner"){
             $receipt= new Receipt();
             $receipt->amount=$payment->amount;
             $payment->receipt()->save($receipt);

         }

    
     //if the payment is being paid by the agency the debt is tranferred to the customer

      session()->flash('message','payment created successfully');
      $customer=$paymentSchedule->policy->customer;
      //return view('policies.show',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);
      return redirect()->route('customer.policies.generate',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);
    }

    public function showDailyForm(){


        $today=Carbon::now()->toDateString();
        //$payments=DB::table('payments')->whereDate('created_at',$today)->get();


         $creditPayments=DB::table('credit_payments')
         ->whereDate('transaction_date',$today)
         ->select('transaction_date','amount');

         $payments=DB::table('payments')
         ->whereDate('transaction_date',$today)
         ->where('type','Owner')
         ->select('transaction_date','amount')
         ->union($creditPayments)
         ->get();

        //dd($payments);
        

        return view('payments.daily',['payments'=>$payments]);
    }

    public function getDaily(Request $request){

        $this->validate($request,[
          'date'=>'required|date'
            ]);

        $date=Carbon::createFromFormat('m/d/Y',$request['date'])->toDateString();
        //$payments=Payment::whereDate('transaction_date',$date)->get();
        $creditPayments=DB::table('credit_payments')
         ->whereDate('transaction_date',$date)
         ->select('transaction_date','amount');

         $payments=DB::table('payments')
         ->whereDate('transaction_date',$date)
         ->where('type','Owner')
         ->select('transaction_date','amount')
         ->union($creditPayments)
         ->get();

        
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
           
            $payments=DB::table('payments')->select('*', 'payments.id as pid','payments.amount as pamount')
                ->join('payment_schedules','payments.payment_schedule_id','=','payment_schedules.id')
                ->join('policies','payment_schedules.policy_id','=','policies.id')
                ->join('customers','policies.customer_id','=','customers.id')
                ->join('vehicles','policies.vehicle_id','=','vehicles.id')
                ->whereBetween('payments.transaction_date',[$start_date,$end_date])
                ->paginate(20);
                //$payments=DB::table('payments')->whereBetween('transaction_date',[$start_date,$end_date])->paginate(20);

        }else{

            //$payments=DB::table('payments')->whereBetween('transaction_date',[$start_date,$end_date])->paginate(20);


            $payments=DB::table('payments')->select('*', 'payments.id as pid','payments.amount as pamount')
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

    public function totalPerDay(){
/*
        $payments = \Illuminate\Pagination\Paginate::make(DB::select( DB::raw("
            select payments.transaction_date,sum(payments.amount) as total_collection from (
             select transaction_date,amount from credit_payments
             union
             select transaction_date,amount from payments
             where type='Owner'

            ) as payments
            group by payments.transaction_date
            order by payments.transaction_date desc
            ") ), 20);
        */
            $page = isset($_GET['page']) && !empty($_GET['page'])?(int)$_GET['page']:1;
            $items_per_page = 30;
            $offset = ($page-1)*$items_per_page;
            $payments = DB::select( DB::raw("
                select SQL_CALC_FOUND_ROWS transaction_date, payments.transaction_date,sum(payments.amount) as total_collection from (
                 select transaction_date,amount from credit_payments
                 union
                 select transaction_date,amount from payments
                 where type='Owner'

                ) as payments
                group by payments.transaction_date
                order by payments.transaction_date desc

                LIMIT $offset,$items_per_page

                ") );

            $total_rows = DB::select( DB::raw("
                SELECT FOUND_ROWS() as rows

                ") );

        //dd($total_rows[0]->rows);

         

         return view('payments.totalperday',['payments'=>$payments,'total_rows'=>$total_rows[0]->rows,'page'=>$page,'items_per_page'=>$items_per_page]);

    }


}

