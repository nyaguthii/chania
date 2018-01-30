@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{route('paymenttypes.create')}}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span> Payment Type </a>

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
                  <th></th>
                </tr>
              @foreach($paymentTypes as $paymentType)
                <tr>
                  <td>{{$paymentType->id}}</td>
                  <td>{{$paymentType->name}}</td>
                  <td><a class="btn btn-warning"href="{{route('paymenttypes.edit',['paymentType'=>$paymentType->id])}}">Edit</a></td>
                  <form action="{{route('paymenttypes.destroy',['paymentType'=>$paymentType->id])}}" method="post">
                   {{ csrf_field() }}
                  <td>
                  <button class="btn btn-xs btn-danger">
                    delete
                  </button>
                  </td>
                  </form>
                </tr>
              @endforeach

              </table>
              
            </div>
            <div class="box-footer">
              
            </div>
            <div class="box-footer">
              
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