<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\PaymentType;

class PaymentTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        $paymentTypes=PaymentType::all();
        return view('paymenttypes.index',['paymentTypes'=>$paymentTypes]);
    }
    public function create(Request $request){
        
        return view('paymenttypes.create');
    }

    public function edit(PaymentType $paymentType){

        return view('paymenttypes.edit',['paymentType'=>$paymentType]);
        
    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required'
        ]);
        $paymentType = new PaymentType();
        $paymentType->name=strtoupper($request['name']);
        $paymentType->created_by=auth()->id();
        $paymentType->save();

        return redirect()->route('paymenttypes.index')->with('message','Payment Type Added');

    }


    public function update(Request $request,PaymentType $paymentType){

        $this->validate($request,[
            'name'=>'required'
        ]);

        $paymentType->name=$request['name'];
        $paymentType->update_by=auth()->id();
        $paymentType->save();
        return redirect()->route('paymenttypes.index')->with('message','Payment Type Edited');

    }
    public function destroy(PaymentType $paymentType){
        $paymentType->delete();
        return redirect()->route('paymenttypes.index')->with('message','Payment Type Deleted');

    }
}
