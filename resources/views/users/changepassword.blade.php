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
          <h3 class="box-title">Create Users</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <form action="{{route('users.updatepassword',['user'=>$user->id])}}" method="POST" role="form">
             {{ csrf_field() }}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
             
              <!-- /.form-group -->
                <div class="form-group">
                  <label >Name</label>
                  <input name="name"  class="form-control"  placeholder="Name" value="{{$user->name}}">
                </div>
                <div class="form-group">
                  <label for="old_password">Old Password</label>
                  <input type="password" name="old_password"  class="form-control" id="email" placeholder="Old Password"
                  >
                </div> 
                <div class="form-group">
                  <label >New Password</label>
                  <input type="password" name="password"  class="form-control"  placeholder="New Password" >
                </div>
                <div class="form-group">
                  <label >Repeat Password</label>
                  <input type="password" name="password_confirmation"  class="form-control"  placeholder="Repeat Password" >
                </div>
            </div>
            <!-- /.col -->
          </div>
          <row>
            @include('layouts.error')
          </row>
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