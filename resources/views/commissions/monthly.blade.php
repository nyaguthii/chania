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
            <h3 class="box-title">Monthly Commissions</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="monthlyCommissionsDataTable" class="table table-bordered table-striped">
              <thead>
              <tr>
               <th>Month</th>
               <th>Company</th>
               <th>Amount</th>
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