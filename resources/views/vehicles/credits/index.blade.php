@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname." ".$customer->lastname}}
        <small>{{$vehicle->registration}}</small>
        <small>Credit</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('customers.index',['is_member'=>$customer->is_member])}}"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li><a href="{{route('customers.show',['customer'=>$customer->id])}}"><i ></i>Customer</a></li>
        <li><a href="{{route('customers.vehicles.index',['customer'=>$customer->id])}}"><i class="fa fa-dashboard"></i>Vehicles</a></li>
        <li><a href="{{route('customers.vehicles.show',['customer'=>$customer->id,'vehicle'=>$vehicle->id])}}"><i class="fa fa-dashboard"></i>Vehicle</a></li>
        <li class="active">Credits</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      @if(isset($customer))
      @include('layouts.customer-menu')
      @endif
      <div class="row">   
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">           
            <a class="btn btn-primary btn-flat glyphicon glyphicon-plus" href="{{route('vehicles.credits.create', ['vehicle' => $vehicle->id])}}">add a Due Amount</a>    
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-condensed">
              <tr>
                  <th>ID</th>
                  <th>Transaction Date</th>
                  <th>Amount</th>
                  <th>Description</th>                 
                </tr>
              @foreach($vehicle->vehicleCredits()->orderBy('id','desc')->paginate(50) as $credit)
                <tr>
                  <td>{{$credit->id}}</td>
                  <td>{{Carbon\Carbon::parse($credit->transaction_date)->format('d-m-Y')}}</td>
                  <td>{{number_format($credit->amount)}}</td>
                  <td>{{$credit->description}}</td>
                  @if($credit->type==="Manual")
                  <td><a href="{{route('vehicles.credits.edit',['credit'=>$credit->id])}}" class="btn btn-xs btn-warning">Edit</a></td>
                  @endif
                </tr>
              @endforeach
              </table>
            </div>
            <div class="box-footer">
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        
        <!-- Modal -->       
      </div>
    </section>
    <!-- /.content -->
</div>
  
@endsection