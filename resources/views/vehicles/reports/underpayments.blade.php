@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
             Under paid vehicles
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
                  <th>Registration</th>
                  <th>Year</th>
                  <th>Make</th>
                  <th>Model</th>
                  <th>Capacity</th>
                  <th>Difference(Kshs)</th>
                  
                </tr>
              @foreach($vehicles as $vehicle)
               @if($vehicle->difference() > 0)
                <tr>
                  <td><a href="{{route('customers.vehicles.show',['customer'=>$vehicle->customer->id,'vehicle'=>$vehicle->id])}}" class="btn btn-xs btn-info">Show</a></td>
                  <td>{{$vehicle->registration}}</td>
                  <td>{{$vehicle->year}}</td>
                  <td>{{$vehicle->make}}</td>
                  <td>{{$vehicle->model}}</td>
                  <td>{{$vehicle->capacity}}</td>
                  <td>{{number_format($vehicle->difference())}}</td>
                </tr>
                @endif
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