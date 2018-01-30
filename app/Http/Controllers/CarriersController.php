<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Carrier;

class CarriersController extends Controller
{
   
   public function __construct()
    {
        $this->middleware('auth');
    }

   public function index(){

   	$carriers=Carrier::all();
    	return view('carriers.index',['carriers'=>$carriers]);
   }

    public function create(){
    	return view('carriers.create');

    }

    public function store(Request $request){
    	$this->validate($request,[
    		'name'=>'required'
    		]);

    	$carrier=new Carrier();
    	$carrier->name=$request['name'];
    	$carrier->save();

    	return redirect()->route('carriers.index')->with('message','Carrier Added');

    }
    public function delete(Carrier $carrier){

        $carrier->delete();
        return redirect()->route('carriers.index')->with('message','Carrier Deleted');

    }
}
