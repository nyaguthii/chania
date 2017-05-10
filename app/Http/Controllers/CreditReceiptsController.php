<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\CreditReceipt;

class CreditReceiptsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show(CreditReceipt $receipt){

    	return view('receipts.credits.show',['receipt'=>$receipt]);

    }
}
