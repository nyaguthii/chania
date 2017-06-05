@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname." ".$customer->lastname}}
        <small>Payments</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('customers.index',['is_member'=>$customer->is_member])}}"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li><a href="{{route('customers.show',['customer'=>$customer->id])}}"><i ></i>Customer</a></li>
        <li class="active">Payments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      @include('layouts.customer-menu')
      @foreach($policies as $policy)
      <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Policy No: <span style="color:green">{{$policy->policy_no}}</span></h3>

              
              <h3 class="box-title">Vehicle Reg: <span style="color:green">{{$policy->vehicle->registration}}</span></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  <th>Id</th>
                  <th>Date</th>
                  <th>Amount</th>
                  
                </tr>
              
              @foreach($policy->paymentSchedules()->where('status','paid')->get() as $paymentSchedule)
                <tr>
                  <td>{{$paymentSchedule->id}}</td>
                  <td>{{$paymentSchedule->due_date}}</td>
                  <td>{{$paymentSchedule->amount}}</td>
            
                </tr>
              @endforeach
              </table>
              
            </div>
              
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"> Total(Kshs) {{$policy->paymentSchedules()->where('status','paid')->sum('amount')}}</button>
            </div>
      </div>
      @endforeach       
    </section>
    <!-- /.content -->
</div>  
@endsection