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
            <h3 class="box-title">Refunds</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="refundsDataTable" class="table table-bordered table-striped">
              <thead>
              <tr>
               <th>Id</th>
               <th>Reference</th>
               <th>Policy No</th>
               <th>Customer</th>
               <th>Amount</th>
               <th>Vehicle</th>
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