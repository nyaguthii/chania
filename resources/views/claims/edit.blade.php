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
              Edit a Claim     
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('claims.update',['claim'=>$claim->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 
                  <!-- /.form-group -->
                    <div class="form-group">
                        <label>Transaction Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="transaction_date" type="text" class="form-control pull-right" id="datepicker" value="{{Carbon\Carbon::parse($claim->transaction_date)->format('m/d/Y')}}" >
                        </div>
                        <!-- /.input group -->
                      </div>
                      <div class="form-group">
                        <label>Accident Date:</label>

                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input name="accident_date" type="text" class="form-control pull-right" id="accidentdatepicker" value="{{Carbon\Carbon::parse($claim->accident_date)->format('m/d/Y')}}">
                        </div>
                        <!-- /.input group -->
                      </div>
                      <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                    </div>   
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">              
                  <!-- /.form-group -->                      
                    <div class="form-group">
                      <label for="policy-id">Driver's Name</label>
                      <input class="form-control" name="driver_name" value="{{$claim->driver_name}}">
                  <!-- /.form-group -->
                    </div>
                    <div class="form-group">
                      <label for="policy-id">Driver's Contact</label>
                      <input class="form-control" name="driver_contact" value="{{$claim->driver_contact}}">
                  <!-- /.form-group -->
                    </div>
                  <div class="col-md-12">
                    <div class="row">
                    @include('layouts.error') 
                  </div>
                  </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Add</button>
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