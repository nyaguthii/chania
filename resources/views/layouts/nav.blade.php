      <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
        @if(Auth::check())
        <p>{{auth()->user()->name}}</p>
        @endif
          
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="{{route('home')}}">
            <i class="fa fa-th"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Customers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('customers.index',['is_member'=>1])}}"><i class="fa fa-circle-o"></i>Members</a></li>
            <li><a href="{{route('customers.index',['is_member'=>0])}}"><i class="fa fa-circle-o"></i>Non Members</a></li>
          </ul>
        </li>
        <li>
          <a href="{{route('vehicles.index')}}">
            <i class="fa fa-th"></i> <span>Vehicles</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('commissions.index')}}">
            <i class="fa fa-th"></i> <span>Commisions</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('payments.daily.form')}}"><i class="fa fa-circle-o"></i>Daily Collection</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('paymentSchedules.due.form')}}"><i class="fa fa-circle-o"></i>Due Payments</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('payments.totalperday')}}"><i class="fa fa-circle-o"></i>Payments per day</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('vehicles.overpayments')}}"><i class="fa fa-circle-o"></i>Over Payments</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('vehicles.underpayments')}}"><i class="fa fa-circle-o"></i>Under Payments</a></li>
          </ul>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Policies</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('policies.index')}}"><i class="fa fa-circle-o"></i>Active</a></li>
             <li><a href="{{route('policies.status',['status'=>'cancelled'])}}"><i class="fa fa-circle-o"></i>Cancelled</a></li>
             <li><a href="{{route('policies.expired')}}"><i class="fa fa-circle-o"></i>Expired</a></li>
             <li><a href="{{route('policies.status',['status'=>'suspended'])}}"><i class="fa fa-circle-o"></i>Suspended</a></li>
          </ul>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Bank</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('banktransactions.index')}}"><i class="fa fa-circle-o"></i>Transactions</a></li>
          </ul>
        </li>
        <li>
          <a href="{{route('refunds.index')}}">
            <i class="fa fa-th"></i> <span>Refunds</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('suspensions.index')}}">
            <i class="fa fa-th"></i> <span>Suspensions</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('cancellations.index')}}">
            <i class="fa fa-th"></i> <span>Cancellations</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('claims.index')}}">
            <i class="fa fa-th"></i> <span>Claims</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('carriers.index')}}">
            <i class="fa fa-th"></i> <span>Carriers</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
      
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Administration</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('users.index')}}"><i class="fa fa-circle-o"></i>Users</a></li>
             
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>