<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use DB;
use App\domain\Order;
use App\User;

class TyresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard(){

        //$chart = Charts::database(User::all(), 'bar', 'highcharts')->dateColumn('my_date_column');
        //$chart=Charts::database(Order::all(), 'bar', 'google');
        
        $total_payments=DB::table('payments')
        ->where('type','TYRE')
        ->sum('amount');
        $total_sales=DB::table('orders')
        ->sum('amount');
        $total_credits=DB::table('credits')
        ->where('type','TYRE')
        ->sum('amount');
        return view('tyres.dashboard',[
            'total_payments'=>$total_payments,'total_sales'=>$total_sales,
            'total_credits'=>$total_credits
            ]);

    }

    public function differenceAjax(){
        $payments = DB::select(DB::raw("select c.id,c.member_id,concat(c.firstname,' ',c.middlename,' ',c.lastname) as name,s.customer_id,format(s.total_payments,0) as payments,format(p.total_credits,0) as credits,format(s.total_payments - p.total_credits,0) as balance 
        from (select customer_id,sum(amount) total_payments from payments where type='TYRE'
        group by customer_id) s
        right outer join 
        (select customer_id,IFNULL(sum(amount),0) total_credits from credits where type='TYRE'
        group by customer_id ) p 
        on p.customer_id = s.customer_id
        join customers c on s.customer_id = c.id
        UNION
        select c.id,c.member_id,concat(c.firstname,' ',c.middlename,' ',c.lastname) as name,s.customer_id,format(s.total_payments,0) as payments,format(p.total_credits,0) as credits,format(s.total_payments - p.total_credits,0) as balance 
        from (select customer_id,sum(amount) total_payments from payments where type='TYRE'
        group by customer_id) s
        left outer join 
        (select customer_id,IFNULL(sum(amount),0) total_credits from credits where type='TYRE'
        group by customer_id ) p 
        on p.customer_id = s.customer_id
        join customers c on s.customer_id = c.id"));
        return Datatables::of($payments)->make(true);

    }
    public function difference(){
        return view('tyres.difference');
    }

}
