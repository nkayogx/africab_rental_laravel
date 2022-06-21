<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
  
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
 
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
        @can('view-property')
          <li><a href="{{ Route('properties.index') }}"><i class="fa fa-building"></i><span>Properties</span></a></li>
        @endcan
       
  
        <li><a href="{{ Route('tenants.index') }}"><i class="fa  fa-users"></i><span>Customer</span></a></li>
        <li><a href="{{ Route('leases.index') }}"><i class="fa  fa-gavel"></i><span>Ownership</span></a></li>
        <li><a href="{{ Route('leases.index') }}"><i class="fa  fa-gavel"></i><span>Leases</span></a></li>
        <li><a href="{{ Route('invoices.index') }}"><i class="fa  fa-file-text"></i><span>Invoices</span></a></li>
        <li><a href="{{ Route('payments.index') }}"><i class="fa  fa-money"></i><span>Payments</span></a></li>
        <li><a href="{{ Route('expenses.index') }}"><i class="fa  fa-credit-card"></i><span>Expenses</span></a></li>
        <li><a href="{{ Route('maintenances.index') }}"><i class="fa fa-wrench"></i><span>Maintenance</span></a></li>
    
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> Regions </a></li>
            <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Expense Categories</a></li>
            <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Currency</a></li>
            <li><a href="{{ Route('users.index') }}"><i class="fa fa-users"></i><span>Users</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span> Reports </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> Regions </a></li>
            <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Expense Categories</a></li>
            <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Currency</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
