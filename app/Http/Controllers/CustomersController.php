<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\services\CustomerService ;
use App\domain\Customer;
use Carbon\Carbon;
use DataTables;
use App\Http\Requests\CustomerForm;
use PDF;

class CustomersController extends Controller
{


    protected $customerService;


    public function __construct(){

        $this->middleware('auth');
        
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
    public function index2(){
        //$customers=Customer::('firstname');
        $customers = Customer::all()->lists('full_name', 'id')->toArray();
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function membersAjax(){
        $customers = DB::table('customers')
        ->select(DB::raw("id,member_id,concat(firstname,' ',middlename,' ',lastname) as name"))
        ->where('is_member','=','1')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($customers)
        ->addColumn('action', function ($customer) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$customer->id.'/payments/create" class="btn btn-xs btn-primary pull-left"><i class="fa fa-print" aria-hidden="true"></i>Take Payment</a>           
            </div>
            ';
        })->make(true);

    }
    public function nonMembersAjax(){
        $customers = DB::table('customers')
        ->select(DB::raw("id,member_id,concat(firstname,' ',middlename,' ',lastname) as name"))
        ->where('is_member','=','0')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($customers)
        ->addColumn('action', function ($customer) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$customer->id.'/payments/create" class="btn btn-xs btn-primary pull-left"><i class="fa fa-print" aria-hidden="true"></i>Take Payment</a>           
            </div>
            ';
        })->make(true);

    }
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
       $this->validate($request,[
        'type' => 'required',
        'firstname' => 'required',
        'middlename' => 'required',
        'address' => 'required',
        'contact' => 'required|size:10',
        'member_id'=>'required|unique:customers',
        'pin' => 'required'

       ]);
       

       
       //Customer::create(request(['type','firstname','lastname','middlename','insured_id','address','contact']));
       $customer=new Customer();
       $customer->type=$request['type'];
       $customer->firstname=$request['firstname'];
       $customer->lastname=$request['lastname'];
       $customer->middlename=$request['middlename'];
       $customer->insured_id=$request['insured_id'];
       $customer->address=$request['address'];
       $customer->contact='+254'.substr($request['contact'],1,10);
       $customer->pin=$request['pin'];
       $customer->member_id=$request['member_id'];
       $customer->is_member=1;
       $customer->created_by=auth()->id();

