@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
       
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
    
      <!-- /.row --> 
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              Add a Payment     
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('vehicles.payments.update',['dailyPayment'=>$dailyPayment->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 
                  <!-- /.form-group -->
                    <div class="form-group">
                        <label>Transaction Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="transaction_date" type="text" class="form-control pull-right" id="datepicker" value="{{Carbon\Carbon::parse($dailyPayment->transaction_date)->format('m/d/Y')}}">
                        </div>
                        <!-- /.input group -->
                      </div>
                      <div class="form-group">
                      <label>Type</label>
                      <select  class="form-control" name="type"  >
                        <option>Debit</option>
                        <option>Credit</option>
                      </select>
                    </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">              
                  <!-- /.form-group -->
                    <div class="form-group">
                      <label for="policy-id">Amount(Kshs)</label>
                      <input class="form-control" name="amount" id="amount" value="{{$dailyPayment->amount}}" >
                  <!-- /.form-group -->
                    </div>
                    <div class="form-group">
                      <label>From</label>
                      <select  class="form-control" name="place"  >
                        <option>Office</option>
                        <option>Field</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label> Description </label>
                      <input class="form-control" name="description"  value="{{$dailyPayment->description}}">
                  <!-- /.form-group -->
                    </div>
                    
                    <div class="form-group">
                      <label >Receipt Number</label>
                      <input class="form-control" name="receipt_no" 
                      @if($dailyPayment->receipt) 
                      value="{{$dailyPayment->receipt->receipt_no}}">
                      @endif
                    </div>
                   
                  <div class="col-md-12">
                    <div class="row">
                    @include('layouts.error') 
                  </div>
                  </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      
    </section>
    <!-- /.content -->
</div>
  
@endsection