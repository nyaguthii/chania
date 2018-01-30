@extends('layouts.master')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname}} {{$customer->lastname}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('customers.index',['is_member'=>$customer->is_member])}}"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li class="active">Customer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
    @include('layouts.customer-menu')
    <div class="row">
      
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{$customer->firstname}}  {{$customer->lastname}} </h3>

            <p class="text-muted text-center">{{$customer->type}}</p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Address</b> <a class="pull-right">{{$customer->address}}</a>
              </li>
              <li class="list-group-item">
                <b>Contact</b> <a class="pull-right">{{$customer->contact}}</a>
              </li>
               <li class="list-group-item">
                <b>Insured ID</b> <a class="pull-right">{{$customer->insured_id}}</a>
              </li>
               <li class="list-group-item">
                <b>Is Member</b> <a class="pull-right">
                @if($customer->is_member==1)
                 Yes
                @elseif($customer->is_member==0)
                 No
                @endif
                </a>
              </li>
              <li class="list-group-item">
                <a class="btn btn-block btn-warning btn-flat" href="{{route('credits.create',['customer'=>$customer->id])}}">Add Due Amount</a>
              </li>
              <li class="list-group-item">
                <a class="btn btn-block btn-primary btn-flat" href="{{route('customers.statementdate',['customer'=>$customer->id])}}">Statement</a>
              </li>
            </ul>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <!-- /.box -->
      </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p>Due Date</p>    
              
            </div>
            <!-- /.box-header -->
            <form action="{{route('paymentSchedules.customer.due',['customer'=>$customer->id])}}" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                      <div class="form-group">
                        <label>Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="date" type="text" class="form-control pull-right" id="datepicker" >
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">              
                  <!-- /.form-group -->
                  <div class="form-group" style="margin-top:25px">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <row>
                @include('layouts.error')
                
              </row>
              <!-- /.row -->
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
          Premiums Due     
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
                <th>Due Date</th>
                <th>Policy</th>
                <th>Vehicle</th>
                <th>Amount</th>
                               
              </tr>
              @foreach($paymentSchedules as $paymentSchedule)
              <tr>
              
              <td>{{$paymentSchedule->pid}}</td>            
              <td>{{Carbon\Carbon::parse($paymentSchedule->due_date)->format('d-m-Y')}}</td>
              <td>{{$paymentSchedule->policy_no}}</td>
              <td>{{$paymentSchedule->registration}}</td>
              <td>{{$paymentSchedule->pamount}}</td>
              </tr>
              @endforeach
              
            </table>
          </div>
          <div class="box-footer">
           <button type="button" class="btn btn-primary pull-right">Kshs {{$paymentSchedules->sum('pamount') - $paymentSchedules->sum('amount_paid')}}</button>
          </div>
        
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        </div>
      </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

  