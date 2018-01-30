<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Policy;
use App\domain\Refund;
use Carbon\Carbon;
use DB;
use DataTables;

class RefundsController extends Controller
{
	
  public function __construct()
    {
        $this->middleware('auth');
    }
  public function index(){

		$refunds=Refund::latest()->paginate(30);

		return view('refunds.index',['refunds'=>$refunds]);
	}
    public function create(Policy $policy){
    	return view('refunds.create',['policy'=>$policy]);
    }

    public function store(Policy $policy,Request $request){


    	$this->validate($request,[
    		'amount'=>'required|numeric',
    		'transaction_date'=>'required|date'
    		]);
    	//dd($policy);
      $date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
      $refund = new Refund();
      $refund->amount=$request['amount'];
      $refund->reference=$request['reference'];
      $refund->transaction_date=$date;
      $refund->created_by=auth()->user()->id;
      $policy->refund()->save($refund);

      	session()->flash('message','Refund made successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('customer.policies.show',['customer'=>$policy->customer->id,'policy'=>$policy->id]);  


    }

    public function edit(Refund $refund){



    	return view('refunds.edit',['refund'=>$refund]);


    }

    public function update(Refund $refund,Request $request){
    	$this->validate($request,[
    		'amount'=>'required|numeric',
    		'transaction_date'=>'required|date'
    		]);
    	//dd($policy);
     // $date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);

      $refund->amount=$request['amount'];
      $refund->reference=$request['reference'];
      $refund->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
      $refund->edited_by=auth()->user()->id;
      $refund->save();

      session()->flash('message','Refund edited successfully');
        //return view('policies.index',compact('customer')); 
        return redirect()->route('refunds.indexajax'); 

    }
    public function indexAjax(){
      return view('refunds.index-ajax');
    }
    public function ajax(){
      $refunds = DB::table('refunds')
      ->join('policies','policies.id','=','refunds.policy_id')
      ->join('vehicles','vehicles.id','=','vehicle_id')
      ->join('customers', 'customers.id', '=', 'vehicles.customer_id')                                                         
      ->select(DB::raw("refunds.id,refunds.reference,policies.policy_no,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,FORMAT(refunds.amount,0) amount,vehicles.registration"))
      ->get();

      //$vehicles = Vehicle::select(['id','year','model']);
      
      return Datatables::of($refunds)
      ->addColumn('action', function ($refund) {
          return '
          <div class="pull-right">
          <a href="/refunds/'.$refund->id.'/edit" class="btn btn-xs btn-warning pull-left"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
          </div>
          ';
      })->make(true);
    }
}
