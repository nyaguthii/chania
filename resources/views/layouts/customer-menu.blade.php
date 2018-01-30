  <div class="row">       
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-car"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><a href="{{route('customers.vehicles.index',['customer'=>$customer->id])}}">Vehicles</a></span>
              <span class="info-box-number">{{count($customer->vehicles)}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
             
              <span class="info-box-text"><a href="/customers/{{$customer->id}}/policies">Policies</a></span>
              <span class="info-box-number">{{count($customer->policies)}}<small></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="ion ion-cash"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><a href="#">Payments</a></span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-card"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><a href="{{route('credits.index',['customer'=>$customer->id])}}">Credits</a></span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
  </div>