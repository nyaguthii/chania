<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\domain\PaymentSchedule;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
            $tomorrow = Carbon::tomorrow();
            $paymentSchedules=PaymentSchedule::where('due_date',$tomorrow)
            ->where('lifeline_status','active')
            ->where('status','open')
            ->get();
            //dd($paymentSchedules);
            
           return view('dashboard.insurance-home',['paymentSchedules'=>$paymentSchedules]);

        
    }
}
