<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Website Icon -->
        <link rel="icon" href="{{asset('image/logo.png')}}" type="image/png">

        {{-- ADMIN LTE --}}
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">

        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

        <!-- JQVMap -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">

        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
        
        <!-- Sweetalert style -->
        <link rel="stylesheet" href="{{asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">

        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">

        <!-- fullcalendar -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/fullcalendar/main.css') }}">

        <!-- Toastr -->
        <link rel="stylesheet" href="{{asset('adminlte/plugins/toastr/toastr.min.css')}}">

        <!-- Select2 -->
        <link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

        <!-- library or Plugins -->
        <!-- Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/sc-2.1.1/datatables.min.css" rel="stylesheet"/>

        <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/af-2.5.3/b-2.3.6/b-colvis-2.3.6/fc-4.2.2/fh-3.3.2/kt-2.9.0/r-2.4.1/sc-2.1.1/datatables.min.js"></script>
        
        {{--css for page --}}
        <link rel="stylesheet" href="{{asset('css/app.css')}}" />
        <link rel="stylesheet" href="{{asset('css/Admin.css')}}" />
    </head>

    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
        <div class="wrapper">
            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
              <img class="animation__shake" src="{{asset('image/mis.png')}}" alt="mis" height="80" width="80">
            </div>

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light elevation-3">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars fa-lg"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Navbar Search -->
                    <li class="nav-item">
                        <!-- SEARCH FORM -->
                        <form class="form-inline ml-0 ml-md-3 mr-3" id="navSearchTicketForm" method="POST">
                            <div class="input-group input-group-lg">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" name="navsearchticket" id="navSearchTicket">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </li>

                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown">
                            <i class="far fa-bell fa-lg"></i>
                            <span class="badge badge-warning navbar-badge">5</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">Notifications</span>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="{{!empty(Auth::user()->Profile) ?  "data:image/jpeg;base64," . base64_encode(Auth::user()->Profile) : asset('image/profile.png')}}" class="user-image img-circle elevation-1 m-auto navProfile" alt="User Image">
                        </a>
                    
                        <ul class="dropdown-menu dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="">Manage Account</a>
                            <a class="dropdown-item" href="" id="logout">Logout</a>
                        </ul>
                    </li> 
                </ul>
            </nav>
            <!-- /.navbar -->

            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{route('admin.index')}}" class="d-flex justify-content-center align-items-center m-3 sidebar-logo">
                  <img src="{{asset('image/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3">
                  <span class="brand-text font-weight-bold d-none sidebar-logo-title">{{ config('app.name', 'Laravel') }}</span>
                </a>
  
                <!-- Sidebar -->
                @include('Layouts.AdminSidebar')
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                    <div class="row">
                        <h1 class="m-0 font-weight-bold p-2 text-dark tabTitle">TICKET BOARD</h1>
                    </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <section class="content">
                    @include('Components.Admin.TicketBoard')
                </section>
            </div>
        </div>
    </body>

    {{-- script for adminlte --}}
     <!-- Bootstrap 4 -->
     <script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

     <!-- daterangepicker -->
     <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
     <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>

     <!-- Tempusdominus Bootstrap 4 -->
     <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

     <!-- Summernote -->
     <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>

     <!-- overlayScrollbars -->
     <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

     <!-- AdminLTE App -->
     <script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
     <script src="{{asset('adminlte/dist/js/demo.js') }}"></script>
     <script src="{{asset('adminlte/plugins/fullcalendar/main.js') }}"></script>
    <!-- Select2 -->
    <script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>

     <!-- SweetAlert App -->
     <script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
     <!-- Toastr -->
     <script src="{{asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>
     <script>
     $.widget.bridge('uibutton', $.ui.button)
     </script>

    {{--script for Loading plugin --}}
    <script>
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        $.LoadingOverlaySetup({
          background: "rgba(255, 255, 255, 0.3)",
          fontawesome : "fa fa-spinner fa-spin",
          fontawesomeColor: "#343a40",
          image: "",
        });
  
        $(document).ajaxStart(function(){
            $.LoadingOverlay("show");
        });
        
        $(document).ajaxStop(function(){
            $.LoadingOverlay("hide");
        });

        var routeTicketBoard = "{{route('admin.ticketboard')}}";
    </script>
    
    {{--script for page --}}
    <script src="{{asset('js/Public.js')}}"></script>
    <script src="{{asset('js/Sidebar.js')}}"></script>
    <script src="{{asset('js/AdminSidebar.js')}}"></script>
</html>