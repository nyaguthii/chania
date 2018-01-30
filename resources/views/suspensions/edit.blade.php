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
        <div class="col-xs-8">
          <div class="box">
            <div class="box-header">
              Edit a Suspension     
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('suspensions.update',['suspension'=>$suspension->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                 
                  <!-- /.form-group -->
                    <div class="form-group">
                        <label>Effective Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="effective_date" type="text" class="form-control pull-right"  id="datepicker" value="{{Carbon\Carbon::parse($suspension->effective_date)->format('m/d/Y')}}" >
                        </div>
                        <!-- /.input group -->
                      </div>
                      <div class="col-md-12">
                        <div class="row">
                        @include('layouts.error') 
                      </div>
                    </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              <!-- /.row -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Suspend</button>
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