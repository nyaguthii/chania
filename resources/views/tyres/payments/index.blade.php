@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
      {{$customer->firstname}} {{$customer->lastname}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('customers.tyres.show',['customer'=>$customer->id])}}"><i class="fa fa-dashboard"></i>Customer</a></li>
      <li class="active">Tyre Payments</li>
    </ol>
  </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">       
        <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-cash"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><a href="#">Payments</a></span>
                    <span class="info-box-number"></span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-card"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><a href="{{route('tyres.credits.index',['customer'=>$customer->id])}}">Credits</a></span>
                    <span class="info-box-number"></span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p>Payments</p>
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
                  <th>Date</th>
                  <th>Type</th>
                  <th>Amount(kshs)</th>
                </tr>
                @foreach($payments as $payment)
                <tr>
                    <td>{{$payment->id}}</td>
                    <td>{{$payment->transaction_date}}</td>
                    <td>{{$payment->type}}</td>
                    <td>{{$payment->amount}}</td>
                </tr>
                @endforeach
              </table>
              
            </div>
            <div class="box-footer">
              {{$payments->links()}}
            </div>
            <div class="box-footer">
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>  
@endsection