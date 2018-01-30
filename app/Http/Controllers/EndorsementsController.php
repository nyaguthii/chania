<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Endorsement as Endorsement;
use App\domain\Policy as Policy;
use App\Http\Requests\EndorsementRequest;


class EndorsementsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Policy $policy,EndorsementRequest $request)
    {


       
       
       $endorsement = Endorsement::create(
        ['type'=>$request['type'],
        'amount'=>$request['amount'],
        'description'=>$request['description'],
        'policy_id'=>$policy->id]
        );


       $total=0;

       foreach($policy->endorsements as $endorsement){

        $total = $total + $endorsement->amount;

       }
       
        $policy->total_premium=$total;
        $policy->status='active';
        $policy->edited_by=auth()->id();
        $policy->save();
       
       
       //dd($policy->customer()->id);
       return redirect()->route('customer.policies.generate', ['customer'=>$policy->customer->id,'policy'=>$policy->id])->with('message','Endorsement created Successfully');


    
       
 }
 public function create(Policy $policy){

  return view('endorsements.create',compact('policy'));
 }
 public function edit(Endorsement $endorsement){

  return view('endorsements.edit',compact('endorsement'));
 }

 public function update(Endorsement $endorsement,EndorsementRequest $request){

      
        $endorsement->type=$request['type'];
        $endorsement->amount=$request['amount'];
        $endorsement->description=$request['description'];
        $endorsement->type=$request['type'];
        $endorsement->save();


       $percentage=$request['commission-percent'];
       $percentageAmount=($percentage*$request['amount'])/100;

       $commission = $endorsement->commission;
       $commission->amount=$percentageAmount;
       $commission->status="open";
       $commission->save();

       $total=0;
       $policy=$endorsement->policy;

       foreach($policy->endorsements as $endorsement){

        $total = $total + $endorsement->amount;

       }
        $policy->total_premium=$total;
        $policy->status='active';
        $policy->edited_by=auth()->id();
        $policy->save();

        return redirect()->route('customer.policies.generate', ['customer'=>$policy->customer->id,'policy'=>$policy->id])->with('message','Endorsement updated Successfully');


  
 }
       
}
