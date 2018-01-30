<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Policy;
use App\domain\Suspension;
use App\domain\PaymentSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DataTables;

class PolicySuspensionsController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
		//$suspensions=DB::table('suspensions')->orderBy('id','desc')->paginate(30);
		$suspensions=Suspension::where('status','Active')->orderBy('id','desc')->paginate(50);
		//dd($suspensions);

		return view('suspensions.index',['suspensions'=>$suspensions]);

    }
    public function ajax(){
        $suspensions = DB::table('suspensions')
        ->join('policies','policies.id','=','suspensions.policy_id')
        ->join('vehicles','vehicles.id','=','vehicle_id')
        ->join('customers', 'customers.id', '=', 'vehicles.customer_id')                                                         
        ->select(DB::raw("suspensions.id,DATE_FORMAT(suspensions.effective_date,'%d-%m-%Y') as effective_date,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,vehicles.registration,policies.policy_no"))
        ->where('suspensions.status','Active')
        ->get();
  
        //$vehicles = Vehicle::select(['id','year','model']);
        return Datatables::of($suspensions)->make(true);

    }
    public function indexAjax(){
        return view('suspensions.index-ajax');
    }
    public function create(Policy $policy){

    	return view('suspensions.create',['policy'=>$policy]);
    }

    public function store(Policy $policy,Request $request){

    	$this->validate($request,[
    		'effective_date'=>'required|after_or_equal:today'
    		]);

    	$suspension = new Suspension();
    	$suspension->effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);
    	//$suspension->sustain_date=Carbon::createFromFormat('m/d/Y',$request['sustain_date']);
    	$suspension->status="Active";
    	$policy->status="suspended";
        $policy->suspensions()->save($suspension);

        $paymentSchedules=$policy->paymentSchedules;

        $paymentScheduleStart=$suspension->policy->paymentSchedules()->where('due_date','<=',$suspension->effective_date)->orderBy('due_date','desc')->first();

        //dd($paymentScheduleStart->due_date);


        /*foreach($paymentSchedules as $paymentSchedule){
            $due_date=Carbon::createFromFormat('Y-m-d',$paymentSchedule->due_date);
            if($suspension->effective_date->between($due_date,$due_date->addMonth()) or $due_date->gt($suspension->effective_date)){
                $paymentSchedule->lifeline_status="suspended";
                $paymentSchedule->save();
            }
        }
        */

        foreach($paymentSchedules as $paymentSchedule){
            $due_date=Carbon::createFromFormat('Y-m-d',$paymentSchedule->due_date);
            if($due_date->gt(Carbon::createFromFormat('Y-m-d',$paymentScheduleStart->due_date))){
                $paymentSchedule->lifeline_status="suspended";
                $paymentSchedule->save();
            }
        }

    	$paymentScheduleStart->lifeline_status="suspended";
        $paymentScheduleStart->save();
    	$policy->save();

    	return redirect()->route('customer.policies.show',['customer'=>$policy->customer->id,'policy'=>$policy->id])->with('message','Suspension created Successfully');
;
    }

    public function edit(Suspension $suspension){

    	//dd($suspension->effective_date->format('m/d/Y'));


    	return view('suspensions.edit',['suspension'=>$suspension]);
    }
    public function update(Suspension $suspension,Request $request){

    	$this->validate($request,[
    		'effective_date'=>'required'
    		]);
    	$suspension->effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);
    	$suspension->save();
    	return redirect()->route('suspensions.index')->with('message','Suspension edited Successfully');


    }
    public function sustain(Suspension $suspension,Request $request){

        $this->validate($request,[
            'sustain_date'=>'required|after:effective_date'
            ]);

        //$suspension=Suspension::where('policy_id',$suspension->policy->id)
        //->where('status','Active')
        //->first();
        $startSchedule=$suspension->policy->paymentSchedules()->where('due_date','<=',$suspension->effective_date)->orderBy('due_date','desc')->first();
        //$count=$suspension->policy->paymentSchedules()->where('due_date','>',$paymentSchedule->due_date)->get()->count('*');
        $effective_date=Carbon::createFromFormat('Y-m-d',$suspension->effective_date);
        $sustain_date=Carbon::createFromFormat('m/d/Y',$request['sustain_date']);
        $days_between=$effective_date->diffInDays($sustain_date);

       $dueDate=Carbon::createFromFormat('Y-m-d',$startSchedule->due_date)->addDays($days_between)->addMonth(1);

             /*for($i=0;$i<$count;$i++){

             PaymentSchedule::create([
                'policy_id'=>$paymentSchedule->policy->id,
                'due_date'=>$dueDate,
                'amount'=>$paymentSchedule->amount,
                'status'=>'open',
                'lifeline_status'=>'active'
                ]);
              $dueDate=$dueDate->addMonths(1);

            }*/


            
        //dd($paymentSchedule->due_date);
        

        $paymentSchedules=$suspension->policy->paymentSchedules()->where('due_date','>',$startSchedule->due_date)->get();

        foreach($paymentSchedules as $paymentSchedule){
            
                $paymentSchedule->due_date=$dueDate;
                $paymentSchedule->lifeline_status="active";
                $paymentSchedule->save();
                $dueDate=$dueDate->addMonths(1);
            
        }
        
        $startSchedule->lifeline_status="active";
        $startSchedule->save();

        $suspension->status="Inactive";
        //$suspension->policy->status="active";
        $policy=$suspension->policy;
        $policy->status="active";
        $expiry_date=$policy->expiry_date;
        $policy->expiry_date=$expiry_date->addDays($days_between);
        $suspension->save();
        $suspension->policy->save();
        $policy->save();


        return redirect()->route('customer.policies.show',['customer'=>$suspension->policy->customer->id,'policy'=>$suspension->policy->id])->with('message','Suspension Sustained Successfully');

 

    }
    public function show(Policy $policy){
        $suspension=Suspension::where('policy_id',$policy->id)->where('status','Active')->first();
        //$suspension=DB::table('suspensions')->where('policy_id',$policy->id)->get();
        return view('suspensions.show',['suspension'=>$suspension]);
    }
}