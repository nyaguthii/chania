@extends('layouts.master')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
    <div class="row">      
      <div class="col-md-4">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center"></h3>

            <p class="text-muted text-center">Payment info</p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Customer</b> <a class="pull-right">{{$commission->endorsement->policy->customer->firstname}}</a>
              </li>
              <li class="list-group-item">
                <b>Policy</b></a> <a class="pull-right">{{$commission->endorsement->policy->policy_no}}</a>
              </li>
               <li class="list-group-item">
                <b>Vehicle</b> <a class="pull-right">{{$commission->endorsement->policy->vehicle->registration}}</a></a>
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
            <div class="box-header with-border">
            Payments Done   
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
                  <th>ID</th>
                  <th>Date</th>
                  <th>Amount Paid</th>              
                </tr>
              {{$payments = $commission->payments()->paginate(20)}}
              @foreach($payments as $payment)
                <tr>
                  <td></td>
                  <td>{{$payment->id}}</td>
                  <td>{{$payment->transaction_date}}</td>
                  <td>{{$payment->amount}}</td>
                  <td><a href="{{route('commissions.payments.edit',['commission'=>$commission->id,'payment'=>$payment->id])}}" class="btn btn-xs btn-info">Edit</a></td>
              @endforeach
              </table>
            </div>
            <div class="box-footer">
              {{$payments->links()}}
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"> Total(Kshs) {{$payments->sum('amount')}}</button>
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

  