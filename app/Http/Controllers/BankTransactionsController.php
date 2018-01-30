<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\domain\BankTransaction;


class BankTransactionsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $bankTransactions=BankTransaction::orderBy('id','desc')->paginate(50);
        return view('banktransactions.index',['bankTransactions'=>$bankTransactions]);
    }
    public function create(){
    	return view('banktransactions.create');
    }

    public function store(Request $request){

    	$this->validate($request,[
    		'transaction_date'=>'required|date',
    		'amount'=>'required|numeric',
    		'type'=>'required',
    		'transaction_id'=>'required',
            'place'=>'required',
    		'description'=>'required'
    		]);

    	$bankTransaction=new BankTransaction();
    	if($request['type']==='Withdraw'){
         $bankTransaction->amount=$request['amount']*(-1);
    	}else{
    	 $bankTransaction->amount=$request['amount'];	
    	}
    	$bankTransaction->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	$bankTransaction->type=$request['type'];
    	$bankTransaction->transaction_id=$request['transaction_id'];
    	$bankTransaction->description=$request['description'];
        $bankTransaction->place=$request['place'];

    	$bankTransaction->save();
    	//dd($bankTransaction);

    	return redirect()->route('banktransactions.index')->with('message','Bank Transaction Successful');

    }
    public function edit(BankTransaction $bankTransaction){
    	//dd($bankTransaction);
    	return view('banktransactions.edit',['bankTransaction'=>$bankTransaction]);

    }

    public function update(BankTransaction $bankTransaction,Request $request){
    	$this->validate($request,[
    		'transaction_date'=>'required',
    		'transaction_id'=>'required',
    		'amount'=>'required',
    		'description'=>'required',
    		'amount'=>'required|numeric',
            'place'=>'required'
    		]);

    	if($request['type']==='Withdraw'){
         $bankTransaction->amount=$request['amount']*(-1);
    	}else{
    	 $bankTransaction->amount=$request['amount'];	
    	}

    	$bankTransaction->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	$bankTransaction->type=$request['type'];
    	$bankTransaction->transaction_id=$request['transaction_id'];
    	$bankTransaction->description=$request['description'];
        $bankTransaction->place=$request['place'];

    	$bankTransaction->save();

    	return redirect()->route('prepayments.totalperday')->with('message','Bank Transaction  Edited');

    }
}
