<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $customers=DB::table('customers')->where('is_member','=',$is_member)->paginate(30);
        return view('customers.index',['customers'=>$customers,'is_member'=>$is_member]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerForm $request)
    {  
       if($request['is_member'] == 1){
        $is_member=1;
       }else{
        $is_member=0;
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
       $customer->is_member=$is_member;

       $customer->save();

       return redirect()->action('CustomersController@index',['is_member'=>$customer->is_member])->with('message','Customer Created');
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
    public function update(Customer $customer,CustomerForm $request)
    {
        if($request['is_member'] ==1){
            $is_member = 1;

        }else{
           $is_member = 0; 
        }
        $customer->firstname=$request['firstname'];
        $customer->lastname=$request['lastname'];
        $customer->type=$request['type'];
        $customer->middlename=$request['middlename'];
        $customer->insured_id=$request['insured_id'];
        $customer->address=$request['address'];
        $customer->contact=$request['contact'];
        $customer->pin=$request['pin'];
        $customer->is_member=$is_member;

        $customer->save();
        return redirect()->action('CustomersController@index')->with('message','Customer Updated');
        
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
            'insured_id'=>'required|numeric'
            ]);

        $customers=DB::table('customers')
        ->where('is_member',$is_member)
        ->where('insured_id',$request['insured_id'])
        ->paginate(30);
        return view('customers.index',['customers'=>$customers,'is_member'=>$is_member]);

    }
}
