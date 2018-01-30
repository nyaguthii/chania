<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\domain\PaymentSchedule;
use App\domain\Policy;
use App\domain\Customer;
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
       
            $premium=$policy->total_premium/$request['remaining-payments'];

            $dueDate=$policy->effective_date;

            for($i=0;$i<$request['remaining-payments'];$i++){

             PaymentSchedule::create([
                'policy_id'=>$policy->id,
                'due_date'=>$dueDate,
                'amount'=>$premium,
                'status'=>'open',
                'lifeline_status'=>'active',
                'created_by'=>auth()->user()->id
                ]);
              $dueDate=$dueDate->addMonths(1);

            }
    
        $customer = $policy->customer;
        //session()->flash('payment-schedules-create-message','Schedules created successfully');
        //return view('policies.index',compact('customer'));
        return redirect()->action('CustomerPoliciesController@index',['customer'=>$customer])->with('message','new Payments Generated ');

    	
    }
    public function edit(PaymentSchedule $paymentSchedule){

        return view('paymentschedules.edit',['paymentSchedule'=>$paymentSchedule]);

    }
    public function update2(PaymentSchedule $paymentSchedule,Request $request){

        $this->validate($request,[
                'new_due_date'=>'required'
            ]);
        $paymentSchedule->due_date=Carbon::createFromFormat('m/d/Y',$request['new_due_date']);
        $paymentSchedule->edited_by=auth()->id();
        $paymentSchedule->save();

        session()->flash('message','payment schedule due date edited successfully');
         $customer=$paymentSchedule->policy->customer;
      //return view('policies.show',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);
       return redirect()->route('customer.policies.generate',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);

    }

    public function dueForm(){

        return view('prepayments.due');
    }

    public function due(Request $request){

        $this->validate($request,[
          'start_date'=>'required|date|before:end_date',
          'end_date'=>'required|date|after:start_date',
            ]);

        $start_date=Carbon::createFromFormat('m/d/Y',$request['start_date']);
        $end_date=Carbon::createFromFormat('m/d/Y',$request['end_date']);

        
        
        $paymentSchedules=PaymentSchedule::whereBetween('due_date',[$start_date,$end_date])
        ->where('status','open')
        ->where('lifeline_status','active')
        ->orderBy('due_date','asc')
        ->get();
        //dd($paymentSchedules);

        return view('prepayments.due',['paymentSchedules'=>$paymentSchedules]);
        
        
    }
    public function CustomerDue(Customer $customer,Request $request){

        $date=Carbon::createFromFormat('m/d/Y',$request['date']);

        $this->validate($request,[
            'date'=>'required|date'
            ]);


        $paymentSchedules=DB::table('payment_schedules')->select('*','payment_schedules.id as pid','payment_schedules.amount as pamount')
                ->join('policies','payment_schedules.policy_id','=','policies.id')
                ->join('customers','policies.customer_id','=','customers.id')
                ->join('vehicles','policies.vehicle_id','=','vehicles.id')
                ->whereDate('payment_schedules.due_date','<',$date)
                ->where('payment_schedules.status','open')
                ->where('customers.id',$customer->id)
                ->get();

            return view('customers.show',['customer'=>$customer,'paymentSchedules'=>$paymentSchedules]);

    }
}
