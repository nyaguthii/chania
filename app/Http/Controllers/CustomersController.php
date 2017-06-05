<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\services\CustomerService ;
use App\domain\Customer;
use Carbon\Carbon;
use App\Http\Requests\CustomerForm;

class CustomersController extends Controller
{


    protected $customerService;


    public function __construct(){

        $this->middleware('auth');
        //$this->customerService=$customerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($is_member)
    {
        //$customers=$customerService->all();
        //$customers=DB::table('customers');
        //$customers=DB::table('customers')->paginate(10);

        $customers=DB::table('customers')->where('is_member','=',$is_member)->paginate(50);
        if($is_member==1){
            return view('customers.index',['customers'=>$customers,'is_member'=>$is_member]);
        }else{
         return view('customers.index2',['customers'=>$customers,'is_member'=>$is_member]);   
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    public function create2()
    {
        return view('customers.create2');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
       $validator = Validator::make($request->all(), [
            'type' => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            'address' => 'required',
            'contact' => 'required',
            'member_id'=>'required|unique:customers',
            'pin' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator)
                        ->withInput();
        }

       
       //Customer::create(request(['type','firstname','lastname','middlename','insured_id','address','contact']));
       $customer=new Customer();
       $customer->type=$request['type'];
       $customer->firstname=$request['firstname'];
       $customer->lastname=$request['lastname'];
       $customer->middlename=$request['middlename'];
       $customer->insured_id=$request['insured_id'];
       $customer->address=$request['address'];
       $customer->contact=$request['contact'];
       $customer->pin=$request['pin'];
       $customer->member_id=$request['member_id'];
       $customer->is_member=1;

       $customer->save();

       return redirect()->action('CustomersController@index',['is_member'=>$customer->is_member])->withInput()->with('message','Customer Created');
    }
    public function store2(Request $request)
    {  
       
       $validator = Validator::make($request->all(), [
            'type'=>'required',
        'address'=>'required',
        'pin'=>'required',
        'contact'=>'required',
        'firstname'=>'required',
        'middlename'=>'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator)
                        ->withInput();
        }
       
       
       $customer=new Customer();
       $customer->type=$request['type'];
       $customer->firstname=$request['firstname'];
       $customer->lastname=$request['lastname'];
       $customer->middlename=$request['middlename'];
       $customer->address=$request['address'];
       $customer->contact=$request['contact'];
       $customer->pin=$request['pin'];
       $customer->is_member=0;

       $customer->save();

       return redirect()->action('CustomersController@index',['is_member'=>$customer->is_member])->withInput()->with('message','Customer Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $date=Carbon::now();
        $paymentSchedules=DB::table('payment_schedules')->select('*','payment_schedules.id as pid','payment_schedules.amount as pamount')
                ->join('policies','payment_schedules.policy_id','=','policies.id')
                ->join('customers','policies.customer_id','=','customers.id')
                ->join('vehicles','policies.vehicle_id','=','vehicles.id')
                ->whereDate('payment_schedules.due_date','<',$date)
                ->where('payment_schedules.status','open')
                ->where('payment_schedules.lifeline_status','active')
                ->where('customers.id',$customer->id)
                ->orderBy('payment_schedules.id','desc')
                ->get();

        return view('customers.show',['customer'=>$customer,'paymentSchedules'=>$paymentSchedules]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Customer $customer,Request $request)
    {
        
        
        $validator = Validator::make($request->all(), [
            'firstname'=>'required',
            'middlename'=>'required',
            'contact'=>'required',
            'pin'=>'required',
            'type'=>'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        if($request['is_member'] ==1){
            $is_member = 1;

        }else{
           $is_member = 0; 
        }
        $customer->firstname=$request['firstname'];
        $customer->lastname=$request['lastname'];
        $customer->type=$request['type'];
        $customer->middlename=$request['middlename'];
        $customer->address=$request['address'];
        $customer->contact=$request['contact'];
        $customer->pin=$request['pin'];
        $customer->member_id=$request['member_id'];
        $customer->is_member=$is_member;

        $customer->save();
        return redirect()->action('CustomersController@index',['is_member'=>$customer->is_member])->with('message','Customer Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function find($is_member,Request $request){

        $this->validate($request,[
            'member_no'=>'required|numeric'
            ]);

        $customers=DB::table('customers')
        ->where('is_member',$is_member)
        ->where('member_id',$request['member_no'])
        ->paginate(50);
        return view('customers.index',['customers'=>$customers,'is_member'=>$is_member]);

    }
    public function statementDate(Customer $customer){

        return view('customers.statement-date',['customer'=>$customer]);

    }

    public function statement(Customer $customer,Request $request){

        $date=Carbon::createFromFormat('m/d/Y',$request['statement_date']);

        $dailyPayments=DB::table('daily_payments')
         ->join('vehicles','vehicles.id','=','daily_payments.vehicle_id')
         ->join('customers','customers.id','=','vehicles.customer_id')
         ->whereDate('daily_payments.transaction_date','>=',$date)
         ->where('daily_payments.type','Debit')
         ->where('vehicles.customer_id',$customer->id)
         ->select('daily_payments.id','daily_payments.transaction_date','daily_payments.amount','daily_payments.statement_impact');

         $dailyRefunds=DB::table('daily_payments')
         ->join('vehicles','vehicles.id','=','daily_payments.vehicle_id')
         ->join('customers','customers.id','=','vehicles.customer_id')
         ->whereDate('daily_payments.transaction_date','>=',$date)
         ->where('daily_payments.type','Credit')
         ->where('vehicles.customer_id',$customer->id)
         ->select('daily_payments.id','daily_payments.transaction_date','daily_payments.amount','daily_payments.statement_impact');

         $transactions=DB::table('vehicle_credits')
         ->join('vehicles','vehicles.id','=','vehicle_credits.vehicle_id')
         ->join('customers','vehicles.customer_id','=','customers.id')
         ->where('customers.id',$customer->id)
         ->whereDate('vehicle_credits.transaction_date','>=',$date)
         ->select('vehicle_credits.id','vehicle_credits.transaction_date','vehicle_credits.amount','vehicle_credits.statement_impact')
         ->union($dailyPayments)
         ->union($dailyRefunds)
         ->orderBy('transaction_date','asc')
         ->get();

         $dailyPaymentsTotal=DB::table('daily_payments')
         ->join('vehicles','vehicles.id','=','daily_payments.vehicle_id')
         ->join('customers','customers.id','=','vehicles.customer_id')
         ->whereDate('daily_payments.transaction_date','<',$date)
         ->where('daily_payments.type','Debit')
         ->where('vehicles.customer_id',$customer->id)
         ->sum('amount');

        $dailyRefundsTotal=DB::table('daily_payments')
         ->join('vehicles','vehicles.id','=','daily_payments.vehicle_id')
         ->join('customers','customers.id','=','vehicles.customer_id')
         ->whereDate('daily_payments.transaction_date','<',$date)
         ->where('daily_payments.type','Credit')
         ->where('vehicles.customer_id',$customer->id)
         ->sum('amount');

        $creditsTotal=DB::table('vehicle_credits')
         ->join('vehicles','vehicles.id','=','vehicle_credits.vehicle_id')
         ->join('customers','vehicles.customer_id','=','customers.id')
         ->where('customers.id',$customer->id)
         ->whereDate('vehicle_credits.transaction_date','<',$date)
         ->sum('amount');

        $total=$dailyPaymentsTotal-($dailyRefundsTotal+$creditsTotal);

        /*$transactions = DB::select( DB::raw("
                select * from (
                     select id,transaction_date,amount,description from credit_payments
                     where customer_id=$customer->id
                     union
                     select p.id,p.transaction_date,p.amount,p.description from payments p
                     join payment_schedules ps on p.payment_schedule_id = ps.id
                     join policies py on ps.policy_id=py.id
                     join customers c on py.customer_id=c.id
                     where p.type='Owner' and c.id=$customer->id
                     union
                     select id,transaction_date,amount,description from credits 
                     where customer_id=$customer->id
                     ) st
                     order by st.transaction_date asc

                ") );*/

        return view('customers.statement',['transactions'=>$transactions,'customer'=>$customer,'total'=>$total,'date'=>$date]);
    }
}
