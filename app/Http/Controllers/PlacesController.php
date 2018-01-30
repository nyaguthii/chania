<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Place;

class PlacesController extends Controller
{
    
    public function __construct(){
		$this->middleware('auth');
	}
    public function index(){

        $places=Place::paginate(10);
    	return view('places.index',['places'=>$places]);

    }

    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|unique:places',
            'description'=>'required'
        ]);
        
        $place=new Place();
        $place->name=strtoupper($request['name']);
        $place->description=$request['description'];
        $place->save();

        return redirect()->route('places.index')->with('message','Place create Successfully');


    }
    public function create(){
        return view('places.create');
    }
    public function edit(Place $place){

        return view('places.edit',['place'=>$place]);

    }
    public function update(Request $request,Place $place){
        $this->validate($request,[
            'name'=>'required',
            'description'=>'required'
        ]);
        
        $place->name=strtoupper($request['name']);
        $place->description=$request['description'];
        $place->save();

        return redirect()->route('places.index')->with('message','Place edited Successfully');


    }
    public function delete(Place $place){

        $place->delete();

        return redirect()->route('places.index')->with('message','Place Deleted Successfully');  

    }
}
