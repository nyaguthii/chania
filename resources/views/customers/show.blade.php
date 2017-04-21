@extends('layouts.master')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
    @include('layouts.customer-menu')
    <div class="row">
      
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <h3 class="profile-username text-center">{{$customer->firstname}}  {{$customer->lastname}} </h3>

            <p class="text-muted text-center">{{$customer->type}}</p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Address</b> <a class="pull-right">{{$customer->address}}</a>
              </li>
              <li class="list-group-item">
                <b>Contact</b> <a class="pull-right">{{$customer->contact}}</a>
              </li>
               <li class="list-group-item">
                <b>Insured ID</b> <a class="pull-right">{{$customer->insured_id}}</a>
              </li>
               <li class="list-group-item">
                <b>Is Member</b> <a class="pull-right">
                @if($customer->is_member==1)
                 Yes
                @elseif($customer->is_member==0)
                 No
                @endif
                </a>
              </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <!-- /.box -->
      </div>
    </div>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection

  