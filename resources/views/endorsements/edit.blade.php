@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        {{$endorsement->policy->policy_no}} 
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
    
      <!-- /.row --> 
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              Endorsements Details     
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <form action="{{route('endorsements.update',['endorsement'=>$endorsement->id])}}" method="POST">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 
                  <!-- /.form-group -->
                  <div class="form-group">
                      <label>Type</label>
                      <select  class="form-control" name="type" id="type" required>
                        <option>Base Premium</option>
                        <option>Positive endorsement</option>
                        <option>Fees</option>
                        <option>Taxes</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="policy-id">Amount(Kshs)</label>
                      <input class="form-control" name="amount" id="endorsement-amount" value="{{$endorsement->amount}}" required>
                    </div>
                    <div class="form-group">
                      <label for="policy-id">Description</label>
                      <input class="form-control" name="description" value="{{$endorsement->description}}" required>
                    </div>
                    
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">              
                  <!-- /.form-group -->
                    <div class="form-group">
                        <label for="commission-percent">Commission Percentage</label>
                        <input class="form-control" name="commission-percent" id="commission-percent" placeholder="%">
                      </div>
                      <div class="form-group">
                        <label for="commission-amount">Commission Amount(Kshs)</label>
                        <input class="form-control" id="commission-amount" name="commission-amount" >
                      </div>
                  <!-- /.form-group -->
                </div>

                <!-- /.col -->
              </div>
              <row>
                @include('layouts.error')
              </row>
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