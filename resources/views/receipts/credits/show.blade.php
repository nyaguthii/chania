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
            <strong>{{$receipt->creditPayment->customer->firstname}} 
            {{$receipt->creditPayment->customer->lastname}}</strong><br>
            {{$receipt->creditPayment->customer->address}}<br>
            {{$receipt->creditPayment->customer->contact}}<br>
            <br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Receipt:{{$receipt->receipt_no}}</b><br>
          <br>
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
        <div class="col-xs-12">
          <a href="#" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>
  
@endsection