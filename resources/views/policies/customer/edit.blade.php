@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname." ".$customer->lastname}}
        <small>{{$policy->policy_no}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('customers.index',['is_member'=>$customer->is_member])}}"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li><a href="{{route('customers.show',['customer'=>$customer->id])}}"><i ></i>Customer</a></li>
         <li ><a href="{{route('customer.policies.index',['customer'=>$customer->id])}}"><i></i>Policies</a></li>
         <li ><a href="{{route('customer.policies.show',['customer'=>$customer->id,'policy'=>$policy->id])}}"><i></i>Policy</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      @include('layouts.customer-menu')      
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p>Policy Details</p>    
              
            </div>
            <!-- /.box-header -->
            <form action="{{route('customer.policies.update',['policy'=>$policy->id])}}" method="POST">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 
                  <!-- /.form-group -->
                    <div class="form-group">
                        <label for="policy_no">Policy Number</label>
                        <input class="form-control" name="policy_no" value="{{$policy->policy_no}}">
                      </div>
                      <!-- Date -->
                      <div class="form-group">
                        <label>Effective Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="effective_date" type="text" class="form-control pull-right" id="datepicker" value="{{Carbon\Carbon::parse($policy->effective_date)->format('m/d/Y')}}">
                        </div>
                        <!-- /.input group -->
                      </div>
                    <div class="form-group">
                      <label>Period</label>
                      <select  class="form-control" name="duration_type" id="duration" >
                        <option>Annual</option>
                        <option>Ten Months</option>
                        <option>Semi Annual</option>
                        <option>Quartely</option>
                        <option>Monthly</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Type</label>
                      <select  class="form-control" name="type"  >
                        <option>Comprehensive</option>
                        <option>Third Party</option>
                      </select>
                    </div>
                    
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">              
                  <!-- /.form-group -->
                
                  <div class="form-group">
                    <label for="carrier">Carrier</label>
                    <input  class="form-control" name="carrier" value="{{$policy->carrier}}" >
                  </div>
                    <!-- /.input group -->
                  </div>
                  <div class="form-group">
                    <label for="agent">Agent</label>
                    <input class="form-control" name="agent" value="{{$policy->agent}}" >
                  </div>
                  <div class="form-group">
                      <label>Vehicle</label>
                      <select  class="form-control" name="vehicle" id="vehicle" >
                        @foreach($customer->vehicles as $vehicle)
                        <option>{{$vehicle->registration}}</option>
                        @endforeach
                      </select>
                    </div>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <!-- /.form-group -->
                </div>

                <!-- /.col -->
              </div>
              <row>
                @include('layouts.error')
                
              </row>
              <!-- /.row -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
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