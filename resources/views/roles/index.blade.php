@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Roles
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard">Roles</i></a></li>
        <li class="active"></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{route('roles.create')}}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span> Add a Role </a>


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
                  <th>Description</th>
                @foreach($roles as $role)
                <tr>
                  <td>{{$role->id}}</td>
                  <td>{{$role->name}}</td>
                  <td>{{$role->description}}</td>
                  <td><a href="{{route('roles.edit',['role'=>$role->id])}}" class="btn btn-xs btn-warning">Edit</a>  
                  </td>
                  <td><form action="{{route('roles.delete',['role'=>$role->id])}}" method="post">
                    {{ csrf_field() }}
                  <button type="submit" class="btn btn-sm btn-danger" >Delete</button>
                  </form></td> 
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>
  
@endsection