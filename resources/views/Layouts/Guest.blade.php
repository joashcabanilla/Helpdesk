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

        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
        
        <!-- Sweetalert style -->
        <link rel="stylesheet" href="{{asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

        <!-- Toastr -->
        <link rel="stylesheet" href="{{asset('adminlte/plugins/toastr/toastr.min.css')}}">

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
    </head>

    <body>
        <div class="wrapper">
            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
              <img class="animation__shake" src="{{asset('image/mis.png')}}" alt="mis" height="80" width="80">
            </div>
            <div class="hold-transition login-page">
                @yield('content')
            </div>
          </div>
    </body>

    {{-- script for adminlte --}}
     <!-- Bootstrap 4 -->
     <script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
     <!-- AdminLTE App -->
     <script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
     <!-- SweetAlert App -->
     <script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
     <!-- Toastr -->
     <script src="{{asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>
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
    </script>
    
    {{--script for page --}}
    <script src="{{asset('js/Public.js')}}"></script>
    <script src="{{asset('js/Login.js')}}"></script>
    <script type="module" src="{{asset('js/FirebaseAuth.js')}}"></script>
</html>