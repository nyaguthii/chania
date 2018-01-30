<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\domain\PaymentSchedule;
//use App\domain\Payment;
use App\domain\Receipt;
use App\domain\Customer;
use App\domain\Credit;
use App\Http\Requests\PaymentRequest;
use Carbon\Carbon;
use App\domain\BankTransaction;
use App\domain\VehicleCredit;
use DataTables;

class PrePaymentsController extends Controller
{
	
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Customer $customer){

        $policies= $customer->policies()->orderBy('id', 'desc')->get();

		return view('prepayments.index',compact('customer','policies'));

	}
	public function show(){

	}
    public function edit(Customer $customer,Payment $payment){

        return view('prepayments.edit',['payment'=>$payment]);

    }
    public function update(PaymentSchedule $paymentSchedule){
        
        $paymentSchedule->status="open";
        $credit=$paymentSchedule->credit;
        $credit->delete();

        $paymentSchedule->save();
                 
         session()->flash('message','payment reversed successfully');
         $customer=$paymentSchedule->policy->customer;
      //return view('policies.show',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);
       return redirect()->route('customer.policies.generate',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);

    }
    public function create(PaymentSchedule $paymentSchedule){

    	//dd($paymentSchedule);

    	return view('prepayments.create',compact('paymentSchedule'));
    }

    public function store(PaymentSchedule $paymentSchedule,PaymentRequest $paymentRequest){
 

         

        $paymentSchedule->status="paid";

        
        //$vehicleCredit=new VehicleCredit();
        //$vehicleCredit->amount=$paymentSchedule->amount;
        //$vehicleCredit->description="Agency Payment for ".$paymentSchedule->policy->policy_no." date Due ".$paymentSchedule->due_date;
        //$vehicleCredit->transaction_date=Carbon::createFromFormat('m/d/Y',$paymentRequest['transaction_date']);
        //$vehicleCredit->vehicle_id=$paymentSchedule->policy->vehicle->id;
        //$vehicleCredit->type="Auto";
        //$vehicleCredit->statement_impact="minus";
        $credit=new Credit();
        $credit->amount=$paymentSchedule->amount;
        $credit->description="Agency Payment for ".$paymentSchedule->policy->policy_no." date Due ".$paymentSchedule->due_date;
        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$paymentRequest['transaction_date']);
        $credit->vehicle_id=$paymentSchedule->policy->vehicle->id;
        $credit->created_by=auth()->id();
        $credit->customer_id=$paymentSchedule->policy->customer->id;
        $credit->type="INSURANCE";

        $paymentSchedule->credit()->save($credit);
        $paymentSchedule->edited_by=auth()->id();
        $paymentSchedule->save();


        //$vehicle->vehicleCredits()->save($vehicleCredit);

      session()->flash('message','payment created successfully');
      $customer=$paymentSchedule->policy->customer;
      //return view('policies.show',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);
      return redirect()->route('customer.policies.generate',['customer'=>$customer,'policy'=>$paymentSchedule->policy]);
    }

    public function showDailyForm(){


        $today=Carbon::now()->toDateString();
        //$payments=DB::table('payments')->whereDate('created_at',$today)->get();


         /*$creditPayments=DB::table('credit_payments')
         ->whereDate('transaction_date',$today)
         ->select('id','transaction_date','place','amount');*/

         $payments=DB::table('payments')
         ->whereDate('transaction_date',$today)
         ->select('id','transaction_date','paid_from','amount')
         ->get();

        //dd($payments);
        

        return view('prepayments.daily',['payments'=>$payments]);
    }

    public function getDaily(Request $request){

        $this->validate($request,[
          'date'=>'required|date'
            ]);

        $date=Carbon::createFromFormat('m/d/Y',$request['date'])->toDateString();
        //$payments=Payment::whereDate('transaction_date',$date)->get();
        /*$creditPayments=DB::table('credit_payments')
         ->whereDate('transaction_date',$date)
         ->select('id','transaction_date','place','amount');*/

         $payments=DB::table('payments')
         ->whereDate('transaction_date',$date)
         ->select('id','transaction_date','paid_from','amount')
         ->get();

        
        return view('prepayments.daily',['payments'=>$payments]);

    }

    public function showRangeForm(){

     return view('prepayments.range');
   

    }
    public function getRange(Request $request){



        $this->validate($request,[
           'start_date'=>'required|date|before:end_date',
            'end_date'=>'required|date|after:start_date',
            ]);
        $start_date=Carbon::createFromFormat('m/d/Y',$request['start_date']);
        $end_date=Carbon::createFromFormat('m/d/Y',$request['end_date']);
       

        if($request['is_member']=="all"){

            $dailyPayments=DB::table('payments')
             ->whereBetween('transaction_date',[$start_date,$end_date])
             ->select('transaction_date','amount')
             ->get();
                //$payments=DB::table('payments')->whereBetween('transaction_date',[$start_date,$end_date])->paginate(20);

        }else{

            //$payments=DB::table('payments')->whereBetween('transaction_date',[$start_date,$end_date])->paginate(20);
            
            $dailyPayments=DB::table('payments')
             ->whereBetween('transaction_date',[$start_date,$end_date])
             ->join('customers','customer_id','=','customers.id')
             ->where('customers.is_member',$request['is_member'])
             ->select('transaction_date','amount')
             ->get();

        


                /*$payments=Payment::whereBetween('transaction_date',[$start_date,$end_date])
                ->whereHas('paymentSchedule',function($query) use ($request){
                    $query->whereHas('policy',function($query) use ($request){
                        $query->whereHas('customer',function($query) use ($request){
                            $query->where('is_member',$request['is_member']);
                        });
                    });
                    
                })
                ->paginate(20);
                dd($payments);*/


        }
        
        
       
        return view('prepayments.range',['payments'=>$payments]);

    }

    public function totalPerDay(){     
        
            $page = isset($_GET['page']) && !empty($_GET['page'])?(int)$_GET['page']:1;
            $items_per_page = 100;
            $offset = ($page-1)*$items_per_page;
            $payments = DB::select( DB::raw("
                select SQL_CALC_FOUND_ROWS transaction_date, payments.transaction_date,payments.paid_from,sum(payments.amount) as total_collection from (
                 select id,transaction_date,paid_from,amount from payments
                ) as payments
                group by paid_from,transaction_date
                order by transaction_date desc

                LIMIT $offset,$items_per_page

                ") );

            $total_rows = DB::select( DB::raw("
                SELECT FOUND_ROWS() as rows

                ") );
            //$bankTransactions=DB::table('bank_transactions')->orderBy('id','desc')->paginate(100);

            

            return view('prepayments.totalperday',['payments'=>$payments,'total_rows'=>$total_rows[0]->rows,'page'=>$page,'items_per_page'=>$items_per_page]);

    }
    public function getTotalPerDayAjax(){
        return view('prepayments.totalajaxperday');
        
    }
    public function totalPerDayAjax(){
        $payments = DB::table('payments')
        ->select(DB::raw("DATE_FORMAT(payments.transaction_date,'%d-%m-%Y') as transaction_date,FORMAT(sum(amount),0) total "))
        ->groupBy('transaction_date')
        ->get();
       
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($payments)
         ->make(true);
    }
        
    public function getTotalPerDayAjax2(){
        return view('prepayments.totalajaxperday2');
        
    }
    public function totalPerDayAjax2(){
        $payments = DB::table('payments')
        ->select(DB::raw("DATE_FORMAT(payments.transaction_date,'%d-%m-%Y') as transaction_date,paid_from,FORMAT(sum(amount),0) total "))
        ->groupBy('transaction_date','paid_from')
        ->orderBy('transaction_date','asc')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($payments)->make(true);
    }
    public function getTotalPerDayAjax3(){
        return view('prepayments.totalajaxperday3');
        
    }
    public function totalPerDayAjax3(){
        $payments = DB::table('payments')
        ->select(DB::raw("DATE_FORMAT(payments.transaction_date,'%d-%m-%Y') as transaction_date,paid_from,type,FORMAT(sum(amount),0) total "))
        ->groupBy('transaction_date','paid_from','type')
        ->orderBy('transaction_date','asc')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($payments)->make(true);
    }
    public function getTotalPerDayAjax4(){
        return view('prepayments.totalajaxperday4');
        
    }
    public function totalPerDayAjax4(){
        $payments = DB::table('payments')
        ->select(DB::raw("DATE_FORMAT(payments.transaction_date,'%d-%m-%Y') as transaction_date,type,FORMAT(sum(amount),0) total "))
        ->groupBy('transaction_date','type')
        ->orderBy('transaction_date','asc')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($payments)->make(true);
    }
}