       $customer->save();
       return redirect()->route('members.index')->with('message','Member Added');
       //return redirect()->action('CustomersController@index',['is_member'=>$customer->is_member])->withInput()->with('message','Customer Created');
    }
    public function store2(Request $request)
    {  
       
        $this->validate($request,[
            'type' => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            'address' => 'required',
            'contact' => 'required|size:10',
            'pin' => 'required'
    
           ]);
       
       
       $customer=new Customer();
       $customer->type=$request['type'];
       $customer->firstname=$request['firstname'];
       $customer->lastname=$request['lastname'];
       $customer->middlename=$request['middlename'];
       $customer->address=$request['address'];
       $customer->contact='+254'.substr($request['contact'],1,10);
       $customer->pin=$request['pin'];
       $customer->is_member=0;
       $customer->created_by=auth()->id();

       $customer->save();
       return redirect()->route('nonmembers.index')->with('message','Nom member Added');
       //return redirect()->action('CustomersController@index',['is_member'=>$customer->is_member])->withInput()->with('message','Customer Created');
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
        
      $this->validate($request,[
        'firstname'=>'required',
        'middlename'=>'required',
        'contact'=>'required|size:10',
        'pin'=>'required',
        'type'=>'required'
      ]);
        
        if($request['is_member'] ==1){
            $is_member = 1;
            $customer->member_id=$request['member_id'];

        }else{
           $is_member = 0;
           $customer->member_id="";
        }
        $customer->firstname=$request['firstname'];
        $customer->lastname=$request['lastname'];
        $customer->type=$request['type'];
        $customer->middlename=$request['middlename'];
        $customer->address=$request['address'];
        $customer->contact='+254'.substr($request['contact'],1,10);
        $customer->pin=$request['pin'];
        $customer->is_member=$is_member;
        $customer->edited_by=auth()->id();

        $customer->save();
        if($is_member==1){    
            return redirect()->route('members.index')->with('message','Member Edited');
        }else if($is_member==0){
            return redirect()->route('nonmembers.index')->with('message','Non Member Edited');
        }
        
        
        
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

        $this->validate($request,[
            'statement_date'=>'required',
            'to_date'=>'required'
            ]);
       
        $date=Carbon::createFromFormat('m/d/Y',$request['statement_date']);
        $todate=Carbon::createFromFormat('m/d/Y',$request['to_date']);


    
        $payments=DB::table('payments')
         ->whereBetween('transaction_date',[$date,$todate])
         ->where('customer_id',$customer->id)
         ->where('type','INSURANCE')
         ->selectRaw("id,transaction_date,amount,type,description,'add' as statement_impact");

         

         $transactions=DB::table('credits')
         ->where('customer_id',$customer->id)
         ->whereBetween('credits.transaction_date',[$date,$todate])
         ->where('type','INSURANCE')
         ->selectRaw("id,transaction_date,amount,type,description,'minus' as statement_impact")
         ->union($payments)
         ->orderBy('transaction_date','asc')
         ->get();

         $paymentsTotal=DB::table('payments')
         ->whereDate('transaction_date','<',$date)
         ->where('customer_id',$customer->id)
         ->sum('amount');

        $creditsTotal=DB::table('credits')
         ->where('customer_id',$customer->id)
         ->whereDate('transaction_date','<',$date)
         ->sum('amount');

        $total=$paymentsTotal-$creditsTotal;
       /* 
        $transactions = DB::select( DB::raw("
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

                ") );
            

  */        
            view()->share(['transactions'=>$transactions,'customer'=>$customer,'total'=>$total,'date'=>$date]);
            //PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            // pass view file
            
            $pdf = PDF::loadView('customers.statement2');
            $pdf->setPaper('A4', 'Potrait');
            // download pdf
            return $pdf->download('customers.statement2.pdf');
        
        //return view('customers.statement',['transactions'=>$transactions,'customer'=>$customer,'total'=>$total,'date'=>$date]);
    }
    public function tyreStatementDate(Customer $customer){
        
        return view('tyres.customers.get-statement',['customer'=>$customer]);
    }
    public function tyreStatement(Customer $customer,Request $request){
        
                $this->validate($request,[
                    'statement_date'=>'required',
                    'to_date'=>'required'
                    ]);
               
                $date=Carbon::createFromFormat('m/d/Y',$request['statement_date']);
                $todate=Carbon::createFromFormat('m/d/Y',$request['to_date']);
        
        
            
                $payments=DB::table('payments')
                 ->whereBetween('transaction_date',[$date,$todate])
                 ->where('customer_id',$customer->id)
                 ->where('type','TYRE')
                 ->selectRaw("id,transaction_date,amount,type,description,'add' as statement_impact");
        
                 
        
                 $transactions=DB::table('credits')
                 ->where('customer_id',$customer->id)
                 ->where('type','TYRE')
                 ->whereBetween('credits.transaction_date',[$date,$todate])
                 ->selectRaw("id,transaction_date,amount,type,description,'minus' as statement_impact")
                 ->union($payments)
                 ->orderBy('transaction_date','asc')
                 ->get();
        
                 $paymentsTotal=DB::table('payments')
                 ->whereDate('transaction_date','<',$date)
                 ->where('customer_id',$customer->id)
                 ->where('type','TYRE')
                 ->sum('amount');
        
                $creditsTotal=DB::table('credits')
                 ->where('customer_id',$customer->id)
                 ->where('type','TYRE')
                 ->whereDate('transaction_date','<',$date)
                 ->sum('amount');
        
                $total=$paymentsTotal-$creditsTotal;

                view()->share(['transactions'=>$transactions,'customer'=>$customer,'total'=>$total,'date'=>$date]);
                //PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                // pass view file
                
                $pdf = PDF::loadView('tyres.customers.statement2');
                $pdf->setPaper('A4', 'Potrait');
                // download pdf
                return $pdf->download('tyres.customers.statement2.pdf');
        
                //return view('tyres.customers.statement',['transactions'=>$transactions,'customer'=>$customer,'total'=>$total,'date'=>$date]);
    }
    public function overPayments(){
        $customers=Customer::paginate(50);
        return view('customers.overpayments.index',['customers'=>$customers]);
    }
    public function underPayments(){
        $customers=Customer::paginate(50);
        return view('customers.underpayments.index',['customers'=>$customers]);
    }
}
