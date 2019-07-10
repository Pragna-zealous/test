@extends('layouts.app_front')

@section('content')
    <section class="thankYou-main">
        <div class="container">
            <div class="full-width">

                <div class="thanks-box">
                    <div class="share-btn">
                        <span><i class="fa fa-share-alt" ></i>share</span>
                        <div class="share-icon">
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="thanks-title">
                        Thank you
                        <b>Garvit Maini</b>
                    </div>
                    <div class="clr"></div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt Lorem ipsum
                        a dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="thanks-tag"><span>#WeCan</span></div>
                    <div class="thanks-footer">
                        <div class="thnaks-sign">
                            <img src="images/sign-img.png">
                            <b>Garvit Maini</b> Founder We/Can

                        </div>
                        <div class="thnaks-wecan pull-right">
                            <img src="images/wecan-logo.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- thank you bottom -->
    <section class="thanks-bottom">
        <div class="container">
            <div class="thanks-row">
                <div class="thanks-col">Reference no : 1234546790</div>
                <div class="thanks-col">Donated Amout : $1030</div>
                <div class="thanks-col"><a href="#">Download your Tax Certificate</a></div>
            </div>
        </div>
    </section>
@endsection