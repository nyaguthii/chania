<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Policy;
use App\domain\Vehicle;
use DB;
use DataTables;
use Carbon\Carbon;

class PoliciesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

    	$policies=Policy::where('status','active')->orderBy('id','desc')->paginate(40);

    	return view('policies.index',['policies'=>$policies]);
    }
    public function find(Request $request){

    		$vehicle=Vehicle::where('registration',$request['registration'])->first();
    		
    		$policies=Policy::where('status','active')
    		->where('policy_no',$request['policy_no'])
    		->orWhere('vehicle_id',$vehicle['id'])
    		->orderBy('id','desc')->paginate(40);

           return view('policies.index',['policies'=>$policies]);


    }
    public function status($status){
        
        $policies=Policy::where('status',$status)->orderBy('id','desc')->paginate(40);

        return view('policies.status',['policies'=>$policies]);

    }

    
    public function ajaxActive(){
        $policies = DB::table('policies')
        ->join('vehicles','.vehicles.id','=','policies.vehicle_id')
        ->join('customers', 'customers.id', '=', 'vehicles.customer_id')                                                         
        ->select(DB::raw("customers.id as cid,policies.id,policies.policy_no,DATE_FORMAT(policies.effective_date,'%d-%m-%Y') as effective_date,DATE_FORMAT(policies.expiry_date,'%d-%m-%Y') as expiry_date,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,FORMAT(policies.total_premium,0)as total_premium,vehicles.registration,policies.status"))
        ->where('policies.status','active')
        ->get();
  
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($policies)->addColumn('action', function ($policy) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/generate" class="btn btn-xs btn-primary pull-left"><i class="fa fa-info" aria-hidden="true"></i>Details</a>
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/show" class="btn btn-xs btn-warning pull-left"><i class="fa fa-eye" aria-hidden="true"></i>Show</a>
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/edit" class="btn btn-xs btn-default pull-left"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
            </div>
            ';
        })->make(true);

    }
    public function active(){
        return view('policies.active-ajax');
    }
    public function ajaxCancelled(){
        $policies = DB::table('policies')
        ->join('vehicles','.vehicles.id','=','policies.vehicle_id')
        ->join('customers', 'customers.id', '=', 'vehicles.customer_id')                                                         
        ->select(DB::raw("customers.id as cid,policies.id,policies.policy_no,DATE_FORMAT(policies.effective_date,'%d-%m-%Y') as effective_date,DATE_FORMAT(policies.expiry_date,'%d-%m-%Y') as expiry_date,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,FORMAT(policies.total_premium,0) as total_premium,vehicles.registration,policies.status"))
        ->where('policies.status','cancelled')
        ->get();
  
        //$vehicles = Vehicle::select(['id','year','model']);
        return Datatables::of($policies)->addColumn('action', function ($policy) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/generate" class="btn btn-xs btn-primary pull-left"><i class="fa fa-info" aria-hidden="true"></i>Details</a>
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/show" class="btn btn-xs btn-warning pull-left"><i class="fa fa-eye" aria-hidden="true"></i>Show</a>
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/edit" class="btn btn-xs btn-default pull-left"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
            </div>
            ';
        })->make(true);
    }
    public function cancelled(){
        return view('policies.cancelled-ajax');
    }
    public function ajaxSuspended(){
        $policies = DB::table('policies')
        ->join('vehicles','.vehicles.id','=','policies.vehicle_id')
        ->join('customers', 'customers.id', '=', 'vehicles.customer_id')                                                         
        ->select(DB::raw("customers.id as cid,policies.id,policies.policy_no,DATE_FORMAT(policies.effective_date,'%d-%m-%Y') as effective_date,DATE_FORMAT(policies.expiry_date,'%d-%m-%Y') as expiry_date,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,FORMAT(policies.total_premium,0) as total_premium,vehicles.registration,policies.status"))
        ->where('policies.status','suspended')
        ->get();
  
        //$vehicles = Vehicle::select(['id','year','model']);
        return Datatables::of($policies)->addColumn('action', function ($policy) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/generate" class="btn btn-xs btn-primary pull-left"><i class="fa fa-info" aria-hidden="true"></i>Details</a>
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/show" class="btn btn-xs btn-warning pull-left"><i class="fa fa-eye" aria-hidden="true"></i>Show</a>
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/edit" class="btn btn-xs btn-default pull-left"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
            </div>
            ';
        })->make(true);

    }
    public function suspended(){
        return view('policies.suspended-ajax');
    }
    public function expired(){
        return view('policies.expired-ajax');

    }
    public function ajaxExpired(){

        $today=Carbon::now()->toDateString();
        $policies = DB::table('policies')
        ->join('vehicles','.vehicles.id','=','policies.vehicle_id')
        ->join('customers', 'customers.id', '=', 'vehicles.customer_id')                                                         
        ->select(DB::raw("customers.id as cid,policies.id,policies.policy_no,DATE_FORMAT(policies.effective_date,'%d-%m-%Y') as effective_date,DATE_FORMAT(policies.expiry_date,'%d-%m-%Y') as expiry_date,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,FORMAT(policies.total_premium,0) as total_premium,vehicles.registration,policies.status"))
        ->where('policies.expiry_date','<=',$today)
        ->get();
  
        //$vehicles = Vehicle::select(['id','year','model']);
        return Datatables::of($policies)->addColumn('action', function ($policy) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/generate" class="btn btn-xs btn-primary pull-left"><i class="fa fa-info" aria-hidden="true"></i>Details</a>
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/show" class="btn btn-xs btn-warning pull-left"><i class="fa fa-eye" aria-hidden="true"></i>Show</a>
            <a href="/customers/'.$policy->cid.'/policies/'.$policy->id.'/edit" class="btn btn-xs btn-default pull-left"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
            </div>
            ';
        })->make(true);

    }
    
}
