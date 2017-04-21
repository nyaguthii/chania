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
              <a href="/customers/create" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Customer </a>


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
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Insured ID</th>
                  <th>Is Member</th>
                  <th></th>
                </tr>
              @foreach($customers as $customer)
                <tr>
                  <td>{{$customer->id}}</td>
                  <td>{{$customer->firstname}}</td>
                  <td>{{$customer->lastname}}</td>
                  <td>{{$customer->insured_id}}</td>
                  <td>
                   <span 
                        @if($customer->is_member ==0)
                        class="label label-danger"
                        @elseif($customer->is_member ==1)
                        class="label label-success"
                        @endif
                        >
                        @if($customer->is_member ==0)
                        no
                        @elseif($customer->is_member ==1)
                        yes
                        @endif
                    </span>
                  </td>
                  <td><a href="{{route('customers.edit',['customer'=>$customer->id])}}" class="btn btn-xs btn-warning">edit</a></td>
                  <td><a href="/customers/{{$customer->id}}" class="btn btn-xs btn-info">details</a></td>
                </tr>
              @endforeach

              </table>
              
            </div>
            <div class="box-footer">
              {{$customers->links()}}
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-primary pull-right"> Total Number: {{count($customers)}}</button>
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