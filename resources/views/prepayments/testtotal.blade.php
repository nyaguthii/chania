@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Total Payments Per Day <span style="color:green"></span></h3>


              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  
                  <th>Date</th>
                  <th>Form</th>
                  <th>Amount(Kshs)</th>     
                </tr>
              @foreach($results as $payment)
                <tr>
                  <td>{{$payment->transaction_date}}</td>
                  <td>{{$payment->place}}</td>
                  <td>{{number_format($payment->total_collection)}}</td>
                </tr>
              @endforeach
              </table>
              
            </div>
              
            <!-- /.box-body -->
            <div class="box-footer">
             <?php echo $results->setPath('URI')->render() ?>
            </div>
            <div class="box-footer">
            </div>
      </div>     
    </section>
    <!-- /.content -->
</div>  
@endsection