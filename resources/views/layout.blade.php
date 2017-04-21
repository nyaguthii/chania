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
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
            Payments     
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
                  <th>Customer</th>
                  <th>Policy</th>
                  <th>Vehicle</th>
                  <th>Contact</th>
                  
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
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                  @if($paymentSchedule->status === 'open')
                  <a href="{{route('payments.create',['paymentSchedule'=>$paymentSchedule->id])}}" class="btn btn-xs btn-info">Take Payment</a>
                  @elseif($paymentSchedule->status === 'paid')
                  <a href="#" class="btn btn-xs btn-warning">View Payment</a>
                  @endif
                  </td>
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