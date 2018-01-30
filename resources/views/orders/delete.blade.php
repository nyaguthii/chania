@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="invoice">
    <form action="{{route('orders.destroy',['order'=>$order->id])}}" method="POST">
    {{ csrf_field() }}
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> .
            <small class="pull-right">Date: {{Carbon\Carbon::parse($order->transaction_date)->format('d-m-Y')}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Chania Sacco</strong><br>
            P.O Box 189991<br>
            Thika<br>
            Phone: (804) 123-5432<br>
            Email: info@chaniasacco.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Order No: {{$order->id}}
            </strong><br>
            <br>
            <br>
            <br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          {{$order->customer->firstname}}<b></b><br>
          {{$order->customer->lastname}}<br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderLines as $orderLine)
            <tr>
            <td>{{$orderLine->product->name}}</td>
            <td>{{$orderLine->quantity}}</td>
            <td>{{$orderLine->sales_price}}</td>
            <td>{{$orderLine->quantity*$orderLine->sales_price}}</td>              
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      
      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total:</th>
                <td>Kshs {{$order->amount}}</td>
              </tr>
              <tr>
             
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>Delete</button>
        </div>
      </div>
      </form>
    </section>
    <!-- /.content -->
</div>
  
@endsection