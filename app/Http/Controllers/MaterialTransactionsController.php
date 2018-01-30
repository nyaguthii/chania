<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Product;
use App\domain\MaterialTransaction;
use Carbon\Carbon;
use DB;
use DataTables;
class MaterialTransactionsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        $materialTransactions=MaterialTransaction::all();
        return view('material-transactions.index',['materialTransactions'=>$materialTransactions]);

    }
    public function ajax(){
    $transactions = DB::table('material_transactions')
    ->join('products', 'product_id', '=', 'products.id')
    ->select(DB::raw("material_transactions.id,products.name,material_transactions.type,format(material_transactions.quantity,0) quantity,
    format(material_transactions.unit_price,0) unit_price,DATE_FORMAT(material_transactions.transaction_date,'%d-%m-%Y') as transaction_date"))
    ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($transactions)
        ->addColumn('action', function ($transaction) {
            return '
            <div class="pull-right">
            <a href="/inouts/'.$transaction->id.'/edit" class="btn btn-xs btn-warning pull-left"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>
            <a href="/inouts/'.$transaction->id.'/delete" class="btn btn-xs btn-danger pull-left"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
            </div>
            ';
        })->make(true);
    }
    public function create(Product $product){

        return view('material-transactions.create',['product'=>$product]);

    }

    public function store(Product $product,Request $request){
        $this->validate($request,[
            'reference'=>'required',
            'type'=>'required',
            'unit_price'=>'required|integer',
            'quantity'=>'required|integer',
            'transaction_date'=>'required'
        ]);
        
        $materialTransaction = new MaterialTransaction();
        $materialTransaction->reference=$request['reference'];
        $materialTransaction->type=$request['type'];
        $materialTransaction->quantity=$request['quantity'];
        $materialTransaction->unit_price=$request['unit_price'];
        $materialTransaction->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $materialTransaction->created_by=auth()->id();
        
        $product->materialTransactions()->save($materialTransaction);
        return redirect()->route('products.index')->with('message','Quantity Added');

    }
    public function edit(MaterialTransaction $materialTransaction){

        return view('material-transactions.edit',['materialTransaction'=>$materialTransaction]);

    }
    public function update(Request $request,MaterialTransaction $materialTransaction){

        $this->validate($request,[
            'reference'=>'required',
            'type'=>'required',
            'unit_price'=>'required|integer',
            'quantity'=>'required|integer',
            'transaction_date'=>'required'
        ]);

        $materialTransaction->reference=$request['reference'];
        $materialTransaction->type=$request['type'];
        $materialTransaction->unit_price=$request['unit_price'];
        $materialTransaction->quantity=$request['quantity'];
        $materialTransaction->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
        $materialTransaction->edited_by=auth()->id(); 
        $materialTransaction->save();

        return redirect()->route('inout.index')->with('message','Edited successfully');


    }

    public function delete(MaterialTransaction $materialTransaction){

        $materialTransaction->delete();
        return redirect()->route('material-transactions.index')->with('message','Deleted successfully');


    }
}
