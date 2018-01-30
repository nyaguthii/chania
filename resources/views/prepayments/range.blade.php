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
              <p>Payments</p>    
              
            </div>
            <!-- /.box-header -->
            <form action="{{route('payments.range')}}" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                      <div class="form-group">
                        <label>Start Date:</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="start_date" type="text" class="form-control pull-right" id="datepicker" >
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="radio">
                          <label>
                            <input type="radio" name="is_member" id="optionsRadios1" value="1" >
                            Members
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="is_member" id="optionsRadios2" value="0">
                            Non Members
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="is_member" id="optionsRadios3" value="all" checked>
                            All
                          </label>
                        </div>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">              
                  <!-- /.form-group -->
                  <div class="form-group">
                        <label>End Date:</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="end_date" type="text" class="form-control pull-right" id="endDate" >
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group" style="margin-top:25px">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>
              <div class="row">
                 @include('layouts.error')
              </div>
               
              <!-- /.row -->
            </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      @if(isset($payments))
      <div class="row">
        <div class="col-xs-12">
        <div class="box box-default">
          <div class="box-header with-border">
          Daily Payments      
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
            <tr>
                <th>Id</th>
                <th>Transaction Date</th>
                <th>Amount</th>
                               
              </tr>

              @foreach($payments as $payment)
                <tr>
                <td></td>
                <td>{{$payment->transaction_date}}</td>
                <td>{{$payment->amount}}</td>
                               
              </tr>
              @endforeach
            </table>
          </div>
          <div class="box-footer">
           
          </div>
          <div class="box-footer">
           <button type="button" class="btn btn-primary pull-right">Total (kshs){{$payments->sum('amount')}}</button> 
          </div>
        
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        </div>
      </div>
      @endif
    </section>
    <!-- /.content -->
</div>
  
@endsection