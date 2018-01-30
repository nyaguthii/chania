<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use App\domain\Customer;


class CustomerTyresController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        return view('tyres.customers.index');

    }
    public function show(Customer $customer){
        $total_payments=DB::table('payments')
        ->where('customer_id',$customer->id)
        ->where('type','TYRE')
        ->sum('amount');
        $total_credits=DB::table('credits')
        ->where('customer_id',$customer->id)
        ->where('type','TYRE')
        ->sum('amount');
        return view('tyres.customers.show',['customer'=>$customer,'total_payments'=>$total_payments,'total_credits'=>$total_credits]);

    }
    public function ajax(){
        $customers = DB::table('customers')
        ->select(DB::raw("id,member_id,concat(firstname,' ',middlename,' ',lastname) as name,contact,address"))
        ->get();
        
        return Datatables::of($customers)
        ->addColumn('action', function ($customer) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$customer->id.'/tyres/show" class="btn btn-xs btn-success "><i class="fa fa-eye" aria-hidden="true"></i>Show</a>   
            </div>
            ';
        })->make(true);

    }
}
