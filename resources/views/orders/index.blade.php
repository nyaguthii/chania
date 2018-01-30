@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Orders
      </h1>
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Orders</h3>
              <a href="{{route('orders.create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Order</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="ordersTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Order Id</th>
                  <th>Customer Id</th>
                  <th>Customer</th>
                  <th>Transaction Date</th>
                  <th>Amount</th>
                  <th>Cost</th>
                  <th>Profit</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection