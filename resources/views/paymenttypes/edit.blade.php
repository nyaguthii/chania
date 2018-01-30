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
        <div class="col-xs-8">
          <div class="box">
            <div class="box-header">
              Edit a Payment Type    
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('paymenttypes.update',['paymentType'=>$paymentType->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                 
                  <!-- /.form-group -->
                     <div class="form-group">
                        <label >Name</label>
                        <input name="name"  class="form-control"  placeholder="Name" value="{{$paymentType->name}}">
                      </div>
                      <div class="col-md-12">
                        <div class="row">
                        @include('layouts.error') 
                      </div>
                    </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              <!-- /.row -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Add</button>
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