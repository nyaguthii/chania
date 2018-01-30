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
              <table class="table table-condensed">
              <tr>
                  
                  <th>Date</th>
                  <th>Place</th>
                  <th>Amount(Kshs)</th>     
                </tr>
              @foreach($payments as $payment)
                <tr>
                  <td>{{Carbon\Carbon::parse($payment->transaction_date)->format('d-m-Y')}}</td>
                  <td>{{$payment->paid_from}}</td>
                  <td>{{number_format($payment->total_collection)}}</td>
                </tr>
              @endforeach
              </table>
              
            </div>
              
            <!-- /.box-body -->
            <div class="box-footer">
             @if($total_rows>0)
             <?php 
             $pages = ceil($total_rows/$items_per_page);
             ?>
             <ul class="pagination">

                <li 
                  @if($page==1)
                   class="disabled"
                   @endif
                ><a href="{{route('prepayments.totalperday')}}?page=1" rel="next">«</a></li>
                @for($i=1;$i<=$pages;$i++)
                  @if($i==$page)
                    <li class="active"><span>{{$i}}</span></li>
                  @else
                    <li><a href="{{route('prepayments.totalperday')}}?page={{$i}}">{{$i}}</a></li>
                  @endif
                @endfor
                <li
                  
                  @if($page==$pages)
                   class="disabled"
                   @endif
                ><a href="{{route('prepayments.totalperday')}}?page={{$pages}}" rel="next">»</a></li>
            </ul>
            @endif
            </div>
            <div class="box-footer">
            </div>
      </div>
      </div>
           
    </section>
    <!-- /.content -->
</div>  
@endsection