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

    <link href="{{ asset('css/fonts/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick-theme.css') }}" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style type="text/css">
        .pageloader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            /* background: url(../img/ajax-loader.gif) 50% 50% no-repeat rgb(249,249,249); */
            background: url({{ asset('images/ajax-loader.gif') }}) 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
    </style>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    

</head>
<body id="page-top">
    <div class="pageloader" style="display: none;"></div>
    @include('layouts.header_front')
    <div id="wrapper">
        <div id="content">
            <div class="message" style="display: none;">
                @include('errors.alerts')
            </div>
            @yield('content')
        </div>
    </div>
    <!-- Scroll to Top Button-->
   
    
    @include('layouts.footer_front')
</body>
    <script>
        var SITEURL = '{{URL::to('')}}';
    </script>


    <script type="text/javascript" src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
    
    @if(Request::is('donation'))
        <script type="text/javascript" src="{{ asset('js/highcharts.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/exporting.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/export-data.js') }}"></script>
    @endif

    <script type="text/javascript" src="{{ asset('js/jquery-migrate-1.2.1.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('slick/slick.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/custom_front.js') }}"></script>

    @if(Request::is('donation'))
        <script type="text/javascript" src="js/highcharts-custom.js"></script>
    @endif

    <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

</html>