<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Vehicle;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

class VehiclesController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$vehicles=Vehicle::orderBy('id','desc')->paginate(50);
    	return view('vehicles.index',['vehicles'=>$vehicles]);
    }

    public function ajax(){
        $vehicles = DB::table('vehicles')
        ->join('customers', 'customer_id', '=', 'customers.id')
        ->selectRaw("vehicles.id,vehicles.registration,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name")
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($vehicles)
        ->addColumn('action', function ($vehicle) {
            return '<a href="/vehicless/'.$vehicle->id.'/payments/create" class="btn btn-xs btn-primary pull-right"><i class="fa fa-money" aria-hidden="true"></i>  Take Payment</a>';
        })
        ->make(true);
        //return DataTables::of(Vehicle::query())->make(true);

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

        $this->validate($request,[
            'statement_date'=>'required',
            'to_date'=>'required'
            ]);

        //dd($vehicle);
        $date=Carbon::createFromFormat('m/d/Y',$request['statement_date']);
        $todate=Carbon::createFromFormat('m/d/Y',$request['to_date']);

        $dailyPayments=DB::table('daily_payments')
         ->join('daily_receipts','daily_payments.id','=','daily_receipts.daily_payment_id')
         //->whereDate('transaction_date','>=',$date)
         ->whereBetween('transaction_date',[$date,$todate])
         ->where('type','Debit')
         ->where('vehicle_id',$vehicle->id)
         ->select('daily_payments.id','daily_payments.transaction_date','daily_payments.amount','daily_payments.statement_impact','daily_payments.description');

         $dailyRefunds=DB::table('daily_payments')
         //->whereDate('transaction_date','>=',$date)
         ->whereBetween('transaction_date',[$date,$todate])
         ->where('type','Credit')
         ->where('vehicle_id',$vehicle->id)
         ->select('id','transaction_date','amount','statement_impact','description');

         $transactions=DB::table('vehicle_credits')
         //->whereDate('transaction_date','>=',$date)
         ->whereBetween('transaction_date',[$date,$todate])
         ->where('vehicle_id',$vehicle->id)
         ->select('id','transaction_date','amount','statement_impact','description')
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
                

                ") );*/

    	/*$transactions = DB::select( DB::raw("
                select * from (
                     
                     select dp.id,dp.transaction_date,dp.amount,dp.statement_impact,dr.receipt_no from daily_payments dp join daily_receipts dr on dp.id=dr.daily_payment_id 
                     where dp.vehicle_id=$vehicle->id and dp.type='Debit' and DATE(dp.transaction_date) => $date
                     union
                     select id,transaction_date,amount,statement_impact from vehicle_credits 
                     where vehicle_id=$vehicle->id and DATE(transaction_date) => $date
                     union
					 select id,transaction_date,amount,statement_impact from daily_payments 
                     where vehicle_id=$vehicle->id and type='Credit' and DATE(transaction_date) => $date
                     ) st
                     order by st.transaction_date asc

                ") );
*/

        return view('vehicles.statement',['transactions'=>$transactions,'customer'=>$vehicle->customer,'vehicle'=>$vehicle,'total'=>$total,'date'=>$date]);

    }
    public function statementDate(Vehicle $vehicle){
        //dd($vehicle->id);
        return view('vehicles.statement-date',['vehicle'=>$vehicle]);

    }
}
