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
        <li><a href="#"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li class="active">Customer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">       
        <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-cash"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><a href="#">Payments</a></span>
                <span class="info-box-number"></span>    
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
    </div>
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
                <b>Total Payments</b> <a class="pull-right"><span class="text-green">kshs {{number_format($total_payments)}}</span></a>
              </li>
              <li class="list-group-item">
                <a class="btn btn-block btn-primary btn-flat" href="{{route('customers.sacco.statementdate',['customer'=>$customer->id])}}">Statement</a>
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
  </div>
  <!-- /.content-wrapper -->
  @endsection

  