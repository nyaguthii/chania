@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname." ".$customer->lastname}}
        <small>vehicles</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('customers.show',['customer'=>$customer->id])}}"><i class="fa fa-dashboard"></i>Customer</a></li>
        <li><a href="{{route('customers.vehicles.index',['customer'=>$customer->id])}}">Vehicles</a></li>
        <li class="active">Create</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    @include('layouts.customer-menu') 
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Vehicle Details</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <form action="{{route('customers.vehicles.store',['customer'=>$customer->id])}}" method="POST" role="form">
             {{ csrf_field() }}
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             
              <!-- /.form-group -->
              <div class="form-group">
                  <label for="registration">Registration</label>
                  <input name="registration"  class="form-control" id="registration" placeholder="Registration" value="{{old('registration')}}">
                </div>
                <div class="form-group">
                  <label for="year">Year</label>
                  <input name="year"  class="form-control" id="year" placeholder="Year" value="{{old('year')}}">
                </div>
                <div class="form-group">
                  <label for="make">Make</label>
                  <input name="make" type="text" class="form-control" id="make" placeholder="Make" value="{{old('make')}}">
                </div>
                <div class="form-group">
                  <label for="model">Model</label>
                  <input name="model" type="text" class="form-control" id="model" placeholder="Model" value="{{old('model')}}">
                </div>
                <div class="form-group">
                  <label for="capacity">Capacity</label>
                  <input name="capacity" type="text" class="form-control" id="capacity" value="{{old('capacity')}}" >
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
          <row>
            @include('layouts.error')
          </row>
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