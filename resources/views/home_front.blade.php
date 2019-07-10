@extends('layouts.app_front')

@section('content')
    <div class="home-banner">
        <div class="home-slides">
            <div style="background-image: url('images/banner-main.jpg');">
                <div class="home-banner-container">
                    <div class="home-banner-text">
                        <h2>We pioneer sustainable poverty alleviation solutions In India”</h2>
                        <a href="{{ url('donation') }}" class="donation-button"><i class="fa fa-heart" aria-hidden="true"></i> Donate now</a>
                    </div>
                </div>
            </div>
            <div style="background-image: url('images/banner-main.jpg');">
                <div class="home-banner-container">
                    <div class="home-banner-text">
                        <h2>We pioneer sustainable poverty alleviation solutions In India”</h2>
                        <a href="{{ url('donation') }}" class="donation-button"><i class="fa fa-heart" aria-hidden="true"></i> Donate now</a>
                    </div>
                </div>
            </div>
            <div style="background-image: url('images/banner-main.jpg');">
                <div class="home-banner-container">
                    <div class="home-banner-text">
                        <h2>We pioneer sustainable poverty alleviation solutions In India”</h2>
                        <a href="{{ url('donation') }}" class="donation-button"><i class="fa fa-heart" aria-hidden="true"></i> Donate now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- indians section -->
    <section class="indians-section">
        <div class="container">
            <h2 class="sub-titlenew"><span>1 in 3</span>Indians live in extreme poverty.<br/>With your support & our poverty alleviation programmes
                we can change that.</h2>
        </div>
    </section>

    <!--choose-section  -->
    <section class="choose-section">
        <h2 class="sub-titlenew">Choose who you will help today</h2>
        <div class="choose-section-col">
            <div class="choose-section-box">
                <div class="choose-section-sub" style="background-image: url('images/choose1.png')">

                </div>
                <a href="#">Give girl education with assured job</a>
            </div>
        </div>
        <div class="choose-section-col">
            <div class="choose-section-box">
                <div class="choose-section-sub" style="background-image: url('images/choose2.png')">

                </div>
                <a href="#">Give Jharkhand families livelihoods</a>
            </div>
        </div>
    </section>

    <!-- map section -->
    <section class="map-main">
        <div class="container">
            <h2 class="sub-titlenew">We have impacted 10 Lacs lives already.<br/>Check stories of few of them below</h2>

            <div class="india-map-main">
                <div class="india-map-info">
                    <span><i><img src="images/state-icon.png"></i>Impact location</span>
                    <span><i><img src="images/people-icon.png"></i>Beneficiaries</span>
                </div>
                <div class="india-map-box">
                    <div class="delhi-map">
                        <!-- video box -->
                        <div class="delhi-st-icon state-box">
                            <img src="images/state-icon.png" class="state-icon">
                        </div>
                        <!-- video box end-->
                    </div>

                    <div class="jharkhand-map">
                        <!-- video box -->
                        <div class="jharkhand-st-icon state-box">
                            <img src="images/state-icon.png" class="state-icon">
                        </div>
                        <!-- video box end-->
                        <!-- people box -->
                        <div class="people-icon p-icon1">
                            <img src="images/people-icon.png" class="point-icon">
                            <img src="images/people-icon-active.png" class="active-icon">
                            <div class="people-popup">
                                <img src="images/people-img.png">
                                <h4>Sapna Prajapati</h4>
                                <p>Lorem ipsum dolor sit amet, consec tetur adipiscing elit,sed do eiusmod tempor incididunt
                                    labore et dolore magna aliqua. Quis ipsum suspend is ultrices gravida. Risus commodo
                                    viverra maecenas accumsan lacus vel facilisis adipiscing lacus elit. </p>
                            </div>
                        </div>
                        <!-- people box end-->
                        <!-- people box -->
                        <div class="people-icon p-icon2">
                            <img src="images/people-icon.png" class="point-icon">
                            <img src="images/people-icon-active.png" class="active-icon">
                            <div class="people-popup">
                                <img src="images/people-img.png">
                                <h4>Sapna Prajapati</h4>
                                <p>Lorem ipsum dolor sit amet, consec tetur adipiscing elit,sed do eiusmod tempor incididunt
                                    labore et dolore magna aliqua. Quis ipsum suspend is ultrices gravida. Risus commodo
                                    viverra maecenas accumsan lacus vel facilisis adipiscing lacus elit. </p>
                            </div>
                        </div>
                        <!-- people box end-->
                    </div>

                    <div class="hydrabad-map">
                        <!-- video box -->
                        <div class="hydrabad-st-icon state-box">
                            <img src="images/state-icon.png" class="state-icon">
                        </div>
                        <!-- video box end-->
                    </div>

                    <div class="banglore-map">
                        <!-- video box -->
                        <div class="banglore-st-icon state-box">
                            <img src="images/state-icon.png" class="state-icon">
                            <div class="video-popup">
                                <div class="video-img" style="background-image: url('images/blank-img.png')">
                                    <img src="images/play-icon.png">
                                </div>
                            </div>
                        </div>
                        <!-- video box end-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- we can setting -->
    <section class="we-can-setting">
        <div class="container">
            <h2 class="sub-titlenew">We/can is setting examples on transparency</h2>
            <div class="section-row">
                <div class="section-col3">
                    <div class="we-can-box" style="background-image: url('images/wecan-img1.png')">
                        <div class="we-can-sub">
                            <div class="we-can-box-text">
                                <h3>We provide evidence of our work</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-col3">
                    <div class="we-can-box" style="background-image: url('images/wecan-img2.png')">
                        <div class="we-can-sub">
                            <div class="we-can-box-text">
                                <h3>We share<br/>your impact</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-col3">
                    <div class="we-can-box" style="background-image: url('images/wecan-img3.png')">
                        <div class="we-can-sub">
                            <div class="we-can-box-text">
                                <h3>We are transparent about our finances</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- happy-people -->
    <section class="happy-people">
        <h2>“The happiest people are not those getting more but those who give more”</h2>
    </section>

    <!-- partner logo section -->
    <section class="partner-logo-main">
        <div class="container">
            <h2 class="sub-titlenew">We achieved this huge impact with help from our partners</h2>
            <ul class="partner-logo-box">
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo1.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo2.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo3.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo4.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo1.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo2.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo3.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo4.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo1.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo2.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo3.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo4.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo1.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo2.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo3.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo4.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo1.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo2.png"></span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- regularly-main -->
    <section class="regularly-main">
        <div class="container">
            <h2 class="sub-titlenew">Our programmes are regularly covered in press</h2>
            <ul class="partner-logo-box">
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo1.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo2.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo3.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo4.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo1.png"></span>
                    </div>
                </li>
                <li>
                    <div class="logo-box-main">
                        <span><img src="images/logo2.png"></span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- need help section -->
    <section class="need-help">
        <div class="container">
            <h2 class="sub-titlenew">We are not done yet.<br/>Help us in bringing 1 million Indians sustainably out of poverty.</h2>
            <div class="section-row">
                <div class="section-col4">
                    <div class="help-box">
                        <div class="help-img">

                        </div>
                        <div class="help-text">
                            <p>Giving Rs 2500 tmo people under extream poverty</p>
                            <a href="#">Donate</a>
                        </div>
                    </div>
                </div>
                <div class="section-col4">
                    <div class="help-box fundraise-box">
                        <div class="help-img">

                        </div>
                        <div class="help-text">
                            <p>Giving Rs 2500 tmo people under extream poverty</p>
                            <a href="#">Fundraise</a>
                        </div>
                    </div>
                </div>
                <div class="section-col4">
                    <div class="help-box send-love-box">
                        <div class="help-img">

                        </div>
                        <div class="help-text">
                            <p>Giving Rs 2500 tmo people under extream poverty</p>
                            <a href="#">Send love</a>
                        </div>
                    </div>
                </div>
                <div class="section-col4">
                    <div class="help-box partner-box">
                        <div class="help-img">

                        </div>
                        <div class="help-text">
                            <p>Giving Rs 2500 tmo people under extream poverty</p>
                            <a href="#">partner with us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
       
@endsection