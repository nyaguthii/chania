@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname." ".$customer->lastname}}
        <small>Policies</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('customers.show',['customer'=>$customer->id])}}"><i class="fa fa-dashboard"></i>Customer</a></li>
        <li class="active">policies</li>
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
            <a class="btn btn-primary btn-sm glyphicon glyphicon-plus" href="{{route('customer.policies.create', ['customer' => $customer->id])}}">add a policy</a>    
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
                  <th></th>
                  <th></th>
                  <th>ID</th>
                  <th>Policy Number</th>
                  <th>Effective Date</th>
                  <th>Expiry Date</th>
                  <th>Total Premium(Kshs)</th>
                  <th>Vehicle</th>
                  <th>Status</th>
                  
                </tr>
              @foreach($policies as $policy)
                <tr>
                  <td><a href="{{route('customer.policies.generate',['customer'=>$customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-info">details</a></td>
                  <td><a href="{{route('customer.policies.show',['customer'=>$customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-primary">show</a></td>
                  <td><a href="{{route('customer.policies.edit',['customer'=>$customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-default">edit</a></td>
                  <td>{{$policy->id}}</td>
                  <td>{{$policy->policy_no}}</td>
                  <td>{{$policy->effective_date->format('d-m-Y')}}</td>
                  <td>{{$policy->expiry_date->format('d-m-Y')}}</td>
                  
                  <td>{{number_format($policy->total_premium)}}</td>
                  <td>{{$policy->vehicle->registration}}</td>
                  <td>
                    <span 
                        @if($policy->status === 'active')
                        class="label label-success"
                        @elseif($policy->status === 'expired')
                        class="label label-default"
                        @elseif($policy->status === 'cancelled')
                        class="label label-danger"
                        @elseif($policy->status === 'drafted')
                        class="label label-primary"
                        @elseif($policy->status === 'suspended')
                        class="label label-warning"
                        @endif
                      >{{$policy->status}}
                    </span>
                  </td>
                </tr>
              @endforeach
              </table>
            </div>
            <div class="box-footer">
              {{$policies->links()}}
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