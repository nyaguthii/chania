<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    protected function redirectTo()
    {
        if(auth()->user()->hasRole('TYRE')){
            return '/tyreshome';
        }elseif(auth()->user()->hasRole('INSURANCE')){
            return '/home';  
        }elseif(auth()->user()->hasRole('CASHIER')){
            return '/tyreshome';  
        }elseif(auth()->user()->hasRole('ADMIN')){
            return '/tyreshome';
        }else{

        }
        
    }
    public function logout()
    {
        auth()->logout();

        //return redirect(\URL::previous());
        return redirect()->route('login');

    }
    protected function credentials(\Illuminate\Http\Request $request)
    {
        //return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'is_active' =>'yes'];
    }

}
