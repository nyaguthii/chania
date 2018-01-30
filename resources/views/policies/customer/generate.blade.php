@extends('layouts.master')
@section('content')
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
         <li ><a href="{{route('customer.policies.show',['customer'=>$customer->id,'policy'=>$policy->id])}}"><i></i>Policy</a></li>
        <li class="active">Payment Schedules</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      
      @include('layouts.customer-menu')  
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{route('endorsements.create',$policy->id)}}" class="btn btn-primary btn-sm glyphicon glyphicon-plus">Add an Endorsement</a>      
              <div class="box-tools">
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  <th></th>
                  <th>Policy Number</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Date</th>               
                </tr>
              @foreach($policy->endorsements as $endorsement)
                <tr>
                  <td><a href="{{route('endorsements.edit',['endorsement'=>$endorsement->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                  <td>{{$endorsement->policy->policy_no}}</td>
                  <td>{{$endorsement->type}}</td>
                  <td>{{$endorsement->amount}}</td>
                  <td>{{$endorsement->created_at->format('d-m-Y')}}</td>
                </tr>
              @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>      
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-header with-border">
            Generate Payments      
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('paymentSchedules.store',['policy'=>$policy->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 
                  <!-- /.form-group -->
                  <div class="form-group">
                      <label>Payment Type</label>
                      <select name="type" class="form-control">
                        <option>Agency Bill</option>
                      </select>
                    </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">              
                  <!-- /.form-group -->
                    <div class="form-group">
                      <label for="remaining-payments">Remaining Payments</label>
                      <input name="remaining-payments" type="text" class="form-control" id="remaining-payments" >
                    </div>
                  <!-- /.form-group -->
                </div>

                <!-- /.col -->
              </div>
              <row>
                @include('layouts.error')
              </row>
              <!-- /.row -->
            </div>
            <div class="box-footer">
              @if($policy->checkPaymentSchedule())
              <button type="submit" onclick="if (!confirm('Are you sure?')) return false;" class="btn btn-warning">Re-Generate Payments</button>
              @elseif(!$policy->checkPaymentSchedule())
              <button type="submit" onclick="if (!confirm('Are you sure?')) return false;" class="btn btn-primary">Generate Payments</button>
              @endif
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
            <div class="box-header with-border">
            Payments     
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
                  <th>Due Date</th>
                  <th>Premium</th>
                  <th>Life Status</th>
                  <th>Payment Status</th>
                  <th></th>               
                </tr>
              @foreach($policy->paymentSchedules as $paymentSchedule)
                <tr>
                  <td><a href="{{route('paymentSchedules.edit',['paymentSchedule'=>$paymentSchedule->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                  <td>{{Carbon\Carbon::parse($paymentSchedule->due_date)->format('d-m-Y')}}</td>
                  <td>{{number_format($paymentSchedule->amount)}}</td>
                  <td>{{$paymentSchedule->lifeline_status}}</td>
                  <td>
                    <span 
                        @if($paymentSchedule->status === 'open')
                        class="label label-danger"
                        @elseif($paymentSchedule->status === 'paid')
                        class="label label-success"
                        @endif
                      >{{$paymentSchedule->status}}
                    </span>

                  </td>
                  <td>
                  @if($paymentSchedule->lifeline_status === 'active')
                  @if($paymentSchedule->status === 'open')
                  <a href="{{route('prepayments.create',['paymentSchedule'=>$paymentSchedule->id])}}" class="btn btn-xs btn-info">Take Payment</a>
                  @elseif($paymentSchedule->status === 'paid')
                  <form action="{{route('prepayments.update',['paymentSchedule'=>$paymentSchedule->id])}}" method="POST">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-xs btn-warning">Reverse Payment</button>
                  </form>
                  @endif
                  @endif
                  </td>
                </tr>  
              @endforeach
              </table>
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-left"> Total Premium:Kshs {{number_format($policy->paymentSchedules->sum('amount'))}} </button>
              <button type="button" class="btn btn-success pull-left"> Total Paid:Kshs {{number_format($policy->paymentSchedules->where('status','paid')->sum('amount'))}} </button>
              <button type="button" class="btn btn-danger pull-left">Balance:Kshs {{number_format($policy->paymentSchedules->sum('amount')-$policy->paymentSchedules->where('status','paid')->sum('amount'))}} </button>
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