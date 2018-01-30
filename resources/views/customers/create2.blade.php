@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
  
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Customer Details</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <form action="{{route('customers2.store')}}" method="POST" role="form">
             {{ csrf_field() }}
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             
              <!-- /.form-group -->
              <div class="form-group">
                  <label>Type</label>
                  <select name="type" class="form-control">
                    <option>Commercial</option>
                    <option>Private</option>
                    <option>Psv</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="firstname">First Name</label>
                  <input name="firstname"  class="form-control" id="firstname" placeholder="First Name" value="{{old('firstname')}}">
                </div>
                <div class="form-group">
                  <label for="middlename">Middle Name</label>
                  <input name="middlename" type="text" class="form-control" id="middlename" placeholder="Middle Name" value="{{old('middlename')}}">
                </div>
                <div class="form-group">
                  <label for="lastname">Last Name</label>
                  <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Last Name" value="{{old('lastname')}}">
                </div>
                
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">              
              <!-- /.form-group -->
                <div class="form-group">
                  <label for="insured_id">Address</label>
                  <input name="address" type="text" class="form-control" id="address" placeholder="Address"
                  value="{{old('address')}}" >
                </div>
                <div class="form-group">
                  <label for="contact">Contact</label>
                  <input name="contact" type="text" class="form-control" id="contact" placeholder="Contact" value="{{old('contact')}}" >
                </div>
                <div class="form-group">
                  <label >Pin </label>
                  <input name="pin" type="text" class="form-control"  placeholder="Pin" value="{{old('pin')}}">
                </div>
                <div class="form-group">
                  @include('layouts.error')
                </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection()