<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashiersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('cashier.index');
    }
    public function dashboard(){
        return view('cashier.dashboard');
    }
    public function members(){
        return view('cashier.members');
    }
    public function nonMembers(){
        return view('cashier.nonmembers');
    }
}
