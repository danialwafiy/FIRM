
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" href="{{{ asset('img/icon.png') }}}">
  <link rel="stylesheet" href="/css/app.css">
  
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
</head>
<body>
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light border-bottom" style="background-color:#0a87d7">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" style="color:#303642!important" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>   
    </ul>
    <ul class="navbar-nav ml-auto">  
      <li class="nav-item">
            <a class="nav-link" style="color:#303642!important" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <b>{{ __('Logout') }}</b>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
    </ul> 
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4" style="background-color:#272B34">
    <a href="#" class="brand-link">
      <img src="{{url('/img/logo.png')}}"  class="brand-image img-thumbnail elevation-3">
      <img src="{{url('/img/uthm.png')}}"  class="brand-image img-thumbnail elevation-3">
           <br>
    </a> 

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-4 mb-3 d-flex elevation-3" style="background-color:#303642;color:white">
        <div class="image my-auto">
          <img src="{{url('/img/user.png')}}"  class="image-thumbnail rounded-circle">
        </div>
        <div class="info mx-auto">
          <p class="d-block text-wrap mb-0 text-white" style="font-size:13px">{{ ucwords($user->name) }}</p>
          <h6><span class="badge badge-secondary text-white mx-auto">{{ strtoupper($user->user_id) }}</span></h6>
        </div>
      </div>
      <hr class="pb-2" style="height:12px;border: 0;box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if (Auth::user()->type == '1' || Auth::user()->type == '2' || Auth::user()->type == '3'  )
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-chalkboard"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          @endif  
          @if(Auth::user()->type=='4')
          <li class="nav-item">
                  <router-link to="/student/profile/{{session('studentID')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                    Student Profile
                    </p>
                  </router-link>
          </li>
          @endif          
          @if (Auth::user()->type == '2')
          <li class="nav-item">
                  <router-link to="/lecture/profile/{{session('userID')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                    Profile
                    </p>
                  </router-link>
          </li>
          @endif          
          @if (Auth::user()->type == '3')
          <li class="nav-item">
                  <router-link to="/student/profile/{{session('userID')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                    Profile
                    </p>
                  </router-link>
          </li>
          @endif
          @if (Auth::user()->type == '2')
            <li class="nav-item">
                <router-link to="/student-list" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                  My Students
                  </p>
                </router-link>
            </li>  
          @endif
          @if (Auth::user()->type == '1')
          <li  class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Profile
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/student-list-admin" class="nav-link ml-3">
                <i class="nav-icon fas fa-user-alt"></i>
                <p>
                Student
                </p>
              </router-link>
            </li> 
            <li class="nav-item">
              <router-link to="/lecture-list-admin" class="nav-link ml-3">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>
                Supervisor
                </p>
              </router-link>
            </li>
          </ul>
          </li>
          @if (Auth::user()->type == '1')
              <li class="nav-item">
              <router-link to="/internship" class="nav-link">
                <i class="nav-icon fas fa-project-diagram"></i>
                <p>
                Internship
                </p>
              </router-link>
              </li>
              <li class="nav-item">
              <router-link to="/news" class="nav-link">
                <i class="nav-icon fas fa-newspaper "></i>
                <p>
                News
                </p>
              </router-link>
              </li>
              @endif
          @endif
          @if (Auth::user()->type == '3')
          <li class="nav-item">
              <router-link to="/logbook/{{session('userID')}}" class="nav-link">
                <i class="nav-icon fas fa-book-open "></i>
                <p>
                Logbook
                </p>
              </router-link>
          </li>
          @endif
          @if (Auth::user()->type == '3')
          <li class="nav-item">
              <router-link to="/student/{{session('userID')}}/meeting" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt "></i>
                <p>
                Meeting
                </p>
              </router-link>
          </li>
          @endif
          @if (Auth::user()->type == '2')
          <li class="nav-item">
              <router-link to="/meet-list" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt "></i>
                <p>
                Meeting
                </p>
              </router-link>
          </li>
          @endif
          @if (Auth::user()->type == '1' || Auth::user()->type == '2' || Auth::user()->type == '3'  )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tools "></i>
              <p>
                Settings
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/change-password" class="nav-link">
                  <i class="nav-icon fas fa-unlock-alt"></i>
                  <p>
                  Change Password
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
              <router-view></router-view> <!-- all vue componenets are here --->
              <vue-progress-bar></vue-progress-bar>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper --> 

  <footer class="main-footer">
    <div class="float-center d-none d-sm-inline">
      <strong>Developed by : Danial Wafiy </strong>
    </div>
  </footer>
  
</div><!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<script src="/js/app.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
</body>
</html>
