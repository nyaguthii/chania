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
            <div class="box-header with-border">
            Payments Due Tommorrow    
              <div class="box-tools">     
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  <th></th>
                  <th>Due Date</th>
                  <th>Premium</th>
                  <th>Amount Paid</th>
                  <th>Status</th>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Contact</th>
                  <th>Policy</th>
                  <th>Vehicle</th>
                  
                  
                  <th></th>               
                </tr>
              @foreach($paymentSchedules as $paymentSchedule)
                <tr>
                  <td></td>
                  <td>{{$paymentSchedule->due_date}}</td>
                  <td>{{$paymentSchedule->amount}}</td>
                  <td>{{$paymentSchedule->amount_paid}}</td>
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
              </table>
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