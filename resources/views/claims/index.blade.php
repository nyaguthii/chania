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
              <p>Claims</p>
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
                  <th>Date</th>
                  <th>Amount(kshs)</th>
                  <th>Customer</th>
                  <th>Vehicle</th>
                  <th>Policy</th>
                  <th>Driver</th>
                  <th>Driver's Contact</th>
                  <th></th>
                </tr>
              @foreach($claims as $claim)
                <tr>
                  <td>{{$claim->id}}</td>
                  <td>{{Carbon\Carbon::parse($claim->transaction_date)->format('d-m-Y')}}</td>
                  @if($claim->excess)
                  <td>{{number_format($claim->excess->amount)}}</td>
                  @else
                  <td>{{0}}</td>
                  @endif
                  
                  <td>{{$claim->policy->customer->firstname}} {{$claim->policy->customer->lastname}}</td>
                  <td>{{$claim->policy->vehicle->registration}}</td>
                  <td>{{$claim->policy->policy_no}}</td>
                  <td>{{$claim->driver_name}}</td>
                  <td>{{$claim->driver_contact}}</td>
                  <td><a href="{{route('claims.edit',['claim'=>$claim->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                  @if($claim->excess)
                  <td><a href="{{route('excesses.edit',['excess'=>$claim->excess->id])}}" class="btn btn-xs btn-primary">Edit Excess</a></td>
                  @else
                  <td><a href="{{route('excesses.create',['claim'=>$claim->id])}}" class="btn btn-xs btn-success">Take Excess</a></td>
                  @endif
                </tr>
              @endforeach

              </table>
              
            </div>
            <div class="box-footer">
              {{$claims->links()}}
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