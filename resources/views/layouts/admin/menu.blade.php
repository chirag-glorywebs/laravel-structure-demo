 <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">

  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger text-white"><i class="fas fa-power-off"></i></a>
      <form id="logout-form" action="/logout" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
    </li>
  </ul>
</nav>

<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/admin" class="brand-link">
    <img src="/admin-panel/img/glory-logo.png" alt="Glory Demo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Glory Demo</span>
  </a>


  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <a href="/admin">
          @if (Auth::user()->profile_picture != "" && file_exists(public_path('/upload/user_image/'.Auth::user()->profile_picture)))
            <img src="/upload/user_image/{{ Auth::user()->profile_picture }}" alt="" width="60" height="60">
          @else
            <img src="/admin-panel/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" alt="" width="60" height="60">
          @endif
        </a>
      </div>
      <div class="info">
        <a href="/admin" class="d-block">
          <span> {{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }} </span>
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">

        @if(isset($usermenu))
          @foreach($usermenu as $key => $menu)
            @if(in_array($key, $menus) || Auth::user()->user_type=="SuperAdmin")
              @php
                $active_link = array();
                foreach($menu['active_link'] as $val){
                  if($val!='admin'){
                    $active_link[] = $val."/*";
                  }else{
                    $active_link[] = $val;
                  }
                }
              @endphp
              <li class="nav-item {{ (isset($menu['sub']) && !(empty($menu['sub']))) ? (((in_array(Request::path(), $menu['active_link'])) || Request::is($active_link)) ? 'has-treeview menu-open' : 'has-treeview') : '' }}">
                <a href="{{ $menu['link']}}" class="nav-link {{ (in_array(Request::path(), $menu['active_link']) || Request::is($active_link)) ? 'active' : '' }}">
                  <i class="fas {{ $menu['icon']}} nav-icon"></i>
                  <p>
                    {{ $menu['value'] }}
                    @if(isset($menu['sub']) && !(empty($menu['sub'])))
                      <i class="fas fa-angle-left right"></i>
                    @endif
                  </p>
                </a>
                @if(isset($menu['sub']) && !(empty($menu['sub'])))
                <ul class="nav nav-treeview">
                    @foreach($menu['sub'] as $submenu)
                      @php
                      $subactive_link = array();
                      foreach($submenu['active_link'] as $subval){
                        if($subval!='admin'){
                          // $subactive_link[] = $subval."/*";
                          $subactive_link[] = $subval."/";
                        }else{
                          $subactive_link[] = $subval;
                        }
                      }
                      @endphp
                      <li class="nav-item">
                        <a href="{{ $submenu['link'] }}" class="nav-link {{ (in_array(Request::path(), $submenu['active_link']) || Request::is($subactive_link)) ? 'active' : '' }}">
                          <i class="far {{ $submenu['icon'] }} nav-icon"></i>
                          <p>{{ $submenu['value'] }}</p>
                        </a>
                      </li>
                    @endforeach
                </ul>
                @endif
              </li>
            @endif
          @endforeach
        @endif


          {{-- @if(Request::path() == 'admin')
          <li class="nav-item">
              <a href="/admin/" class="nav-link active">
          @else
            <li class="nav-item">
              <a href="/admin/" class="nav-link">
          @endif
              <i class="nav-icon fas fa-building nav-icon"></i>
              <p>
               Dashboard
              </p>
            </a>
          </li>


          @if(Request::path() == 'admin/user' || Request::path() == 'admin/user/create' || Request::is('admin/user/*/edit') || Request::path() == 'admin/user/deal-report')
          <li class="nav-item has-treeview menu-open">
              <a href="/admin/user" class="nav-link active">
          @else
            <li class="nav-item has-treeview">
              <a href="/admin/user" class="nav-link">
          @endif
              <i class="nav-icon fas fa-users nav-icon"></i>
              <p>
               User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding:0;">
                <li class="nav-item">
                  <a href="/admin/user" class="nav-link {{(Request::path() == 'admin/user'||Request::path() == 'admin') ? 'active' : '' }}">
                    <i class="far fa-list-alt nav-icon"></i>
                    <p>User List</p>
                  </a>
                </li>
            </ul>
            <ul class="nav nav-treeview" style="padding:0;">
              <li class="nav-item">
                <a href="/admin/user/create" class="nav-link {{(Request::path() == 'admin/user/create' || Request::is('admin/user/*/edit')) ? 'active' : '' }}">
                  <i class="fa fa-plus nav-icon"></i>
                  <p>User Add</p>
                </a>
              </li>
            </ul>
          </li>


          @if(Request::path() == 'admin/project' || Request::path() == 'admin/project/create' || Request::is('admin/project/*/edit') || Request::path() == 'admin/project/deal-report')
          <li class="nav-item has-treeview menu-open">
              <a href="/admin/project" class="nav-link active">
          @else
            <li class="nav-item has-treeview">
              <a href="/admin/project" class="nav-link">
          @endif
              <i class="nav-icon fas fa-building nav-icon"></i>
              <p>
               Project Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding:0;">
                <li class="nav-item">
                  <a href="/admin/project" class="nav-link {{(Request::path() == 'admin/project'||Request::path() == 'admin') ? 'active' : '' }}">
                    <i class="far fa-list-alt nav-icon"></i>
                    <p>Project List</p>
                  </a>
                </li>
            </ul>
            <ul class="nav nav-treeview" style="padding:0;">
                <li class="nav-item">
                  <a href="/admin/project/create" class="nav-link {{(Request::path() == 'admin/project/create' || Request::is('admin/project/*/edit')) ? 'active' : '' }}">
                    <i class="fa fa-plus nav-icon"></i>
                    <p>Project Add</p>
                  </a>
                </li>
            </ul>
          </li>


          @if(Request::path() == 'admin/weekly-logs/weekly-logs-list' || Request::path() == 'admin/weekly-logs/weekly-logs-add' ||  Request::is('admin/weekly-logs/weekly-logs-add*'))
            <li class="nav-item has-treeview menu-open">
              <a href="/admin/weekly-logs/weekly-logs-list" class="nav-link active">
          @elseif(Request::path() == 'admin/weekly-logs/weekly-date-logs-list')
            <li class="nav-item has-treeview menu-open">
              <a href="/admin/weekly-logs/weekly-date-logs-list" class="nav-link active">
          @else
            <li class="nav-item has-treeview ">
              <a href="/admin/weekly-logs/weekly-date-logs-list" class="nav-link">
          @endif
              <i class="nav-icon fas fa-calendar-week nav-icon"></i>
              <p>
               Weekly Planning
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/admin/weekly-logs/weekly-logs-list" class="nav-link {{ (Request::path() == 'admin/weekly-logs/weekly-logs-list' || Request::path() == 'admin/weekly-logs/weekly-logs-add' || Request::is('admin/weekly-logs/weekly-logs-add*')) ? 'active' : '' }}">
                    <i class="far fa-list-alt nav-icon"></i>
                    <p>Weekly Planning List</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/weekly-logs/weekly-date-logs-list" class="nav-link {{ (Request::path() == 'admin/weekly-logs/weekly-date-logs-list') ? 'active' : '' }}">
                    <i class="far fa-list-alt nav-icon"></i>
                    <p>Weekly Date List</p>
                  </a>
                </li>
            </ul>
          </li>
          <li class="nav-item has-treeview ">
              <a href="/admin/task-trac/task-trac-list" class="nav-link">
                <i class="far fa-user nav-icon"></i>
                <p>Task Trac List<i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/admin/task-trac/task-trac-list" class="nav-link {{ (Request::path() == 'admin/weekly-logs/weekly-logs-list' || Request::path() == 'admin/weekly-logs/weekly-logs-add' || Request::is('admin/weekly-logs/weekly-logs-add*')) ? 'active' : '' }}">
                    <i class="far fa-user nav-icon"></i>
                    <p>Task Trac List</p>
                  </a>
                </li>
              </ul>
          </li> --}}

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
