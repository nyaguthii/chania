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
              <p>Cancellations</p>
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
                </tr>
              @foreach($cancellations as $cancellation)
                <tr>
                  <td>{{$cancellation->id}}</td>
                  <td>{{$cancellation->effective_date}}</td>
                  <td>{{$cancellation->policy->customer->firstname}} {{$cancellation->policy->customer->lastname}}</td>
                  <td>{{$cancellation->policy->vehicle->registration}}</td>
                  <td>{{$cancellation->policy->policy_no}}</td>
                  
                </tr>
              @endforeach

              </table>
              
            </div>
            <div class="box-footer">
              {{$cancellations->links()}}
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