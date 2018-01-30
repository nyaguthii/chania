@extends('layouts.master')
@section('content')
  <!-- Content Wrapper. Contains page content -->
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
        <li class="active">policy</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
    @include('layouts.customer-menu')
    <div class="row">      
      <div class="col-md-4">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{$policy->policy_no}}</h3>

            <p class="text-muted text-center"></p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Customer</b> <a class="pull-right">{{$policy->customer->firstname}}</a>
              </li>
              <li class="list-group-item">
                <b>Premium</b> <a class="pull-right">{{number_format($policy->total_premium)}}</a>
              </li>
               <li class="list-group-item">
                <b>Type</b> <a class="pull-right">{{$policy->type}}</a>
              </li>
               <li class="list-group-item">
                <b>Carrier</b> <a class="pull-right">{{$policy->carrier}}</a>
              </li>
              <li class="list-group-item">
                <b>Duration</b> <a class="pull-right">{{$policy->duration}}</a>
              </li>
              <li class="list-group-item">
                <b>Effective Date</b> <a class="pull-right">{{$policy->effective_date->format('d-m-Y')}}</a>
              </li>
              <li class="list-group-item">
                <b>Expiry Date</b> <a class="pull-right">{{$policy->expiry_date->format('d-m-Y')}}</a>
              </li>
              <li class="list-group-item">
                <b>Vehicle</b> <a class="pull-right">{{$policy->vehicle->registration}}</a>
              </li>
              @if($policy->refund)
              <li class="list-group-item">
                <b>Refund</b> <a class="pull-right">Kshs {{number_format($policy->refund->amount)}}</a>
              </li>
              @endif
              <li class="list-group-item">
                <b>Status</b> <a class="pull-right">
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
                </a>
              </li>
              @if($policy->status === 'active')
              <li class="list-group-item">
                <a href="{{route('suspensions.create',['policy'=>$policy->id])}}" class="btn btn-warning btn-block"><b>Suspend</b></a>
              </li>
              <li class="list-group-item">
                <a href="{{route('cancellations.create',['policy'=>$policy->id])}}" class="btn btn-danger btn-block"><b>Cancel</b></a>
              </li>
              <li class="list-group-item">
                <a href="{{route('claims.create',['policy'=>$policy->id])}}" class="btn btn-default btn-block"><b>Make a Claim</b></a>
              </li>
              @endif
              @if($policy->status === 'suspended')
              <li class="list-group-item">
                <a href="{{route('suspensions.show',['policy'=>$policy->id])}}" class="btn btn-warning btn-block"><b>Sustain</b></a>
              </li>
              @endif
              @if($policy->status === 'cancelled')
                <li class="list-group-item">
                <form action="{{route('cancellations.activate',['policy'=>$policy->id])}}" method="POST">
                {{ csrf_field() }}
                  <button type="submit" class="btn btn-info btn-block" >
                    Activate Policy
                  </button>
                </form>
                </li>
              
              @endif
              @if($policy->status === 'cancelled' && !$policy->refund)

                <a href="{{route('refunds.create',['policy'=>$policy->id])}}" class="btn btn-primary btn-block"><b>Take Refund</b></a>
              @endif
              
            </ul>
            
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <!-- /.box -->
      </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
            Payments Done   
              <div class="box-tools">     
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                   <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  <th></th>
                  <th>Date</th>
                  <th>Amount Paid(Kshs)</th>              
                </tr>
                @foreach($policy->paymentSchedules()->where('status','paid')->get() as $paymentSchedule)
                  <tr>
                    <td></td>
                    <td>{{$paymentSchedule->due_date}}</td>
                    <td>{{$paymentSchedule->amount}}</td>  
                  </tr>
                @endforeach
              
              </table>
            </div>
            <div class="box-footer">
              
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"> Total(Kshs){{$policy->paymentSchedules()->where('status','paid')->sum('amount')}} </button>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>      
    </div>
        
    </section>
    <!-- /.content -->
    <form action="{{route('customer.policies.cancel',['customer'=>$customer->id,'policy'=>$policy->id])}}" method="POST" >
                      {{ csrf_field() }} 
        <div class="modal modal-danger" tabindex="-1" role="dialog" id="cancelModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Cancel Policy</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-xs-8">
                    <div class="form-group">
                        <label>Effective Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="effective_date" type="text" class="form-control pull-right" id="datepicker" required>
                        </div>
                        <!-- /.input group -->
                      </div>
                    </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      </form>
      <form action="{{route('customer.policies.suspend',['customer'=>$customer->id,'policy'=>$policy->id])}}" method="POST" >
                      {{ csrf_field() }} 
        <div class="modal modal-warning" tabindex="-1" role="dialog" id="suspendModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Suspend Policy</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-xs-8">
                    <div class="form-group">
                        <label>Effective Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="effective_date" type="text" class="form-control pull-right" id="suspenddatepicker" required>
                        </div>
                        <!-- /.input group -->
                      </div>
                    </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      </form>
      <form action="{{route('customer.policies.activate',['customer'=>$customer->id,'policy'=>$policy->id])}}" method="POST" >
                      {{ csrf_field() }} 
        <div class="modal modal-success" tabindex="-1" role="dialog" id="activateModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Activate Policy</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-xs-8">
                    <div class="form-group">
                        <label>Effective Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="effective_date" type="text" class="form-control pull-right" id="activatedatepicker" required>
                        </div>
                        <!-- /.input group -->
                      </div>
                    </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      </form>
      <form action="{{route('customer.policies.sustain',['customer'=>$customer->id,'policy'=>$policy->id])}}" method="POST" >
                      {{ csrf_field() }} 
        <div class="modal modal-success" tabindex="-1" role="dialog" id="sustainModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Sustain Policy</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                  <div class="col-xs-8">
                    <div class="form-group">
                        <label>Effective Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="effective_date" type="text" class="form-control pull-right" id="sustaindatepicker" required>
                        </div>
                        <!-- /.input group -->
                      </div>
                    </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      </form>
    </div>
  <!-- /.content-wrapper -->
  @endsection

  