@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transactions
      </h1>
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Material Transactions</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="materialTransactionsTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>id</th>
                  <th>Product</th>
                  <th>Type</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Transaction Date</th>
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
<form action="{{URL::to('/products')}}" method="POST" id="createProductForm">
{{ csrf_field() }}
<div class="modal fade" id="create-products-modal">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <div id="create-product-message">
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Product</h4>
        </div>
        <div class="modal-body">
       
            <div class="row">
                <div  class="form-group" id="add-brand-messages">
                 
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                    <input type="text" name="product" class="form-control" id="productName" placeholder="Name" required>
                    </div>
                </div>
            </div> 
          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="submitProductButton" >Add</button>
        </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</form> 
@endsection