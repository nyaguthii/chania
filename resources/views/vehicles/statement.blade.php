@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname}}  {{$customer->lastname}}
      </h1>
    </section>
    <!-- Main content -->
    <div class="pad margin no-print">
      @include('layouts.customer-menu')
    </div>
    <!-- /.content -->
    <section class="invoice">
   
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i>Chania Sacco.
            <small class="pull-right">Date: {{Carbon\Carbon::now()->toFormattedDateString()}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>{{$customer->firstname}} {{$customer->lastname}}</strong><br>
            {{$customer->member_id}}<br>
            {{$customer->insured_id}}<br>
            Phone: {{$customer->contact}}<br>
            Vehicle: {{$vehicle->registration}} <br>
          </address>
        </div>
        
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Transaction Date</th>
              <th></th>
              <th>Payments</th>
              <th>Debts</th>
              <th>Balance</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>{{$date->format('d-m-Y')}}  <span class="pull-right">Balance </span></td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{number_format($total)}}</td>
            </tr>
            @foreach($transactions as $transaction)
              <?php
               if($transaction->statement_impact=="add"){
                $total=$total + $transaction->amount;
               }elseif($transaction->statement_impact=="minus"){
                $total=$total-$transaction->amount;
               }   

            ?>  
            <tr>
              <td>{{Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y')}}</td>
              <td>{{$transaction->description}}</td>
              @if($transaction->statement_impact=="add")
              <td>{{number_format($transaction->amount)}}</td>
              <td></td>
              @endif
              @if($transaction->statement_impact=="minus")
              <td></td>
              <td>{{number_format($transaction->amount)}}</td>
              @endif
              <td>{{number_format($total)}}</td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
         
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Balance</th>
                <td>Kshs {{number_format($total)}}</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>
    </section>
</div>
  
@endsection