<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\PaymentSchedule;
use DB;
use DataTables;

class CommissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

    	$commissions=PaymentSchedule::where('status','paid')->orderBy('id','desc')->paginate(50);
    	return view('commissions.index',['commissions'=>$commissions]);

    }
    public function monthly(){
        return view('commissions.monthly');
    }
    public function monthlyajax(){
        $paymentSchedules = DB::table('payment_schedules')
        ->join('policies','policies.id','=','payment_schedules.policy_id')                                                         
        ->select(DB::raw("DATE_FORMAT(payment_schedules.due_date, '%Y%m') month,policies.carrier,sum(amount*0.09) as amount"))
        ->where('payment_schedules.status','paid')
        ->groupBy('month','carrier')
        ->get();
        
        return Datatables::of($paymentSchedules)->make(true);

    }
    public function yearly(){
        return view('commissions.yearly');
    }
    public function yearlyajax(){
        $paymentSchedules = DB::table('payment_schedules')
        ->join('policies','policies.id','=','payment_schedules.policy_id')                                                         
        ->select(DB::raw("DATE_FORMAT(payment_schedules.due_date, '%Y') year,policies.carrier,sum(amount*0.09) as amount"))
        ->where('payment_schedules.status','paid')
        ->groupBy('year','carrier')
        ->get();
        
        return Datatables::of($paymentSchedules)->make(true);

    }
}
