<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Receipt;

class ReceiptsController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function show(Receipt $receipt){

    	return view('receipts.show',['receipt'=>$receipt]);

    }
}
