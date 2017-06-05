@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname." ".$customer->lastname}}
        <small>Credit</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('customers.index',['is_member'=>$customer->is_member])}}"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li><a href="{{route('customers.show',['customer'=>$customer->id])}}"><i ></i>Customer</a></li>
        <li class="active">Credit</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      @if(isset($customer))
      @include('layouts.customer-menu')
      @endif
      <div class="row">
        <div class="col-xs-4">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Account Info</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="#">Total Amount
                  <span class="pull-right text-red">Kshs {{number_format($credits->sum('amount'))}}</span></a></li>
                <li><a href="#">Total Amount Paid <span class="pull-right text-green">Kshs {{number_format($customer->creditPayments->sum('amount'))}}</span></a>
                </li>
                <li><a href="#">Total Daily Collection <span class="pull-right text-purple">Kshs {{number_format($totalDaily)}}</span></a>
                </li>
                <li><a href="#">Balance
                  <span class="pull-right text-yellow">Kshs {{number_format($credits->sum('amount')-($customer->creditPayments->sum('amount')+$totalDaily) )}}</span></a></li>
                 <li>
                   <a href="{{route('customers.statement',['customer'=>$customer->id])}}" class="btn btn-primary btn-block"><b>Statement</b></a>
                 </li>
              </ul>
            </div>
            <!-- /.footer -->
          </div>
        </div>
        <div class="col-xs-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><a href="{{route('creditpayments.create',['customer'=>$customer->id])}}">Make a Payment</a></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-condensed">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Amount(kshs)</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  {{$creditPayments=$customer->creditPayments()->orderBy('id','desc')->paginate(20)}}
                  @foreach($creditPayments as $creditPayment)
                  <tr>
                    <td>{{$creditPayment->id}}</td>
                    <td>{{Carbon\Carbon::parse($creditPayment->transaction_date)->format('d-m-Y')}}</td>
                    <td>{{number_format($creditPayment->amount)}}</td>
                    <td><a href="{{route('creditpayments.edit',['creditPayment'=>$creditPayment->id])}}" class="btn btn-xs btn-info">Edit</a></td>
                    @if($creditPayment->creditReceipt)
                    <td><a href="{{route('creditReceipts.show',['receipt'=>$creditPayment->creditReceipt->id])}}" class="btn btn-xs btn-success">View Receipt</a></td>
                    @endif
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              {{$creditPayments->links()}}
            </div>
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left"></a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right"></a>
            </div>
            <!-- /.box-footer -->
          </div>   
        </div>
      </div>
      <div class="row">   
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">           
            <a class="btn btn-primary btn-flat glyphicon glyphicon-plus" href="{{route('credits.create', ['customer' => $customer->id])}}">add a Due Amount</a>    
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  <th>ID</th>
                  <th>Transaction Date</th>
                  <th>Amount</th>
                  <th>Description</th>                 
                </tr>
              @foreach($credits as $credit)
                <tr>
                  <td>{{$credit->id}}</td>
                  <td>{{Carbon\Carbon::parse($credit->transaction_date)->format('d-m-Y')}}</td>
                  <td>{{number_format($credit->amount)}}</td>
                  <td>{{$credit->description}}</td>
                  @if($credit->type==="Manual")
                  <td><a href="{{route('credits.edit',['credit'=>$credit->id])}}" class="btn btn-xs btn-warning">Edit</a></td>
                  @endif
                </tr>
              @endforeach
              </table>
            </div>
            <div class="box-footer">
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        
        <!-- Modal -->       
      </div>
    </section>
    <!-- /.content -->
</div>
  
@endsection