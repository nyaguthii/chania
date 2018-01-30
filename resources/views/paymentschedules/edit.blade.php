@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
    
      <!-- /.row --> 
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              Edit Due Date     
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('paymentSchedules.update2',['paymentSchedule'=>$paymentSchedule->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 
                  <!-- /.form-group -->
                    <div class="form-group">
                        <label>Due Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" value="{{Carbon\Carbon::parse($paymentSchedule->due_date)->format('m/d/Y')}}"  disabled>
                        </div>
                        <!-- /.input group -->
                      </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>New Due Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="new_due_date" type="text" class="form-control pull-right" id="datepicker" >
                        </div>
                        <!-- /.input group -->
                      </div>
                      
                  <!-- /.form-group -->
                </div>
                  <!-- /.form-group -->
                </div>
                
                <!-- /.col -->
              <!-- /.row -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Edit</button>
            </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      
    </section>
    <!-- /.content -->
</div>
  
@endsection