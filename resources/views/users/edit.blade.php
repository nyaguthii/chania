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
          <h3 class="box-title">Edit User</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <form action="{{route('users.update',['user'=>$user->id])}}" method="POST" role="form">
             {{ csrf_field() }}
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
             
              <!-- /.form-group -->
                <div class="form-group">
                  <label >Name</label>
                  <input name="name"  class="form-control"   value="{{$user->name}}">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input name="email"  class="form-control" id="email" 
                  value="{{$user->email}}">
                </div> 
                <div class="form-group">
                <label>Roles</label>
                <select name="role[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Role"
                        style="width: 100%;">
                    @foreach($roles as $role)
                      <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group"> 
                <label>
                    <input type="checkbox" class="flat-red" name="is_active" value="1" 

                    @if($user->is_active=="yes")
                    checked
                    @endif
                    >
                    is Active?
                  </label>
                </div>
              <!-- /.form-group -->
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