<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Customer;

class TyrePaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Customer $customer){
        $payments=DB::table('payments')
        ->select('id','transaction_date','amount','type')
        ->where('type','TYRE')
        ->where('customer_id',$customer_id)
        ->orderBy('id','desc')
        ->paginate(50);

        return view('tyres.payments.index',['payments'=>$payments]);
    }

    
}
