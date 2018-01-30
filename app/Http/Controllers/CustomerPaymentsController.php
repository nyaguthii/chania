<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\PaymentType;
use App\domain\Customer;
use App\domain\Payment;
use App\domain\Receipt;
use Carbon\Carbon;
use App\AfricasTalkingGateway;

class CustomerPaymentsController extends Controller
{   
    protected $gateway;
    public function __construct(AfricasTalkingGateway $gateway){
        $this->middleware('auth');
        $this->gateway=$gateway;
		
	}
    public function create(Customer $customer){
        $paymentTypes=PaymentType::all();
        return view('payments.customers.create',['paymentTypes'=>$paymentTypes,'customer'=>$customer]);
    }

    public function ajax(){
        
    }
    public function store(Customer $customer,Request $request){
        $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required|integer',
            'from'=>'required'
        ]);

        $payment = new Payment();
        $payment->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $payment->amount=$request['amount'];
        $payment->paid_from=$request['from'];
        $payment->created_by=auth()->id();
        $payment->type=$request['type'];

        $message="Paid Kshs ".number_format($request['amount'])." for ".$request['type']." Date: ".Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
       
        if($customer->payments()->save($payment)){
            try 
            { 
              // Thats it, hit send and we'll take care of the rest.
              //dd($this->gateway->getUsername()); 
             //$this->gateway->sendMessage($customer->contact, $message);
                       
              
            }
            catch ( AfricasTalkingGatewayException $e )
            {
              //echo "Encountered an error while sending: ".$e->getMessage();
            }
            $receipt = new Receipt();
            $receipt->amount=$payment->amount;
            $payment->receipt()->save($receipt);

            return redirect()->route('payments.index')->with('message','Payment created');

        }else{
            return back()->with('message','Did not create Payment');
        }
        
    }
}
