<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('css/fontawesome-free/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <!-- Page level plugin CSS-->
    <!-- <link href="{{ asset('css/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet"> -->

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
    
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- 
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

</head>
<body id="page-top">
    @include('layouts.header')
    <div id="wrapper">
        @auth
            @include('layouts.sidebar')
        @endauth

        <div id="content-wrapper">
            <div class="container-fluid">
                <div id="content">
                    @yield('content')
                </div>
            </div>
        </div>
      
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script>
        var SITEURL = '{{URL::to('')}}';
    </script>
    
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        /*$(document).ready(function() {
            $(".droppable").sortable();
        });*/
    </script>

    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>


    <!-- <script src="{{ asset('js/jquery/jquery.min.js') }}"></script> -->
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('js/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('js/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}" defer></script>
   
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
    <script src="{{ asset('js/function.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    @include('layouts.footer')
</body>

</html>
    

       

      