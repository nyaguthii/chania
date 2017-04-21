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
            Commissions
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
                  <th>Policy</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Amount Paid</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              @foreach($commissions as $commission)
                <tr>
                  <td><a href="#" class="btn btn-xs btn-info">Show</a></td>
                  <td>{{$commission->id}}</td>
                  <td>{{$commission->endorsement->policy->policy_no}}</td>
                  <td>{{$commission->created_at->toDateString()}}</td>
                  <td>{{$commission->amount}}</td>
                  <td>{{$commission->payments->sum('amount')}}</td>
                  <td>
                  <span 
                        @if($commission->status === 'open')
                        class="label label-danger"
                        @elseif($commission->status === 'paid')
                        class="label label-success"
                        @endif
                      >{{$commission->status}}
                    </span>
                  </td>
                  <td>
                    <a href="{{route('commission.payments.create',['commission'=>$commission->id])}}" class="btn btn-xs btn-info">Take Payment</a>
                  </td>

                </tr>
              @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              {{$commissions->links()}}
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>
  
@endsection