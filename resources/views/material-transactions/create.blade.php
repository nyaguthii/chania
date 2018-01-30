@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Product: {{$product->name}}</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <form action="{{route('inout.store',['product'=>$product->id])}}" method="POST" role="form">
             {{ csrf_field() }}
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label >Reference</label>
                  <input name="reference"  class="form-control"  placeholder="Reference" value="{{old('reference')}}">
                </div>
                <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control">
                  <option>In</option>
                  <option>Out</option>
                </select>
              </div>  
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
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">              
              <!-- /.form-group -->
              <div class="form-group">
                  <label for="quantity">Quantity</label>
                  <input name="quantity" type="text" class="form-control" id="quantity" placeholder="Quantity" 
                  >
                </div>
                <div class="form-group">
                  <label for="unit_price">Unit Price</label>
                  <input name="unit_price" type="text" class="form-control" id="unit_price" placeholder="Unit Price" 
                  >
                </div>
                <div class="form-group">
                    @include('layouts.error')
                </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection()