<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;
use App\domain\Customer;
use Carbon\Carbon;
use PDF;

class SaccoPaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){

        return view('sacco.index');
        
    }
    public function paymentsAjax(){
        $payments = DB::table('payments')
        ->join('customers', 'customer_id', '=', 'customers.id')
        ->select(DB::raw("payments.id,customers.member_id,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,FORMAT(payments.amount,0) as amount,DATE_FORMAT(payments.transaction_date,'%d-%m-%Y') as transaction_date"))
        ->where('payments.type','=','SACCO')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($payments)->make(true);
    }

    public function customers(){

        return view('sacco.customers.index');
    }

    public function customersAjax(){

        $customers = DB::table('customers')
        ->select(DB::raw("id,member_id,contact,concat(firstname,' ',middlename,' ',lastname) as name"))
        ->where('is_member','=','1')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($customers)
        ->addColumn('action', function ($customer) {
            return '
            <div class="pull-right">
            <a href="/sacco/customers/'.$customer->id.'/show" class="btn btn-xs btn-primary pull-left"><i class="fa fa-eye" aria-hidden="true"></i>Show</a>           
            </div>
            ';
        })->make(true);

    }

    public function show(Customer $customer){

        $total_payments=DB::table('payments')
        ->where('customer_id',$customer->id)
        ->where('type','SACCO')
        ->sum('amount');

        return view('sacco.customers.show',['customer'=>$customer,'total_payments'=>$total_payments]);

    }
    public function statementDate(Customer $customer){
        
        return view('sacco.customers.get-statement',['customer'=>$customer]);
    }
    public function statement(Customer $customer,Request $request){
        
                $this->validate($request,[
                    'statement_date'=>'required',
                    'to_date'=>'required'
                    ]);
               
                $date=Carbon::createFromFormat('m/d/Y',$request['statement_date']);
                $todate=Carbon::createFromFormat('m/d/Y',$request['to_date']);
        
        
            
                $transactions=DB::table('payments')
                 ->whereBetween('transaction_date',[$date,$todate])
                 ->where('customer_id',$customer->id)
                 ->where('type','SACCO')
                 ->selectRaw("id,transaction_date,amount,type,description,'add' as statement_impact")
                 ->get();
        
                 
        
                 
        
                 $total=DB::table('payments')
                 ->whereDate('transaction_date','<',$date)
                 ->where('customer_id',$customer->id)
                 ->where('type','SACCO')
                 ->sum('amount');

                 view()->share(['transactions'=>$transactions,'customer'=>$customer,'total'=>$total,'date'=>$date]);

                 $pdf = PDF::loadView('sacco.customers.statement2');
                 $pdf->setPaper('A4', 'Potrait');
                 // download pdf
                 return $pdf->download('sacco.customers.statement2.pdf');
        
                //return view('sacco.customers.statement',['transactions'=>$transactions,'customer'=>$customer,'total'=>$total,'date'=>$date]);
    }
  
}
