<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RolesController extends Controller
{   
    public function __construct(){
		$this->middleware('auth');
	}
    public function index(){
        $roles=Role::all();
        return view('roles.index',['roles'=>$roles]);
    }

    public function create(){
        return view('roles.create');
    }
    public function store(Request $request){

        $this->validate($request,[
            'name'=>'required|unique:roles',
            'description'=>'required'
        ]);
        

        $role=new Role();
        $role->name=strtoupper($request['name']);
        $role->description=$request['description'];
        $role->save();

        return redirect()->route('roles.index')->with('message','Role create Successfully');
    }
    public function edit(Role $role){
        return view('roles.edit',['role'=>$role]);

    }
    public function update(Request $request,Role $role){

        $this->validate($request,[
            'name'=>'required',
            'description'=>'required'
        ]);

        $role->name=strtoupper($request['name']);
        $role->description=$request['description'];

        $role->save();
        return redirect()->route('roles.index')->with('message','Role edited Successfully');

    }
    public function delete(Role $role){
                $role->delete();  
                return redirect()->route('roles.index')->with('message','role deleted Successfully');
    }
}
