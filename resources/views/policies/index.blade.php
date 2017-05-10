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
              <p>Search</p>
              <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('policies.find')}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-5">
                      <div class="form-group">
                      <label >Policy No</label>
                      <input class="form-control" name="policy_no">
                  <!-- /.form-group -->
                    </div>
                </div>
                <div class="col-md-5">              
                  <!-- /.form-group -->
                  <div class="form-group">
                      <label >Vehicle Registration</label>
                      <input class="form-control" name="registration" >
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
              <p>Policies</p>
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
                  <th></th>
                  <th>ID</th>
                  <th>Policy Number</th>
                  <th>Effective Date</th>
                  <th>Expiry Date</th>
                  <th>Total Premium</th>
                  <th>Vehicle</th>
                  <th>Status</th>
                  
                </tr>
              @foreach($policies as $policy)
                <tr>
                  <td><a href="{{route('customer.policies.generate',['customer'=>$policy->customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-info">details</a></td>
                  <td><a href="{{route('customer.policies.show',['customer'=>$policy->customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-primary">show</a></td>
                  <td><a href="{{route('customer.policies.edit',['customer'=>$policy->customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                  <form action="{{route('customer.policies.cancel',['customer'=>$policy->customer->id,'policy'=>$policy->id])}}" method="POST" >
                  {{ csrf_field() }} 
                  <td><button  type="submit" class="btn btn-xs btn-danger" onclick="if (!confirm('Are you sure you want to Cancel Policy?')) return false;">Cancel</button></td>
                  </form>
                  <td>{{$policy->id}}</td>
                  <td>{{$policy->policy_no}}</td>
                  <td>{{$policy->effective_date->toDateString()}}</td>
                  <td>{{$policy->expiry_date->toDateString()}}</td>
                  
                  <td>{{$policy->total_premium}}</td>
                  <td>{{$policy->vehicle->registration}}</td>
                  <td>
                    <span 
                        @if($policy->status === 'active')
                        class="label label-success"
                        @elseif($policy->status === 'expired')
                        class="label label-info"
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
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"></button>
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