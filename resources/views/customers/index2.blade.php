@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Customers
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{route('customers.create2')}}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Customer </a>


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
                  <th>First Name</th>                  
                  <th>Middle Name</th>
                  <th>Pin</th>
                  <th></th>
                </tr>
              @foreach($customers as $customer)
                <tr>
                  <td>{{$customer->id}}</td>
                  <td>{{$customer->firstname}}</td>
                  <td>{{$customer->middlename}}</td>
                  <td>{{$customer->pin}}</td>
                  <td><a href="{{route('customers.edit',['customer'=>$customer->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                  <td><a href="{{route('customers.show',['customer'=>$customer->id])}}" class="btn btn-xs btn-info">details</a></td>
                </tr>
              @endforeach

              </table>
              
            </div>
            <div class="box-footer">
              {{$customers->links()}}
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"> Total Number: {{count($customers)}}</button>
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