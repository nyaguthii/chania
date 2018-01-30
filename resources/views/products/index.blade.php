@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Products 
      </h1>
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Products</h3>
              <a href="{{route('products.create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Add Product</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="productsTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>id</th>
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Cost Price</th>
                  <th>Selling Price</th>
                  <th class="pull-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                <tr>
                  <td>{{$product->id}}</td>
                  <td>{{$product->name}}</td>
                  <td>{{number_format($product->materialTransactions()->where('type','In')->sum('quantity')-$product->materialTransactions()->where('type','Out')->sum('quantity'))}}</td>
                  <td>{{number_format($product->unit_cost)}}</td>
                  <td>{{number_format($product->selling_price)}}</td>
                  <td> 
                  <div class="pull-right">
                    <a href="{{route('inout.create',['product'=>$product->id])}}" class=" btn btn-xs btn-primary "><i class="fa fa-plus "></i>Transactions</a>
                    <a href="{{route('products.edit',['product'=>$product->id])}}" class=" btn btn-xs btn-warning "><i class="fa fa-pencil "></i>Edit</a>
                    <a href="{{route('products.delete',['product'=>$product->id])}}" class=" btn btn-xs btn-danger"><i class="fa ffa-trash "></i>Delete</a>
                  </div> 
                  </td>
                </tr>
               @endforeach 
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Actions</th>
                  
                </tr>
                </tfoot>
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