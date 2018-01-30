<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Vehicle;
use App\domain\VehicleCredit;
use Carbon\Carbon;


class VehicleCreditsController extends Controller
{
     public function __construct()
        {
            $this->middleware('auth');
        }
    public function index(Vehicle $vehicle){

    	return view('vehicles.credits.index',['vehicle'=>$vehicle,'customer'=>$vehicle->customer]);

    }
    public function create(Vehicle $vehicle){

    	return view('vehicles.credits.create',['vehicle'=>$vehicle]);

    }
    public function store(Vehicle $vehicle,Request $request){

    	$this->validate($request,[
    		'transaction_date'=>'required',
    		'amount'=>'required|numeric',
    		'description'=>'required'
    		]);

    	$credit = new VehicleCredit();
        $credit->amount=$request['amount'];
        $credit->description=$request['description'];
        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $credit->type="Manual";
        $credit->statement_impact="minus";
        $vehicle->vehicleCredits()->save($credit);


        return redirect()->route('vehicles.credits.index',['vehicle'=>$vehicle->id])->with('message','Due Amount Added');


    }

    public function edit(VehicleCredit $vehicleCredit){

    	return view('vehicles.credits.edit',['vehicleCredit'=>$vehicleCredit]);

    }
    public function update(VehicleCredit $vehicleCredit,Request $request){
    	$this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required|numeric',
            'description'=>'required'

            ]);

        $vehicleCredit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $vehicleCredit->amount=$request['amount'];
        $vehicleCredit->description=$request['description'];

        $vehicleCredit->save();

        return redirect()->route('vehicles.credits.index',['vehicle'=>$vehicleCredit->vehicle->id])->with('message','Credit Amount Edited');
    }
}
