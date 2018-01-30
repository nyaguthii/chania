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
              <p>Suspensions</p>
              <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  
                  <th>ID</th>
                  <th>Effective Date</th>
                  <th>Customer</th>
                  <th>Vehicle</th>
                  <th>Policy</th>
                  <th></th>
                </tr>
              @foreach($suspensions as $suspension)
                <tr>
                  <td>{{$suspension->id}}</td>
                  <td>{{$suspension->effective_date}}</td>
                  <td>{{$suspension->policy->customer->firstname}}</td>
                  <td>{{$suspension->policy->vehicle->registration}}</td>
                  <td>{{$suspension->policy->policy_no}}</td>
                  <td><a href="{{route('suspensions.edit',['suspension'=>$suspension->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                </tr>
              @endforeach

              </table>
              
            </div>
            <div class="box-footer">
              {{$suspensions->links()}}
            </div>
            <div class="box-footer">
              
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