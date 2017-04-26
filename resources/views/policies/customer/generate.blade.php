@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        {{$policy->policy_no}}
      </h1>
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
                  <td>{{$endorsement->created_at->toDateString()}}</td>
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
                    <div class="form-group">
                      <label>
                        <input type="checkbox" class="flat-red" name="is_pay_daily" value="yes" id="isPayDaily">
                        Is Pay Daily ?
                      </label>
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
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Agency Commissions</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <b>Total Commission</b> <a class="pull-right">{{$policy->getTotalCommission()}}</a>
                  </li>
                </ul>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
              </div>
          </div>
        </div> 
      </div>
      @if($policy->status !== 'cancelled')
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
                  <th>Amount Paid</th>
                  <th>Balance</th>
                  <th>Status</th>
                  <th></th>               
                </tr>
              @foreach($policy->paymentSchedules as $paymentSchedule)
                <tr>
                  <td></td>
                  <td>{{$paymentSchedule->due_date}}</td>
                  <td>{{$paymentSchedule->amount}}</td>
                  <td>{{$paymentSchedule->amount_paid}}</td>
                  <td>{{$paymentSchedule->amount-$paymentSchedule->amount_paid}}</td>
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
                  @if($paymentSchedule->status === 'open')
                  <a href="{{route('payments.create',['paymentSchedule'=>$paymentSchedule->id])}}" class="btn btn-xs btn-info">Take Payment</a>
                  @elseif($paymentSchedule->status === 'paid')
                  <a href="#" class="btn btn-xs btn-warning">View Payment</a>
                  @endif
                  </td>
                </tr>  
              @endforeach
              <tr>
                  <td></td>
                  <td></td>
                  <td><button type="button" class="btn btn-primary ">{{$policy->paymentSchedules->sum('amount')}}</button></td>
                  <td><button type="button" class="btn btn-primary ">{{$policy->paymentSchedules->sum('amount_paid')}}</button></td>
                  <td><button type="button" class="btn btn-primary ">{{$policy->paymentSchedules->sum('amount') - $policy->paymentSchedules->sum('amount_paid')}}</button></td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>      
      </div>
      @endif
    </section>
    <!-- /.content -->
</div>
  
@endsection