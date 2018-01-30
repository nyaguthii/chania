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
      <!-- /.row -->

      <form method="POST" action="{{route('orders.store')}}">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <p>Search</p>
              <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
              <div class="col-xs-6">
                  <div class="form-group">
                        <label>Transaction Date:</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="transaction_date" type="text" class="form-control pull-right" id="datepicker" >
                        </div>
                        <!-- /.input group -->
                    </div>
                  <div class="form-group">
                  <label>Customer</label>
                  <select id="customers-select2" name="customer" class="form-control select2"  
                          style="width: 100%;">
                      <option value=""></option>
                      @foreach($customers as $key=>$customer)
                      <option value="{{$key}}">{{$customer}}</option>
                      @endforeach
                  </select>
                  </div>
                  <div class="form-group">
                    <label for="selling_price">Override Selling Price</label>
                    <input class="form-control" id="selling_price" name="selling_price"  placeholder="Price">
                <!-- /.form-group -->
                  </div>
              </div>
              <div class="col-xs-6">
              <div class="form-group">
                  <label>Product</label>
                  <select id="products-select2" class="form-control select2"  
                          style="width: 100%;">
                      <option value=""></option>
                      @foreach($products as $key=>$product)
                      <option value="{{$key}}">{{$product}}</option>
                      @endforeach
                  </select>
                  </div>
                  <div class="form-group">
                      <label for="quantity">Quantity</label>
                      <input class="form-control" id="quantity" name="quantity"  placeholder="Quantity">
                  <!-- /.form-group -->
                  </div>
                  @include('layouts.error') 
              </div>
            </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button id="sales_add_line" type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Add Line</button>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover ordersTable">
                <tr> 
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>                  
                  <th>Total Amount</th>
                </tr>
              </table>
              
            </div>
            <div class="box-footer">
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Create Order</button>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      </form>
    </section>
    <!-- /.content -->
</div> 
@endsection