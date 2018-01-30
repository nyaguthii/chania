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
          @if(auth()->user()->hasRole('ADMIN'))
          <a href="{{route('tyres.dashboard')}}">
          @elseif(auth()->user()->hasRole('INSURANCE'))
          <a href="/home">
          @elseif(auth()->user()->hasRole('CASHIER'))
          <a href="{{route('cashiers.dashboard')}}">
          @else(auth()->user()->hasRole(''))
          <a href="{{route('tyres.dashboard')}}">
          @endif
            <i class="fa fa-th"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        @if(auth()->user()->hasRole('ADMIN') || auth()->user()->hasRole('CASHIER') )
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Cashier</span>
            <span class="pull-right-container">
              <i class=" pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('cashiers.index')}}"><i class="fa fa-circle-o"></i>Vehicles</a></li>
            <li><a href="{{route('cashiers.members')}}"><i class="fa fa-circle-o"></i>Members</a></li>
            <li><a href="{{route('cashiers.nonmembers')}}"><i class="fa fa-circle-o"></i>Non Members</a></li>
            <li><a href="{{route('payments.index')}}"><i class="fa fa-circle-o"></i>Payments</a></li>
          </ul>
        </li>
        @endif
        @if(auth()->user()->hasRole('ADMIN') || auth()->user()->hasRole('TYRE') )
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Tyre Shop</span>
            <span class="pull-right-container">
              <i class=" pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('products.index')}}"><i class="fa fa-circle-o"></i>Products</a></li>
            <li><a href="{{route('inout.index')}}"><i class="fa fa-circle-o"></i>Material Transactions</a></li>
            <li><a href="{{route('orders.index')}}"><i class="fa fa-circle-o"></i>Orders</a></li>
            <li><a href="{{route('daily.sales.tyres')}}"><i class="fa fa-circle-o"></i>Daily Sales</a></li>
            <li><a href="{{route('daily.payments.tyres')}}"><i class="fa fa-circle-o"></i>Daily Payments</a></li>
            <li><a href="{{route('tyres.difference')}}"><i class="fa fa-circle-o"></i>Customer Balance</a></li>
            <li><a href="{{route('customers.tyres.index')}}"><i class="fa fa-circle-o"></i>Customers</a></li>
          </ul>
        </li>
        @endif
        @if(auth()->user()->hasRole('ADMIN') || auth()->user()->hasRole('SACCO') )
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-database"></i>
            <span>SACCO</span>
            <span class="pull-right-container">
              <i class=" pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('sacco.payments.index')}}"><i class="fa fa-circle-o"></i>Payments</a></li>
            <li><a href="{{route('sacco.customers')}}"><i class="fa fa-circle-o"></i>Customers</a></li>
    
          </ul>
        </li>
        @endif
        @if(auth()->user()->hasRole('ADMIN') || auth()->user()->hasRole('INSURANCE') )
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-university"></i>
            <span>INSURANCE</span>
            <span class="pull-right-container">
              <i class=" pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('insurancemembers.index')}}"><i class="fa fa-circle-o"></i>Members</a></li>
            <li><a href="{{route('insurancenonmembers.index')}}"><i class="fa fa-circle-o"></i>Non Members</a></li>
            <li><a href="{{route('paymentSchedules.due.form')}}"><i class="fa fa-circle-o"></i>Due Payments</a></li>
            <li><a href="{{route('customers.overpayments')}}"><i class="fa fa-circle-o"></i>Over Payments</a></li>
            <li><a href="{{route('customers.underpayments')}}"><i class="fa fa-circle-o"></i>Under Payments</a></li>
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
             <li><a href="{{route('policies.active.ajax')}}"><i class="fa fa-circle-o"></i>Active</a></li>
             <li><a href="{{route('policies.cancelled.ajax')}}"><i class="fa fa-circle-o"></i>Cancelled</a></li>
             <li><a href="{{route('policies.suspended.ajax')}}"><i class="fa fa-circle-o"></i>Suspended</a></li>
             <li><a href="{{route('policies.expired.ajax')}}"><i class="fa fa-circle-o"></i>Expired</a></li>
          </ul>
        </li>
        <li>
          <a href="{{route('insurance.vehicles')}}">
            <i class="fa fa-car"></i> <span>Vehicles</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
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
          <a href="{{route('refunds.indexajax')}}">
            <i class="fa fa-th"></i> <span>Refunds</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('suspensions.indexajax')}}">
            <i class="fa fa-th"></i> <span>Suspensions</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li>
          <a href="{{route('cancellations.indexajax')}}">
            <i class="fa fa-th"></i> <span>Cancellations</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-building"></i>
            <span>Claims</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('claims.ajax.index')}}"><i class="fa fa-circle-o"></i>claims</a></li>
             
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('excess.ajax.index')}}"><i class="fa fa-circle-o"></i>Excess</a></li>
             
          </ul>
        </li>
        <li>
          <a href="{{route('carriers.index')}}">
            <i class="fa fa-th"></i> <span>Carriers</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">all</small>
            </span>
          </a>
        </li>
        @endif
        @if(auth()->user()->hasRole('ADMIN') )
        <li class="treeview active">
          <a href="#">
            <i class="fa fa fa-users "></i>
            <span>Customers</span>
            <span class="pull-right-container">
              <i class=" pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('members.index')}}"><i class="fa fa-circle-o"></i>Members</a></li>
            <li><a href="{{route('nonmembers.index')}}"><i class="fa fa-circle-o"></i>NoN Members</a></li>
          </ul>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-building"></i>
            <span>Commissions</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('commissions.monthly')}}"><i class="fa fa-circle-o"></i>Monthly</a></li>
             
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('commissions.yearly')}}"><i class="fa fa-circle-o"></i>Yearly</a></li>
             
          </ul>
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
            <li><a href="{{route('prepayments.daily.form')}}"><i class="fa fa-circle-o"></i>Daily Collection</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('prepayments.totalperdayajax')}}"><i class="fa fa-circle-o"></i>Payments(Daily)</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('prepayments.totalperdayajax2')}}"><i class="fa fa-circle-o"></i>Payments(Place)</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('prepayments.totalperdayajax3')}}"><i class="fa fa-circle-o"></i>Payments(Daily,Type,Place)</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('prepayments.totalperdayajax4')}}"><i class="fa fa-circle-o"></i>Payments(Daily,Type)</a></li>
          </ul>
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
          <ul class="treeview-menu">
            <li><a href="{{route('roles.index')}}"><i class="fa fa-circle-o"></i>Authorities</a></li>
             
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('paymenttypes.index')}}"><i class="fa fa-circle-o"></i>Payment Types</a></li>
             
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{route('places.index')}}"><i class="fa fa-circle-o"></i>Places</a></li>
             
          </ul>
        </li>
      </ul>
      @endif
    </section>
    <!-- /.sidebar -->
  </aside>