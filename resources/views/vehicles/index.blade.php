@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p>Search</p>
              <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('vehicles.find')}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-5">
                      <div class="form-group">
                      <label >Registration</label>
                      <input class="form-control" name="registration">
                  <!-- /.form-group -->
                    </div>
                </div>
                <div class="col-md-2">              
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
          <div class="box">
            <div class="box-header">
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-condensed">
              <tr>
                  <th></th>
                  <th>Registration</th>
                  <th>Customer</th>
                  <th>Customer Contact</th>
                  <th>Model</th>
                  <th>Capacity</th>
                  
                </tr>
              @foreach($vehicles as $vehicle)
                <tr>
                  <td><a href="{{route('customers.vehicles.show',['customer'=>$vehicle->customer->id,'vehicle'=>$vehicle->id])}}" class="btn btn-xs btn-info">Show</a></td>
                  <td>{{$vehicle->registration}}</td>
                  <td>{{$vehicle->customer->firstname}}  {{$vehicle->customer->lastname}} </td>
                  <td>{{$vehicle->customer->contact}}</td>
                  <td>{{$vehicle->model}}</td>
                  <td>{{$vehicle->capacity}}</td>
                </tr>
              @endforeach
              </table>
            </div>
            <div class="box-footer clearfix">
              {{$vehicles->links()}}
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