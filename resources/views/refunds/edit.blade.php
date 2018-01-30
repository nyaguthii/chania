@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Refund</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <form action="{{route('refunds.update',['refund'=>$refund->id])}}" method="POST" role="form">
             {{ csrf_field() }}
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             
              <!-- /.form-group -->
              <div class="form-group">
                  <label for="amount">amount</label>
                  <input name="amount"  class="form-control" value="{{$refund->amount}}" >
                </div>
                <div class="form-group">
                    <label>Transaction Date:</label>

                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="transaction_date" type="text" class="form-control pull-right" id="datepicker" value="{{Carbon\Carbon::parse($refund->transaction_date)->format('m/d/Y')}}" >
                    </div>
                    <!-- /.input group -->
                  </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">              
              <!-- /.form-group -->
                

              <!-- /.form-group -->
            </div>

            <!-- /.col -->
          </div>
          
            @include('layouts.error')
        
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection()