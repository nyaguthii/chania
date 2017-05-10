@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Chania Sacco.
            <small class="pull-right">Date: {{$receipt->created_at->toDateString()}}</small>
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
            <strong>{{$receipt->payment->paymentSchedule->policy->customer->firstname}} 
            {{$receipt->payment->paymentSchedule->policy->customer->lastname}}</strong><br>
            {{$receipt->payment->paymentSchedule->policy->customer->address}}<br>
            {{$receipt->payment->paymentSchedule->policy->customer->contact}}<br>
            <br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Receipt #Ow{{$receipt->id}}</b><br>
          <br>
          <b>Vehicle Reg:</b> {{$receipt->payment->paymentSchedule->policy->vehicle->registration}}<br>
          <b>Policy no:</b> {{$receipt->payment->paymentSchedule->policy->policy_no}}<br>
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
              
              <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>Kshs {{$receipt->amount}}</td>
              
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="#" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>
  
@endsection