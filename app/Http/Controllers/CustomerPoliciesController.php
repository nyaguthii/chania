<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\domain\Customer ;
use App\domain\Policy ;
use App\domain\Vehicle;
use App\domain\Carrier;
use Carbon\Carbon;
use App\Http\Requests\PolicyRequest;

class CustomerPoliciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Customer $customer)
    {
      $today=Carbon::now();
      $policies=$customer->policies()->orderBy('id','desc')->paginate(10);
      foreach($policies as $policy){
           if($policy->expiry_date->eq($today)){
                $policy->status="expired";
                $policy->save();

           }

       }

      return view('policies.customer.index',compact('policies','customer'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        $carriers=Carrier::all();
        return view('policies.customer.create',['customer'=>$customer,'carriers'=>$carriers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer,Request $request)
    {  
        $this->validate($request,[
            'policy_no' => 'required',
            'duration_type' => 'required',
            'agent' => 'required',
            'effective_date' => 'required',
            'carrier' => 'required',
            'vehicle' => 'required',
            'type' => 'required'
        ]);

        //dd($request);
       $policy= new Policy();
       $policy->policy_no=$request['policy_no'];
       $policy->effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);
       $policy->carrier=$request['carrier'];
       $policy->agent=$request['agent'];
       $policy->duration=$request['duration_type'];
       $policy->status="drafted";
       $policy->type=$request['type'];


       
       $vehicle=Vehicle::where('registration',$request['vehicle'])->first();
       //dd($vehicle->make);
       $policy->vehicle_id=$vehicle->id;


        $x=0;
        switch ($policy->duration) {
            case 'Annual':
                $x=12;
                break;
            case 'Ten Months':
                $x=10;
                break;    
            case 'Semi Annual':
                $x=6;
                break;
            case 'Quartely':
                $x=3;
            case 'Monthly':
                $x=1;
                break;
        }


      $policy->expiry_date = Carbon::createFromFormat('m/d/Y',$request['effective_date'])->addMonths($x);
      $policy->created_by=auth()->id();


       //$vehicle=Vehicle::find($request['vehicle']);
       $customer->policies()->save($policy);

        session()->flash('policy-create-message','policy created successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('customer.policies.index',['customer'=>$customer]);
        
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate(Customer $customer,Policy $policy)
    {
      //$policy=Policy::find($policy);
      //dd($policy->mytest());

      return view('policies.customer.generate',compact('customer','policy'));  
    }
    public function show(Customer $customer,Policy $policy)
    {
      //$policy=Policy::find($policy);
      //dd($policy->mytest());

      return view('policies.customer.show',compact('customer','policy'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer,Policy $policy)
    {
        return view('policies.customer.edit',compact('customer','policy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Policy $policy,Request $request)
    {
       $this->validate($request,[
        'policy_no' => 'required',
        'duration_type' => 'required',
        'agent' => 'required',
        'effective_date' => 'required',
        'carrier' => 'required',
        'vehicle' => 'required',
        'type' => 'required'
       ]);
       

       $policy->effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);
       $policy->carrier=$request['carrier'];
       $policy->agent=$request['agent'];
       $policy->duration=$request['duration_type'];
       //$policy->status="drafted";
       $policy->type=$request['type'];


       
       $vehicle=Vehicle::where('registration',$request['vehicle'])->first();
       //dd($vehicle->make);
       $policy->vehicle_id=$vehicle->id;


        $x=0;
        switch ($policy->duration) {
            case 'Annual':
                $x=12;
                break;
            case 'Ten Months':
                $x=10;
                break;    
            case 'Semi Annual':
                $x=6;
                break;
            case 'Quartely':
                $x=3;
            case 'Monthly':
                $x=1;
                break;
        }


      $policy->expiry_date = Carbon::createFromFormat('m/d/Y',$request['effective_date'])->addMonths($x);



       //$vehicle=Vehicle::find($request['vehicle']);
       $policy->edited_by=auth()->id();
       $policy->save();

        session()->flash('policy-create-message','policy edited successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('customer.policies.index',['customer'=>$policy->customer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cancel(Customer $customer,Policy $policy,Request $request){
        $this->validate($request,[
          'effective_date'=>'required'
          ]);
        $effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);

        $paymentSchedules=$policy->paymentSchedules()->whereDate('due_date','>',$effective_date)->get();

        foreach($paymentSchedules as $paymentSchedule){
          $paymentSchedule->lifeline_status="cancelled";
          $paymentSchedule->save();
        }

        $policy->status='cancelled';
        $policy->save();

        session()->flash('policy-cancel-message','policy Cancelled successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('customer.policies.index',['customer'=>$customer]);  


    }
    /*public function suspend(Customer $customer,Policy $policy,Request $request){

        $this->validate($request,[
            'effective_date'=>'required'
            ]);
        $effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);

        $paymentSchedules=$policy->paymentSchedules()->whereDate('due_date','>',$effective_date)->get();

        foreach($paymentSchedules as $paymentSchedule){
          $paymentSchedule->lifeline_status="suspended";
          $paymentSchedule->save();
        }

        $policy->status='suspended';
        $policy->save();

        session()->flash('message-warning','policy Suspended successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('customer.policies.index',['customer'=>$customer]); 

    }*/
    public function activate(Customer $customer,Policy $policy,Request $request){

      $this->validate($request,[
            'effective_date'=>'required'
            ]);
        $effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);

        $paymentSchedules=$policy->paymentSchedules()->whereDate('due_date','>',$effective_date)->get();

        foreach($paymentSchedules as $paymentSchedule){
          $paymentSchedule->lifeline_status="active";
          $paymentSchedule->save();
        }

        $policy->status='active';
        $policy->save();

        session()->flash('message-active','policy Activate successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('customer.policies.index',['customer'=>$customer]); 


    }

    /*public function sustain(Customer $customer,Policy $policy,Request $request){

      $this->validate($request,[
            'effective_date'=>'required'
            ]);
        $effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);

        $paymentSchedules=$policy->paymentSchedules()->whereDate('due_date','>',$effective_date)->get();

        foreach($paymentSchedules as $paymentSchedule){
          $paymentSchedule->lifeline_status="active";
          $paymentSchedule->save();
        }

        $policy->status='active';
        $policy->save();

        session()->flash('message-sustain','policy Sustained successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('customer.policies.index',['customer'=>$customer]); 


    }*/
}
