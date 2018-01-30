@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
       
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
    
      <!-- /.row --> 
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              Edit a Product     
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('products.update',['product'=>$product->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="policy-id">Name</label>
                                <input class="form-control" name="name" value="{{$product->name}}" >
                            </div> 
                            <div class="form-group">
                                <label >Unit Cost</label>
                                <input name="unit_cost"  class="form-control"   value="{{$product->unit_cost}}">
                            </div>

                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                                <label >Selling Price</label>
                                <input name="selling_price"  class="form-control" value="{{$product->selling_price}}">
                            </div>

                        </div>
                    
                    </div>
                    
                    <divclass="form-group">
                      @include('layouts.error') 
                    </div>                
                </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Edit</button>
            </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      
    </section>
    <!-- /.content -->
</div>
  
@endsection