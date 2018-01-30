@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Payments</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="suspensionsDataTable" class="table table-bordered table-striped">
              <thead>
              <tr>
               <th>Id</th>
               <th>Effective DAte</th>
               <th>Customer</th>
               <th>Vehicle</th>
               <th>Policy</th>
              </tr>
              </thead>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
    <!-- /.content -->
</div>
  
@endsection