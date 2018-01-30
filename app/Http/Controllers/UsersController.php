<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UsersController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
	
	public function index(){

    	$users=User::paginate(10);
    	return view('users.index',['users'=>$users]);
	}
	public function create(){
		$roles=Role::all();
		return view('users.create',['roles'=>$roles]);
	}
    public function edit(User $user){
		$roles=Role::all();
    	return view('users.edit',['user'=>$user,'roles'=>$roles]);
	}
	public function changepassword(User $user){
		return view('users.changepassword',['user'=>$user]);

	}
	public function store(Request $request){
		$this->validate($request,[
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'role'=>'required'
		]);
		$user = new User();
		$user->name=$request['name'];
		$user->email=$request['email'];
		$user->password=bcrypt('abc123');
		$user->created_by=auth()->id();
		$user->is_active='yes';
		$user->save();

		//$user->roles()->detach();
		
		foreach($request['role'] as $myrole){
			$role=Role::find($myrole);
			$user->roles()->attach($role);
		}
		
		return redirect()->route('users.index')->with('message','user create Successfully');
	}
	
    public function update(User $user,Request $request){

    	$this->validate($request,[
    		'name' => 'required|max:255',
            'email' => 'required|email|max:255'
    		]);

    	$user->name=$request['name'];
		$user->email=$request['email'];
		//$user->password=bcrypt($request['password']);
		if($request['is_active']==1){
         $isActive="yes";
		}else{
			$isActive="no";
		}
		$user->is_active=$isActive;
		$user->edited_by=auth()->id();
		$user->save();

		
        if(!empty($request['role'])){
			$user->roles()->detach();

			foreach($request['role'] as $myrole){
				$role=Role::find($myrole);
				$user->roles()->attach($role);
			}

		}
		

    	return redirect()->route('users.index')->with('message','user Edited Successfully');

	}
	public function updatepassword(Request $request,User $user){
		$this->validate($request,[
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6'
		]);

		$user->password=bcrypt($request['password']);
		$user->save();
		return redirect()->route('logout');

	}
    public function delete(User $user){
    	foreach($user->roles as $role){
    		$role->delete();
    	}
    	$user->delete();

    	return redirect()->route('users.index')->with('message','user deleted Successfully');

	}
	
}
