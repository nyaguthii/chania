<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Customer;
use Carbon\Carbon;
use DataTables;
use DB;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getMembersAjax(){

        $customers = DB::table('customers')
        ->select(DB::raw("id,member_id,concat(firstname,' ',middlename,' ',lastname) as name,contact,address"))
        ->where('is_member','=','1')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($customers)
        ->addColumn('action', function ($customer) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$customer->id.'/edit" class="btn btn-xs btn-warning "><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a> 
            <a href="/customers/'.$customer->id.'/delete" class="btn btn-xs btn-danger "><i class="fa fa-trash" aria-hidden="true"></i>Delete</a>           
            </div>
            ';
        })->make(true);

    }
    public function getNonMembersAjax(){

        $customers = DB::table('customers')
        ->select(DB::raw("id,member_id,concat(firstname,' ',middlename,' ',lastname) as name,contact,address"))
        ->where('is_member','=','0')
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($customers)
        ->addColumn('action', function ($customer) {
            return '
            <div class="pull-right">
            <a href="/customers/'.$customer->id.'/edit" class="btn btn-xs btn-warning pull-left"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
            <a href="/customers/'.$customer->id.'/delete" class="btn btn-xs btn-danger pull-left"><i class="fa fa-trash" aria-hidden="true"></i>Delete</a>           
            </div>
            ';
        })->make(true);
        
    }
    public function getMembers(){
        return view('members.members');
    }
    public function getNonMembers(){
        return view('members.nonmembers');
    }
}
