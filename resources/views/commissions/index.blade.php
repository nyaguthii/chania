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
                  <th></th>
                  <th>ID</th>
                  <th>Policy</th>
                  <th>Vehicle</th>
                  <th>Date</th>
                  <th>Premium Amount(Kshs)</th>
                  <th>Commission(kshs)</th>
                </tr>
              @foreach($commissions as $commission)
                <tr>
                  <td></td>
                  <td>{{$commission->id}}</td>
                  <td>{{$commission->policy->policy_no}}</td>
                  <td>{{$commission->policy->vehicle->registration}}</td>
                  <td>{{$commission->created_at->format('d-m-Y')}}</td>
                  <td>{{number_format($commission->amount)}}</td>
                  <td>{{number_format($commission->amount*0.1-$commission->amount*0.01)}}</td>
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