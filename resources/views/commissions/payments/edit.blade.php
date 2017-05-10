@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="content">
    
      <!-- /.row --> 
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              Edit a Payment     
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('commissions.payments.update',['commission'=>$commission->id,'commissionPayment'=>$payment->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 
                  <!-- /.form-group -->
                    <div class="form-group">
                      <label for="">Commissions Amount(Kshs)</label>
                      <input class="form-control" disabled="disabled" value="{{$commission->amount}}">
                    </div>
                    <div class="form-group">
                      <label for="policy-id">Paid Amount(Kshs)</label>
                      <input class="form-control" disabled="disabled" value="{{$commission->payments->sum('amount')}}">
                    </div>
                    <div class="form-group">
                      <label for="">Balance Amount(Kshs)</label>
                      <input class="form-control" disabled="disabled" value="{{$commission->amount-$commission->payments->sum('amount')}}">
                    </div>

                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">              
                  <!-- /.form-group -->
                    <div class="form-group">
                      <label for="policy-id">Amount(Kshs)</label>
                      <input class="form-control" name="amount" id="amount" value="{{$payment->amount}}" >
                  <!-- /.form-group -->
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
              <button type="submit" class="btn btn-primary">Edit</button>
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