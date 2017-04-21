<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\domain\PaymentSchedule;

class SessionsController extends Controller
{
    public function __construct(){

        $this->middleware('guest')->except('destroy');;
    }

    public function index(){
         $tomorrow = Carbon::tomorrow();
         $paymentSchedules=PaymentSchedule::where('due_date',$tomorrow)->get();
         return view('dashboard',['paymentSchedules'=>$paymentSchedules]);  
    }
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        //

        if(!auth()->attempt(request(['email','password']))){

            return back()->withErrors(['message'=>'Please check your credentials']);
           

        }
        $tomorrow = Carbon::tomorrow();
         $paymentSchedules=DB::table('payment_schedules')->where('due_date',$tomorrow)->get();
         return view('dashboard',['paymentSchedules'=>$paymentSchedules]);

    }

   
    
    public function destroy()
    {
        auth()->logout();
        //return redirect()->route('login');
        return redirect()->action('SessionsController@create');
    }
}
