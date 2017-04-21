@extends('layouts.master')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
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
                <b>Premium</b> <a class="pull-right">{{$policy->total_premium}}</a>
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
                <b>Vehicle</b> <a class="pull-right">{{$policy->vehicle->registration}}</a>
              </li>
              @if($policy->refund)
              <li class="list-group-item">
                <b>Refund</b> <a class="pull-right">Kshs {{$policy->refund->amount}}</a>
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
            </ul>
            @if($policy->status === 'cancelled' && !$policy->refund)

                <a href="{{route('refunds.create',['policy'=>$policy->id])}}" class="btn btn-primary btn-block"><b>Take Refund</b></a>
            @endif
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
                  <th>ID</th>
                  <th>Date</th>
                  <th>Amount Paid</th>              
                </tr>
              {{$payments = $policy->payments()->paginate(20)}}
              @foreach($payments as $payment)
                <tr>
                  <td></td>
                  <td>{{$payment->id}}</td>
                  <td>{{$payment->transaction_date}}</td>
                  <td>{{$payment->amount}}</td>
                  <td><a href="{{route('receipts.show',['receipt'=>$payment->receipt->id])}}" class="btn btn-xs btn-info">Print Receipt</a></td>
                  <td><a href="{{route('payments.edit',['customer'=>$customer->id,'payment'=>$payment->id])}}" class="btn btn-xs btn-warning">Edit Payment</a></td>
              @endforeach
              </table>
            </div>
            <div class="box-footer">
              {{$payments->links()}}
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"> Total(Kshs) {{$payments->sum('amount')}}</button>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>      
    </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

  