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

        <link rel="stylesheet" href="{{asset('css/app.css')}}" />
    </head>

    <body>
         @yield('content')
    </body>

    <!-- MDB -->
    <script type="text/javascript" src="{{asset('MDB/js/mdb.min.js')}}"></script>

    {{--script for Loading plugin --}}
    <script>
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
  
        $(document).ajaxStart(function(){
        });
        
        $(document).ajaxStop(function(){
        });
    </script>
    
    {{--script for page --}}
    <script src="{{asset('js/Login.js')}}"></script>
</html>