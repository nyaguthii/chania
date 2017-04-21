@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add a User
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="/register" method="POST" role="form">
             {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input name=name  class="form-control" id="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input name=email type="email" class="form-control" id="email" placeholder="Enter email" >
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input name=password type="password" class="form-control" id="password" placeholder="Password" >
                </div>
                <div class="form-group">
                  <label for="password_confirmation">Confirm Password</label>
                  <input name=password_confirmation type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" >
                </div>
                
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
            @include('layouts.error')
          </div>
          <!-- /.box -->

        </div>

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection()