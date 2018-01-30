@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              Over Paid Customers 
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  <th>Id</th>
                  <th>Member No</th>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Contact</th>
                  <th>Difference(Kshs)</th>
                  
                </tr>
              @foreach($customers as $customer)
               @if($customer->difference() > 0)
                <tr>
                  <td>{{$customer->id}}</td>
                  <td>{{$customer->member_id}}</td>
                  <td>{{$customer->firstname}}</td>
                  <td>{{$customer->lastname}}</td>
                  <td>{{$customer->contact}}</td>
                  <td>{{number_format($customer->difference())}}</td>
                </tr>
                @endif
              @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            {{$customers->links()}}
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
</div> 
@endsection