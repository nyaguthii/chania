<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Vehicle;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehiclesController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$vehicles=Vehicle::orderBy('id','desc')->paginate(50);
    	//dd($vehicles);
    	return view('vehicles.index',['vehicles'=>$vehicles]);
    }

    public function find(Request $request){
    	$this->validate($request,[
    		'registration'=>'required'
    		]);
    	$vehicles=Vehicle::where('registration',$request['registration'])->paginate(50);
        return view('vehicles.index',['vehicles'=>$vehicles]);

    }

    public function overpayments(){

    $vehicles=Vehicle::orderBy('id','desc')->paginate(50);

    return view('vehicles.reports.overpayments',['vehicles'=>$vehicles]);
    }
    public function underpayments(){

    $vehicles=Vehicle::orderBy('id','desc')->paginate(50);

    return view('vehicles.reports.underpayments',['vehicles'=>$vehicles]);
    }
    

    public function statement(Vehicle $vehicle,Request $request){

        //dd($vehicle);
        $date=Carbon::createFromFormat('m/d/Y',$request['statement_date']);

        $dailyPayments=DB::table('daily_payments')
         ->whereDate('transaction_date','>=',$date)
         ->where('type','Debit')
         ->where('vehicle_id',$vehicle->id)
         ->select('id','transaction_date','amount','statement_impact');

         $dailyRefunds=DB::table('daily_payments')
         ->whereDate('transaction_date','>=',$date)
         ->where('type','Credit')
         ->where('vehicle_id',$vehicle->id)
         ->select('id','transaction_date','amount','statement_impact');

         $transactions=DB::table('vehicle_credits')
         ->whereDate('transaction_date','>=',$date)
         ->where('vehicle_id',$vehicle->id)
         ->select('id','transaction_date','amount','statement_impact')
         ->union($dailyPayments)
         ->union($dailyRefunds)
         ->orderBy('transaction_date','asc')
         ->get();

         $dailyPaymentsTotal=DB::table('daily_payments')
         ->whereDate('transaction_date','<',$date)
         ->where('type','Debit')
         ->where('vehicle_id',$vehicle->id)
         ->sum('amount');

        $dailyRefundsTotal=DB::table('daily_payments')
         ->whereDate('transaction_date','<',$date)
         ->where('type','Credit')
         ->where('vehicle_id',$vehicle->id)
         ->sum('amount');
        $creditsTotal=DB::table('vehicle_credits')
         ->whereDate('transaction_date','<',$date)
         ->where('vehicle_id',$vehicle->id)
         ->sum('amount');

        $total=$dailyPaymentsTotal-($dailyRefundsTotal+$creditsTotal);

        /*$total=DB::select( DB::raw("
                select sum('amount') from (
                     
                     select amount*-1 from vehicle_credits 
                     where vehicle_id=$vehicle->id where DATE(transaction_date) < $date
                     union
                     select amount,statement_impact from daily_payments 
                     where vehicle_id=$vehicle->id and type='Debit' where DATE(transaction_date) < $date
                     union
                     select amount*-1,statement_impact from daily_payments 
                     where vehicle_id=$vehicle->id and type='Credit' where DATE(transaction_date) < $date
                     )
                

                ") );

    	$transactions = DB::select( DB::raw("
                select * from (
                     
                     select id,transaction_date,amount,statement_impact from vehicle_credits 
                     where vehicle_id=$vehicle->id where DATE(transaction_date) => $date
                     union
                     select id,transaction_date,amount,statement_impact from daily_payments 
                     where vehicle_id=$vehicle->id and type='Debit' where DATE(transaction_date) => $date
                     union
					 select id,transaction_date,amount,statement_impact from daily_payments 
                     where vehicle_id=$vehicle->id and type='Credit' where DATE(transaction_date) => $date
                     ) st
                     order by st.transaction_date asc

                ") );*/


        return view('vehicles.statement',['transactions'=>$transactions,'customer'=>$vehicle->customer,'vehicle'=>$vehicle,'total'=>$total,'date'=>$date]);

    }
    public function statementDate(Vehicle $vehicle){
        //dd($vehicle->id);
        return view('vehicles.statement-date',['vehicle'=>$vehicle]);

    }
}
