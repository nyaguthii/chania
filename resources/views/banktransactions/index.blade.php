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
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><a href="{{route('banktransactions.create')}}">Make a Transaction</a></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Transaction ID</th>
                    <th>Amount(kshs)</th>
                    <th>Type</th>
                    <th>From</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($bankTransactions as $bankTransaction)
                  <tr>
                    <td>{{$bankTransaction->transaction_date}}</td>
                    <td>{{$bankTransaction->transaction_id}}</td>
                    <td>{{number_format($bankTransaction->amount)}}</td>
                    <td>{{$bankTransaction->type}}</td>
                    <td>{{$bankTransaction->place}}</td>
                    <td><a href="{{route('banktransactions.edit',['bankTransaction'=>$bankTransaction->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                  </tr>
                  @endForeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <div class="box-footer">
              {{$bankTransactions->links()}}
            </div>
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Balance Kshs {{number_format($bankTransactions->sum('amount'))}}</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right"></a>
            </div>
            <!-- /.box-footer -->
          </div>   
        </div>
      </div>           
    </section>
    <!-- /.content -->
</div>  
@endsection