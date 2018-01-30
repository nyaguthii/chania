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
              Edit Roles    
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('roles.update',['role'=>$role->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">              
                  <!-- /.form-group --> 
                    <div class="form-group">
                      <label for="policy-id"></label>
                      <input class="form-control" name="name" placeholder="Name" value="{{$role->name}}">
                  <!-- /.form-group -->
                    </div>
                    <div class="form-group">
                      <label for="policy-id">Description</label>
                      <input class="form-control" name="description" placeholder="Description" value="{{$role->description}}">
                  <!-- /.form-group -->
                    </div>
                  <div class="col-md-12">
                    <div class="row">
                    @include('layouts.error') 
                  </div>
                  </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
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