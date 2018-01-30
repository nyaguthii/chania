<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Customer;
use Carbon\Carbon;
use DataTables;
use DB;

class InsuranceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dashboard(){
      return view('insurance.dashboard');  
    }
    public function getMembersAjax(){

        $customers = DB::table('customers')
        ->select(DB::raw("id,member_id,concat(firstname,' ',middlename,' ',lastname) as name,contact,address"))
        ->where('is_member','=','1')
        ->get();
        
        return Datatables::of($customers)
        ->addColumn('action', function ($customer) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$customer->id.'/show" class="btn btn-xs btn-success "><i class="fa fa-eye" aria-hidden="true"></i>Show</a>   
            </div>
            ';
        })->make(true);

    }
    public function getNonMembersAjax(){

        $customers = DB::table('customers')
        ->select(DB::raw("id,member_id,concat(firstname,' ',middlename,' ',lastname) as name,contact,address"))
        ->where('is_member','=','0')
        ->get();
        
        return Datatables::of($customers)
        ->addColumn('action', function ($customer) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$customer->id.'/show" class="btn btn-xs btn-success pull-left"><i class="fa fa-eye" aria-hidden="true"></i>Show</a>           
            </div>
            ';
        })->make(true);
        
    }
    public function getMembers(){
        return view('insurance.members');
    }
    public function getNonMembers(){
        return view('insurance.nonmembers');
    }
    public function vehicles(){
        return view('insurance.vehicles');
    }
    public function vehiclesajax(){
        $vehicles = DB::table('vehicles')
        ->join('customers', 'customer_id', '=', 'customers.id')
        ->selectRaw("customers.id as cid,vehicles.id,vehicles.registration,concat(customers.firstname,' ',customers.middlename,' ',customers.lastname) as name")
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($vehicles)
        ->addColumn('action', function ($vehicle) {
            return '<a href="/customers/'.$vehicle->cid.'/vehicles/'.$vehicle->id.'/show" class="btn btn-xs btn-primary pull-right"><i class="fa fa-eye" aria-hidden="true"></i>Show</a>';
        })
        ->make(true);
    }
}
