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
              <p>Date</p>    
              
            </div>
            <!-- /.box-header -->
            <form action="{{route('paymentSchedules.due')}}" method="POST">
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
                </div>
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
                  <!-- /.form-group -->
                  <div class="form-group" style="margin-top:25px">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>
              <div class="row">
                @include('layouts.error') 
              </div>   
            </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
        <div class="box box-default">
          <div class="box-header with-border">
          Payments Due     
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
            <tr>
              <th></th>
              <th>Due Date</th>
              <th>Premium</th>
              <th>Status</th>
              <th>Firstname</th>
              <th>Lastname</th>
              <th>Contact</th>
              <th>Policy</th>
              <th>Vehicle</th>        
              </tr>
            @if(isset($paymentSchedules))
            @foreach($paymentSchedules as $paymentSchedule )
              <tr>
                  <td></td>
                  <td>{{Carbon\Carbon::parse($paymentSchedule->due_date)->format('d-m-Y')}}</td>
                  <td>{{$paymentSchedule->amount}}</td>
                  <td>
                    <span 
                        @if($paymentSchedule->status === 'open')
                        class="label label-danger"
                        @elseif($paymentSchedule->status === 'paid')
                        class="label label-success"
                        @endif
                      >{{$paymentSchedule->status}}
                    </span>

                  </td>
                  <td>{{$paymentSchedule->policy->customer->firstname}}</td>
                  <td>{{$paymentSchedule->policy->customer->lastname}}</td>
                  <td>{{$paymentSchedule->policy->customer->contact}}</td>
                  <td>{{$paymentSchedule->policy->policy_no}}</td> 
                  <td>{{$paymentSchedule->policy->vehicle->registration}}</td>
                </tr>
              @endforeach
              @endif
            </table>
          </div>
          <div class="box-footer">
           <button type="button" class="btn btn-primary pull-right"></button>
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