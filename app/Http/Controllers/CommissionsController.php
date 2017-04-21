<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Commission;
use Illuminate\Support\Facades\DB;

class CommissionsController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

    	//$commissions=Commission::all();
    	//$commissions=DB::table('commissions')->orderBy('id','desc')->paginate(20);
    	$commissions = Commission::orderBy('id','desc')->paginate(10);
    	return view('commissions.index',['commissions'=>$commissions]);
    }
}
