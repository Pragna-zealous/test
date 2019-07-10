<?php
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $res = json_decode(file_get_contents('https://www.iplocate.io/api/lookup/'.$ipaddress));
    if(Session::has('header_currency')){
        if (Session::get('header_currency') == 1) {
            $currency = 1;
        }else{
            $currency = 0;
        }
    }else{
        if($res->country_code=='IN' || empty($res->country_code)){
            $currency = 0;
        } else { 
            $currency = 1;
        } 
    }
?>
<input type="hidden" id="header_currency" value="{{$currency}}">
<!-- <a href="{{ url('/change_currency/'.$currency) }}" id="change_currency" style="display: none;" >change currency</a> -->
@if(Request::is('donation'))
<!-- header start-->
<header class="home-header">
    <div class="header-container">
        <div class="donation-logo">
            <a href="{{ url('/') }}"><img src="images/logo-main.png" title="" alt="" /></a>
        </div>
        <div class="price-switch">
            <i>&#x20B9</i>
            <label class="switch">
                <input type="checkbox" id="currency_manager" 
                <?php 
                    if ($currency == 1) {
                        echo 'checked'; 
                    }
                ?>
                >
                <span class="slider round"></span>
            </label>
            <i>&#36</i>
        </div>
        <div class="clr"></div>
    </div>
</header>

@elseif(Request::is('/'))

<header class="home-header">
    <div class="header-container">
        <div class="donation-logo">
            <a href="index.html">
                <img src="images/logo-main.png" title="" alt="" />
            </a>
        </div>
        <div class="price-switch">
            <i>&#x20B9</i>
            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider round"></span>
            </label>
            <i>&#36</i>
        </div>
        <ul class="nav-menu">
            <li><a href="{{ url('about_us') }}">About Us</a></li>
            @auth
                <li><a href="{{route('profile')}}" class="{{ Request::is('profile') ? 'active' : '' }}">My Profile</a></li>
                <li><a href="{{route('dashboard')}}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li>
                    <a class="btn btn-primary dropdown-item cursor" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="modal" data-target="#logoutModal">Sign Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                </li>
            @endauth
            @guest
                <li><a href="javascript:void(0)" class="signin-popup">Signin</a></li>
            @endguest
            <!-- <li><a href="{{route('profile')}}" class="{{ Request::is('profile') ? 'active' : '' }}">My Profile</a></li>
            <li><a href="javascript:void(0)" class="signin-popup">Signin</a></li> -->

            <li><a href="{{ url('donation') }}" class="donation-nav {{ Request::is('donation') ? 'active' : '' }}">Donate</a></li>
        </ul>
        <div class="clr"></div>
    </div>
</header>

@else

<header class="header-main">
    <div class="container">
        <div class="logo-main">
            <a href="{{ url('/') }}"><img src="{{ asset('images/main-logo.png') }}"></a>
        </div>
        <div class="price-switch">
            <i>₹</i>
            <label class="switch">
                <input type="checkbox" id="currency_manager" 
                <?php 
                    if ($currency == 1) {
                        echo 'checked'; 
                    }
                ?>
                >
                <span class="slider round"></span>
            </label>
            <i>$</i>
        </div>
        <ul class="nav-menu">
            <li><a href="{{ url('about_us') }}">About Us</a></li>
            @auth
                <li><a href="{{route('profile')}}" class="{{ Request::is('profile') ? 'active' : '' }}">My Profile</a></li>
                <li><a href="{{route('dashboard')}}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li>
                    <!-- <a class="btn btn-primary dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="modal" data-target="#logoutModal">Sign Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form> -->
                </li>
            @endauth
            @guest
                <li><a href="javascript:void(0)" class="signin-popup">Signin</a></li>
            @endguest
            <li><a href="{{ url('donation') }}" class="{{ Request::is('donation') ? 'active' : '' }}">Donate</a></li>
        </ul>
        <div class="clr"></div>
    </div>
</header>
@endif
<!-- header end-->