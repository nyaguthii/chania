@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard">Users</i></a></li>
        <li class="active"></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{route('users.create')}}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span> Add a User </a>


              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                 <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
              <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Actions</th>
              @foreach($users as $user)
                <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->name}}</td>
                  <td><a href="{{route('users.edit',['user'=>$user->id])}}" class="btn btn-xs btn-warning">Edit</a>  
                  </td>
                  <td><form action="{{route('users.destroy',['user'=>$user->id])}}" method="post">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-sm btn-danger" >Delete</button>
                  </form></td> 
                </tr>
              @endforeach
             
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              {{$users->links()}}
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
</div> 
@endsection