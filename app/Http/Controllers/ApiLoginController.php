<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use DB;

class ApiLoginController extends Controller
{    
    private $client;
    public function __construct(){
        $this->client=Client::find(2);
    }
    public function login(Request $request){

        $this->validate($request,[
            'email'=>'required',
            'password'=>'required'
        ]);

        $params=[
            'grant_type'=>'password',
            'client_id'=>$this->client->id,
            'client_secret'=>$this->client->secret,
            'email'=>request('email'),
            'password'=>request('password'),
            'scope'=>'*'
        ];

        $request->request->add($params);
        $proxy=Request::create('oauth/token','POST');

        return Route::dispatch($proxy);

    }

    public function logout(){

        $accessToken=auth()->user()->token();

        DB::table('oauth_refresh_tokens')
        ->where('access_token_id',$accessToken->id)
        ->update(['revoked'=>true]);

        $accessToken->revoke();

        return response()->json([],204);


    }
}
