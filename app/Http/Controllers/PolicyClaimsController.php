<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Policy;
use Carbon\Carbon;
use App\domain\Claim;
use DB;
use DataTables;

class PolicyClaimsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

    	$claims=Claim::orderBy('id','desc')->paginate(50);
		return view('claims.index',['claims'=>$claims]);
    }
    public function ajax(){
        $claims = DB::table('claims')
        ->join('policies','policies.id','=','claims.policy_id')
        ->join('vehicles','vehicles.id','=','vehicle_id')
        ->join('customers', 'customers.id', '=', 'vehicles.customer_id')                                                         
        ->select(DB::raw("claims.id,DATE_FORMAT(claims.accident_date,'%d-%m-%Y') as accident_date,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,vehicles.registration,policies.policy_no,claims.driver_contact,claims.driver_name"))
        ->get();
  
        //$vehicles = Vehicle::select(['id','year','model']);
        return Datatables::of($claims)->addColumn('action', function ($claim) {
            return '
            <div class="pull-right">
            <a href="#" class="btn btn-xs btn-warning pull-left"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
            <a href="#" class="btn btn-xs btn-primary pull-left"><i class="fa fa-eye" aria-hidden="true"></i>Show</a>
            </div>
            ';
        })
        ->make(true);
    }
    public function indexAjax(){
        return view('claims.index-ajax');
    }


    public function create(Policy $policy){

    	return view('claims.create',['policy'=>$policy]);

    }
    public function edit(Claim $claim){

    	return view('claims.edit',['claim'=>$claim]);

    }

    public function store(Policy $policy,Request $request){

    	$this->validate($request,[
    		'transaction_date'=>'required',
    		'description'=>'required',
            'accident_date'=>'required',
            'driver_contact'=>'numeric',
            'driver_name'=>'required'
    		]);

    	$claim=new Claim();
    	$claim->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	$claim->description=$request['description'];
        $claim->accident_date=Carbon::createFromFormat('m/d/Y',$request['accident_date']);
        $claim->driver_name=$request['driver_name'];
        $claim->driver_contact=$request['driver_contact'];
        $claim->created_by=auth()->user()->id;

    	$policy->claims()->save($claim);

    	return redirect()->route('claims.index')->with('message','Claim Added');
    }
    public function update(Claim $claim,Request $request){

    	$this->validate($request,[
    		'transaction_date'=>'required',
            'accident_date'=>'required',
            'driver_name'=>'required',
            'driver_contact'=>'required',
    		'description'=>'required'
    		]);

    	$claim->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $claim->accident_date=Carbon::createFromFormat('m/d/Y',$request['accident_date']);
    	$claim->description=$request['description'];
        $claim->driver_name=$request['driver_name'];
        $claim->driver_contact=$request['driver_contact'];
        $claim->edited_by=auth()->user()->id;

    	$claim->save();
    	return redirect()->route('claims.index')->with('message','Claim Edited');

    }
}
