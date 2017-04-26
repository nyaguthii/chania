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
              <p>Refunds</p>
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
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>Vehicle</th>
                  <th></th>
                </tr>
              @foreach($refunds as $refund)
                <tr>
                  <td>{{$refund->id}}</td>
                  <td>{{$refund->policy->policy_no}}</td>
                  <td>{{$refund->policy->customer->firstname}} {{$refund->policy->customer->lastname}}</td>
                  <td>{{$refund->amount}}</td>
                  <td>{{$refund->policy->vehicle->registration}}</td>
                  <td><a href="{{route('refunds.edit',['refund'=>$refund->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                </tr>
              @endforeach

              </table>
              
            </div>
            <div class="box-footer">
              {{$refunds->links()}}
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"> Total Number: {{$refunds->sum('amount')}}</button>
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