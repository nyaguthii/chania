@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
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
                  <th>Payment Schedule</th>
                  <th>Date</th>
                  <th>Amount</th>
                  
                </tr>
              {{$payments = $policy->payments()->orderBy('id','desc')->paginate(10)}}
              @foreach($payments as $payment)
                <tr>
                  <td>{{$payment->id}}</td>
                  <td>{{$payment->paymentSchedule->id}}</td>
                  <td>{{$payment->transaction_date}}</td>
                  <td>{{$payment->amount}}</td>
                  <td><a href="{{route('receipts.show',['receipt'=>$payment->receipt->id])}}" class="btn btn-xs btn-info">Print Receipt</a></td>
                  <td><a href="{{route('payments.edit',['customer'=>$customer->id,'payment'=>$payment->id])}}" class="btn btn-xs btn-warning">Edit Payment</a></td>
                </tr>
              @endforeach
              </table>
              
            </div>
              
            <!-- /.box-body -->
            <div class="box-footer">
              {{$payments->links()}}
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"> Total(Kshs) {{$payments->sum('amount')}}</button>
            </div>
        </div>
         @endforeach       
    </section>
    <!-- /.content -->
</div>
  
@endsection