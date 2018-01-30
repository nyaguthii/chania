@extends('layouts.master')
@section('content')
<div class="content-wrapper pos-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Chania Sacco.
            <small class="pull-right">Date: {{Carbon\Carbon::parse($receipt->payment->transaction_date)->format('d-m-Y')}} </small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
      <div class="col-sm-4 invoice-col col-md-offset-4">
          <address>
            <strong>{{$receipt->payment->customer->firstname}} 
            {{$receipt->payment->customer->lastname}}</strong><br>
            {{$receipt->payment->customer->address}}<br>
            {{$receipt->payment->customer->contact}}<br>
            <br>
          </address>
        </div>
      </div>
      <div class="row invoice-info">
      <div class="col-sm-4 invoice-col col-md-offset-4">
          <b>Receipt #No: {{$receipt->id}}</b><br>
          <br>
          Paid for: <b>{{$receipt->payment->type}}</b><br>
          <br>
          @if($receipt->payment->vehicle_id)
          <b>Vehicle Reg:</b>{{$vehicle->registration}} <br>
          @endif
        </div>
      </div>
      <div class="row invoice-info">
        
        <!-- /.col -->
        
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-4 table-responsive col-md-offset-4">
          <table class="table table-striped">
            <thead>
            <tr>
              
              <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>Kshs {{number_format($receipt->amount)}}</td>
              
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-4 col-md-offset-4">
          <a href="#" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>
  
@endsection