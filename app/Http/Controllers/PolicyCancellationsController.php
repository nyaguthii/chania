<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Policy;
use Carbon\Carbon;
use App\domain\Cancellation;
use DB;
use DataTables;


class PolicyCancellationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
    	
    	$cancellations=Cancellation::orderBy('id','desc')->paginate(50);
		return view('cancellations.index',['cancellations'=>$cancellations]);

    }
    public function ajax(){
        $cancellations = DB::table('cancellations')
        ->join('policies','policies.id','=','cancellations.policy_id')
        ->join('vehicles','vehicles.id','=','vehicle_id')
        ->join('customers', 'customers.id', '=', 'vehicles.customer_id')                                                         
        ->select(DB::raw("cancellations.id,DATE_FORMAT(cancellations.effective_date,'%d-%m-%Y') as effective_date,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,vehicles.registration,policies.policy_no"))
        ->where('cancellations.status','Active')
        ->get();
  
        //$vehicles = Vehicle::select(['id','year','model']);
        return Datatables::of($cancellations)->make(true);

    }
    public function indexAjax(){
        return view('cancellations.index-ajax');
    }

    public function create(Policy $policy){

    	return view('cancellations.create',['policy'=>$policy]);
    }

    public function store(Policy $policy,Request $request){

    	$this->validate($request,[
    			'effective_date'=>'required'
    		]);

    	$cancellation=new Cancellation();
    	$cancellation->effective_date=Carbon::createFromFormat('m/d/Y',$request['effective_date']);

    	$cancellation->status="Active";
    	$policy->status="cancelled";

    	$paymentSchedules=$policy->paymentSchedules;

        foreach($paymentSchedules as $paymentSchedule){
            $due_date=Carbon::createFromFormat('Y-m-d',$paymentSchedule->due_date);
            if($cancellation->effective_date->between($due_date,$due_date->addMonth()) or $due_date->gt($cancellation->effective_date)){
                $paymentSchedule->lifeline_status="cancelled";
                $paymentSchedule->save();
            }

            
        }

    	$policy->cancellation()->save($cancellation);
    	$policy->save();

    	return redirect()->route('customer.policies.show',['customer'=>$policy->customer->id,'policy'=>$policy->id])->with('message','Suspension created Successfully');


    }
    public function activate(Policy $policy){
    	$cancellation=$policy->cancellation;

    	$paymentSchedules=$policy->paymentSchedules;

        foreach($paymentSchedules as $paymentSchedule){
            
                $paymentSchedule->lifeline_status="active";
                $paymentSchedule->save();
            }
        $policy->status="active";
        $cancellation->delete();

        $policy->save();

        return redirect()->route('customer.policies.show',['customer'=>$policy->customer->id,'policy'=>$policy->id])->with('message','Policy Activated Successfully');

    }

}
