<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\PaymentSchedule;
use App\domain\Policy;
use Carbon\Carbon;
use App\Http\Requests\ScheduleRequest;

class PaymentSchedulesController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

    }

    public function store(Policy $policy,ScheduleRequest $request){

    	//$days=$policy->expiry_date->diffInDays($policy->effective_date);

    	//$daysPerMonth=$days/$request['remaining-payments'];
        if($policy->checkPaymentSchedule()){
          $deletedRows=PaymentSchedule::where('policy_id',$policy->id)->delete();  
        }

        if($policy->total_premium<=0){
         return redirect()->back()->withErrors('Add Endorsement First');
        }
        if($request['is_pay_daily']=="yes"){
           

            PaymentSchedule::create([
            'policy_id'=>$policy->id,
            'due_date'=>$policy->expiry_date,
            'amount'=>$policy->total_premium,
            'amount_paid'=>0,
            'status'=>'open'
            ]);

        }else{
            $premium=$policy->total_premium/$request['remaining-payments'];

            $dueDate=$policy->effective_date;

            for($i=0;$i<$request['remaining-payments'];$i++){

             PaymentSchedule::create([
                'policy_id'=>$policy->id,
                'due_date'=>$dueDate,
                'amount'=>$premium,
                'amount_paid'=>0,
                'status'=>'open'
                ]);
              $dueDate=$dueDate->addMonths(1);

            }
    

        }
            
        $customer = $policy->customer;
        //session()->flash('payment-schedules-create-message','Schedules created successfully');
        //return view('policies.index',compact('customer'));
        return redirect()->action('PoliciesController@index',['customer'=>$customer])->with('message','new Payments Generated Created');

    	
    }

    public function dueForm(){

        return view('payments.due');
    }

    public function due(Request $request){

        $this->validate($request,[
          'start_date'=>'required|date|before:end_date',
          'end_date'=>'required|date|after:start_date',
            ]);

        $start_date=Carbon::createFromFormat('m/d/Y',$request['start_date']);
        $end_date=Carbon::createFromFormat('m/d/Y',$request['end_date']);
        
        $paymentSchedules=PaymentSchedule::whereDate('due_date',[$start_date,$end_date])
        ->where('status','open')->get();

        return view('payments.due',['paymentSchedules'=>$paymentSchedules]);
        
        
    }
}
