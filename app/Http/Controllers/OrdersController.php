<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Order;
use App\domain\Customer;
use App\domain\OrderLine;
use App\domain\Product;
use App\domain\Credit;
use App\domain\MaterialTransaction;
use Carbon\Carbon;
use DB;
use DataTables;
class OrdersController extends Controller
{
    
    public function __construct(){
		$this->middleware('auth');
	}
    
    public function index(){
        $orders=Order::all();
        return view('orders.index',['orders'=>$orders]);

    }
    public function ajax(){

        $orders = DB::table('orders')
        ->join('customers','customer_id','=','customers.id')
        ->selectRaw("orders.id,customers.id as customer_id,concat(customers.firstname,' ',customers.lastname) as customer,DATE_FORMAT(orders.transaction_date, '%d-%m-%Y') as date,format(orders.amount,0) amount,format(orders.total_cost,0) total_cost,format(orders.amount-orders.total_cost,0) as profit")
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($orders)
        ->addColumn('action', function ($order) {
            return '
            <div class="pull-right">
            <a href="/orders/'.$order->id.'/delete" class="btn btn-xs btn-danger pull-right"><i class="fa fa-trash" aria-hidden="true"></i>Delete</a>
            <a href="/orders/'.$order->id.'/edit" class="btn btn-xs btn-warning pull-right"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
            <a href="/orders/'.$order->id.'/show" class="btn btn-xs btn-success pull-right"><i class="fa fa-eye " aria-hidden="true"></i>Show</a>
            </div>
            ';
           // <a href="/customers/'.$order->customer_id.'/payments/create" class="btn btn-xs btn-primary pull-right"><i class="fa fa-money" aria-hidden="true"></i>Payment</a>
        })
        ->make(true);
    }
    
    public function create(){
        
        //$customers = Customer::all()->lists('full_name', 'id')->toArray();
        $customers = DB::table('customers')->selectRaw("id,concat(firstname,' ',middlename,' ',lastname) as name")->pluck('name', 'id')->toArray();
        $products = DB::table('products')->pluck('name','id')->toArray();
        
        return view('orders.create',['customers'=>$customers,'products'=>$products]);
    }

    public function store(Request $request){

        //dd(count($request['quantity']));
        $this->validate($request,[
            'transaction_date'=>'required',
            'customer'=>'required',
            'product'=>'required'
        ]);
        
        //$customer=Customer::find($request['customer']);
       
        $order= new Order();
        $order->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $order->customer_id=$request['customer'];
        //$order->save();
        if($order->save()){
            $total=0;
            $total_cost=0;
            for ($i=0; $i < count($request['quantity']); ++$i) 
            {
                $orderLine= new OrderLine();
                $orderLine->quantity=$request['quantity'][$i];
                $orderLine->sales_price=$request['selling_price'][$i];
                $product=Product::find($request['product'][$i]);
                $orderLine->product_id=$product->id;
                $orderLine->unit_cost=$product->unit_cost;
    
                $order->orderLines()->save($orderLine); 
                $total = $total+($request['quantity'][$i]*$request['selling_price'][$i]);
                $total_cost=$total_cost+($request['quantity'][$i]*$product->unit_cost);
    
                $materialTransaction = new MaterialTransaction();
                $materialTransaction->quantity=$orderLine->quantity;
                $materialTransaction->reference=$order->id;
                $materialTransaction->product_id=$product->id;
                $materialTransaction->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
                $materialTransaction->unit_price=$product->unit_cost;
                $materialTransaction->created_by=auth()->id();
                $materialTransaction->type="Out";
    
    
    
                
                $materialTransaction->save();
                $materialTransaction->orderLine()->save($orderLine);
    
                 
            }
            $order->amount=$total;
            $order->total_cost=$total_cost;
            $order->created_by=auth()->id();
            $order->save();
    
            $credit = new Credit();
            $credit->customer_id=$request['customer'];
            $credit->description="".$order->id."";
    
            $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
            $credit->type="TYRE";
            $credit->amount=$total;
            $credit->created_by=auth()->id();
            $credit->save();
            
            return redirect()->action('OrdersController@index')->with('message','Order Created Successfully');
            

        }else{
            return back()->withInput();
        }

        
        

    }
    public function show(Order $order){
        return view('orders.show',['order'=>$order]);

    }
    public function edit(Order $order){

        $customers = DB::table('customers')->selectRaw("id,concat(firstname,' ',middlename,' ',lastname) as name")->pluck('name', 'id')->toArray();
        $products = DB::table('products')->pluck('name','id')->toArray();

        return view('orders.edit',['customers'=>$customers,'products'=>$products,'order'=>$order]);

    }

