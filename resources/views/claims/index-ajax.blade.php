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
            <h3 class="box-title">Claims</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="claimsDataTable" class="table table-bordered table-striped">
              <thead>
              <tr>
               <th>Id</th>
               <th>Accident Date</th>
               <th>Customer</th>
               <th>Registration</th>
               <th>Policy No</th>
               <th>Driver</th>
               <th>Contact</th>
               <th>Actions</th>
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