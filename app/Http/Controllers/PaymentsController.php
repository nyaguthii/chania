<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\PaymentType;
use App\domain\Vehicle;
use App\domain\Payment;
use Carbon\Carbon;
use DB;
use DataTables;
use App\domain\Receipt;
use App\AfricasTalkingGateway;


class PaymentsController extends Controller
{
    
    protected $gateway;
    public function __construct(AfricasTalkingGateway $gateway)
    {
        $this->middleware(['auth','cashier']);
        $this->gateway=$gateway;
    }
    public function index(){
        
        return view('payments.index');
    }
    public function ajax(){
        $payments = DB::table('payments')
        ->join('customers', 'customer_id', '=', 'customers.id')                                                         
        ->select(DB::raw("payments.id,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,FORMAT(payments.amount,0) amount,DATE_FORMAT(payments.transaction_date,'%d-%m-%Y') as transaction_date"))
        ->where('payments.created_by','=',auth()->id())
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($payments)
        ->addColumn('action', function ($payment) {
            return '
            <div class="pull-right">
            <a href="/receipts/'.$payment->id.'/show" class="btn btn-xs btn-primary pull-left"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
            <a href="/payments/'.$payment->id.'/edit" class="btn btn-xs btn-warning pull-left"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>
            <a href="/payments/'.$payment->id.'/delete" class="btn btn-xs btn-danger pull-left"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
            </div>
            ';
        })->make(true);
    }
    
    public function create(Vehicle $vehicle){

        $paymentTypes=PaymentType::all();
        return view('payments.create',['vehicle'=>$vehicle,'paymentTypes'=>$paymentTypes]);
    }

    public function store(Vehicle $vehicle,Request $request){
        $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required|integer',
            'from'=>'required'
        ]);

        $payment = new Payment();
        $payment->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $payment->amount=$request['amount'];
        $payment->paid_from=$request['from'];
        $payment->created_by=auth()->id();
        $payment->type=$request['type'];
        $payment->vehicle_id=$vehicle->id;

        $message="Payment of Kshs ".number_format($request['amount'],0)." for".$request['type']." By ".$vehicle->registration." Date: ".Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        
        $customer=$vehicle->customer;
        if($customer->payments()->save($payment)){

            $receipt = new Receipt();
            $receipt->amount=$payment->amount;
            $payment->receipt()->save($receipt);
            try 
            { 
              // Thats it, hit send and we'll take care of the rest.
              //$this->gateway->sendMessage($customer->contact, $message);
            }
            catch ( AfricasTalkingGatewayException $e )
            {
              echo "Encountered an error while sending: ".$e->getMessage();
            }

            return redirect()->route('payments.index')->with('message','Payment created');

        }else{
            return back()->withInput();
        }

    }

    public function edit(Payment $payment){

        $paymentTypes=PaymentType::all();
        return view('payments.edit',['payment'=>$payment,'paymentTypes'=>$paymentTypes]);

    }

    public function update(Request $request,Payment $payment){

        $this->validate($request,[
            'transaction_date'=>'required',
            'amount'=>'required|integer',
            'from'=>'required'
        ]);

        $payment->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $payment->amount=$request['amount'];
        $payment->paid_from=$request['from'];
        $payment->edited_by=auth()->id();
        $payment->type=$request['type'];
        
        $receipt=$payment->receipt;
        $receipt->amount=$request['amount'];
        
        if($payment->save()){
            $receipt->save();
            return redirect()->route('payments.index')->with('message','Payment Edited Successfully');
        }else{
            return back()->withInput();  
        }

    }
    public function delete(Payment $payment){

        return view('payments.delete',['payment'=>$payment]);

    }
    public function destroy(Payment $payment){

        $receipt=$payment->receipt;

        $receipt->delete();
        $payment->delete();
        return redirect()->route('payments.index')->with('message','Payment Deleted Successfully');

    }

    public function dailyPayments(){
        return view('payments.shop.daily');
    }
    public function dailyPaymentsAjax(){

        $payments = DB::table('payments')
        ->join('customers', 'customer_id', '=', 'customers.id')
        ->select(DB::raw("payments.id,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,payments.amount,DATE_FORMAT(payments.transaction_date,'%d-%m-%Y') as transaction_date"))
        ->where('type','=','TYRE')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($payments)->make(true);

    }
    public function excess(){
        return view('payments.excess');
    }
    public function excessAjax(){

        $payments = DB::table('payments')
        ->join('customers', 'customer_id', '=', 'customers.id')
        ->join('vehicles','vehicle_id','=','vehicles.id')
        ->select(DB::raw("payments.id,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name,payments.amount,vehicles.registration,DATE_FORMAT(payments.transaction_date,'%d-%m-%Y') as transaction_date"))
        ->where('payments.type','=','EXCESS')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($payments)->make(true);

    }

}
