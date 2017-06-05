<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\domain\Policy;
use App\domain\Vehicle;

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

    public function expired(){

        $today=Carbon::now()->toDateString();
        $policies=Policy::where('expiry_date','<=',$today)->orderBy('id','desc')->paginate(50);
        return view('policies.status',['policies'=>$policies]);

    }
    
}