    public function update(Order $order,Request $request){

        $orderLines=$order->orderLines;
        foreach($orderLines as $orderLine){
        
            $materialTransaction = $orderLine->materialTransaction;
            //dd($materialTransaction);
            $materialTransaction->delete();
            $orderLine->delete();
        }

            $credit=Credit::where('customer_id',$order->customer_id)->where('description',$order->id)->first();
            $credit->delete();

            $order->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
            $order->customer_id=$request['customer'];
            $order->save();
            
            $total=0;
            $total_cost=0;
        for ($i=0; $i < count($request['quantity']); ++$i) 
        {
            $orderLine= new OrderLine();
            $orderLine->quantity=$request['quantity'][$i];
            $orderLine->sales_price=$request['selling_price'][$i];
            $product=Product::find($request['product'][$i]);
            $orderLine->product_id=$product->id;
            $orderLine->unit_cost=$product->unit_cost;

            $order->orderLines()->save($orderLine); 
            $total = $total+($request['quantity'][$i]*$request['selling_price'][$i]);
            $total_cost=$total_cost+($request['quantity'][$i]*$product->unit_cost);

            $materialTransaction = new MaterialTransaction();
            $materialTransaction->quantity=$orderLine->quantity;
            $materialTransaction->reference=$order->id;
            $materialTransaction->product_id=$product->id;
            $materialTransaction->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
            $materialTransaction->unit_price=$product->unit_cost;
            $materialTransaction->created_by=auth()->id();
            $materialTransaction->type="Out";



            
            $materialTransaction->save();
            $materialTransaction->orderLine()->save($orderLine);

             
        }
        $order->amount=$total;
        $order->total_cost=$total_cost;
        $order->updated_by=auth()->id();
        $order->save();

        $credit = new Credit();
        $credit->customer_id=$request['customer'];
        $credit->description="".$order->id."";

        $credit->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $credit->type="TYRE";
        $credit->amount=$total;
        $credit->created_by=auth()->id();
        $credit->save();

        return redirect()->action('OrdersController@index')->with('message','Order Updated Successfully');


    }
    public function destroy(Order $order){

        $orderLines=$order->orderLines;
        foreach($orderLines as $orderLine){
            $materialTransaction=$orderLine->materialTransaction;
            $materialTransaction->delete();
            $orderLine->delete();

        }
        $credit=Credit::where('customer_id',$order->customer_id)->where('description',$order->id)->first();
        $credit->delete();
        $order->delete();

        return redirect()->action('OrdersController@index')->with('message','Order deleted Successfully');
    }
    public function delete(Order $order){

        return view('orders.delete',['order'=>$order]);

    }
    public function dailySalesAjax(){
        $sales = DB::table('orders')
        ->select(DB::raw("DATE_FORMAT(orders.transaction_date, '%d-%m-%Y') as transaction_date,FORMAT(sum(amount),0) as amount"))
        ->groupBy('transaction_date')
        ->get();

        return Datatables::of($sales)->make(true);
    }
    public function dailySales(){
        //$sales=DB:table('orders')->
        return view('orders.daily-sales');
        
    }
    public function dailyPayments(){
        return view('orders.daily-payments');
    }
    public function dailyPaymentsAjax(){

        $payments = DB::table('payments')
        ->select(DB::raw("DATE_FORMAT(payments.transaction_date, '%d-%m-%Y') as transaction_date,FORMAT(sum(amount),0) as amount"))
        ->where('type','=','TYRE')
        ->groupBy('transaction_date')
        ->get();

        return Datatables::of($payments)->make(true);

    }
}
