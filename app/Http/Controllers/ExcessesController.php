<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\domain\Claim;
use App\domain\Excess;

class ExcessesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){}
    public function create(Claim $claim){
    	return view('excess.create',['claim'=>$claim]);
    }
    public function store(Claim $claim,Request $request){

    	$this->validate($request,[
    		'transaction_date'=>'required',
    		'amount'=>'required'
    		]);

    	$excess=new Excess();
    	$excess->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	$excess->amount=$request['amount'];

    	$claim->excess()->save($excess);
    	return redirect()->route('claims.index')->with('message','Excess Added');
    }
    public function edit(Excess $excess){
    	return view('excess.edit',['excess'=>$excess]);
    }

    public function update(Excess $excess,Request $request){

    	$this->validate($request,[
    		'transaction_date'=>'required',
    		'amount'=>'required'
    		]);
    	$excess->transaction_date=Carbon::createFromFormat('m/d/Y',$request['transaction_date']);
    	$excess->amount=$request['amount'];
    	$excess->save();

    	return redirect()->route('claims.index')->with('message','Excess Edited');

    }
}
