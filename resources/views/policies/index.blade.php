@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$customer->firstname." ".$customer->lastname}}
      </h1>
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
            <a class="btn btn-primary btn-sm glyphicon glyphicon-plus" href="{{route('policies.create', ['customer' => $customer->id])}}">add a policy</a>    
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
                  <td><a href="{{route('policies.generate',['customer'=>$customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-info">details</a></td>
                  <td><a href="{{route('policies.show',['customer'=>$customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-primary">show</a></td>
                  <td><a href="{{route('policies.edit',['customer'=>$customer->id,'policy'=>$policy->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                  <form action="{{route('policies.cancel',['customer'=>$customer->id,'policy'=>$policy->id])}}" method="POST" >
                  {{ csrf_field() }} 
                  <td><button  type="submit" class="btn btn-xs btn-danger">Cancel</button></td>
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
                        class="label label-warning"
                        @elseif($policy->status === 'cancelled')
                        class="label label-danger"
                        @elseif($policy->status === 'drafted')
                        class="label label-primary"
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
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <form action="/customers/{{$customer->id}}/policies" method="POST" id="policy-form">
              {{ csrf_field() }}
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Policy Details</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                    
                      <div class="col-md-6">
                        <div class="box box-primary">
                          <div class="box-header">
                            <h3 class="box-title">General</h3>
                          </div>
                          <div class="box-body">
                            <div class="form-group">
                              <label for="policy-id">Policy Number</label>
                              <input class="form-control" name="policy-no" placeholder="Policy Number" >
                            </div>
                            <!-- Date -->
                            <div class="form-group">
                              <label>Effective Date:</label>

                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input name="effective-date" type="text" class="form-control pull-right" id="datepicker" required>
                              </div>
                              <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <div class="form-group">
                                <label>Type</label>
                                <select  class="form-control" name="duration-type" id="duration" required>
                                  <option>Annual</option>
                                  <option>Semi Annual</option>
                                  <option>Quartely</option>
                                  <option>Monthly</option>
                                </select>
                              </div>
                              <div class="form-group">
                              <label>Expiry Date:</label>

                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="expiry-date">
                              </div>
                              <!-- /.input group -->
                            </div>
                          </div>
                          <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                      </div>
                      <div class="col-md-6">
                        <div class="box box-primary">
                          <div class="box-header">
                            <h3 class="box-title">Addition</h3>
                          </div>
                          <div class="box-body">
                            <div class="form-group">
                              <label for="carrier">Carrier</label>
                              <input  class="form-control" name="carrier" placeholder="Carrier" required>
                            </div>
                            <!-- Date -->
                            <!-- /.form group -->
                          </div>
                          <!-- /.box-body -->
                        </div>
                        <div class="box box-primary">
                          <div class="box-header">
                            <h3 class="box-title">Agents</h3>
                          </div>
                          <div class="box-body">
                            <div class="form-group">
                              <label for="agent">Agent</label>
                              <input class="form-control" name="agent" placeholder="Agent" required>
                            </div>
                            <!-- Date -->
                            <!-- /.form group -->
                          </div>
                          <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                      </div>                        
                        <!-- /.col (right) -->
                      </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-save" type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>       
      </div>
    </section>
    <!-- /.content -->
</div>
  
@endsection