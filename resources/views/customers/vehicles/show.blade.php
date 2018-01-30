@extends('layouts.master')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname." ".$customer->lastname}}
        <small>{{$vehicle->registration}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('customers.show',['customer'=>$customer->id])}}"><i class="fa fa-dashboard"></i>Customer</a></li>
        <li><a href="{{route('customers.vehicles.index',['customer'=>$customer->id])}}"><i class="fa fa-dashboard"></i>Vehicles</a></li>
        <li class="active">Vehicle</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
    @include('layouts.customer-menu')
    <div class="row">
      
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{$vehicle->registration}} </h3>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Year</b> <a class="pull-right">{{$vehicle->year}}</a>
              </li>
              <li class="list-group-item">
                <b>Model</b> <a class="pull-right">{{$vehicle->model}}</a>
              </li>
              <li class="list-group-item">
                <b>Capacity</b> <a class="pull-right">{{$vehicle->capacity}}</a>
              </li>
            </ul>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
       <div class="col-xs-9">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><a href="#">Make a Transaction</a></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-condensed">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>From</th>
                    <th>Amount(kshs)</th>
                    <th>Type</th>
                    <th>Receipt</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  {{$dailyPayments=$vehicle->dailyPayments()->orderBy('id','desc')->paginate(30)}}
                  @foreach($dailyPayments as $dailyPayment)
                  <tr>
                    <td>{{$dailyPayment->id}}</td>
                    <td>{{Carbon\Carbon::parse($dailyPayment->transaction_date)->format('d-m-Y')}}</td>
                    <td>{{$dailyPayment->place}}</td>
                    <td>{{number_format($dailyPayment->amount)}}</td>
                    <td>{{$dailyPayment->type}}</td>
                    @if($dailyPayment->receipt)
                    <td>{{$dailyPayment->receipt->receipt_no}}</td>
                    @endif
                    @if(!$dailyPayment->receipt)
                    <td></td>
                    @endif

                    <td><a href="{{route('vehicles.payments.edit',['dailyPayment'=>$dailyPayment->id])}}" class="btn btn-xs btn-warning">Edit</a></td>
                    @if($dailyPayment->receipt)
                    <td><a href="#" class="btn btn-xs btn-success">View Receipt</a></td>
                    @endif
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              {{$dailyPayments->links()}}
            </div>
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">
               Kshs {{number_format($vehicle->dailyPayments()->where('type','Debit')->sum('amount')-$vehicle->dailyPayments()->where('type','Credit')->sum('amount'))}}
              </a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right"></a>
            </div>
            <!-- /.box-footer -->
          </div>   
        </div>
    </div>        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

  