<!-- footer section -->
<!-- <footer class="footer-main">
    <div class="footer-top">
        <div class="container">
            <div class="footer-left">
                <h2>We/Can Foundation</h2>
                <p>C9, 1st C Main Road, MCHS Colony, Sector 6, HSR Layout, Bengaluru, Karnataka - 560102 India</p>
                {!! Form::open(array('url' => '/footer_signup')) !!}
                    <div class="footer-signup">
                        <input type="email" class="input-box email" placeholder="Email address" name="email">
                        <input type="hidden" value="9876543210" class="input-box phone_number" name="phone_number">
                        <input type="hidden" value="temp" class="input-box name" name="name">
                        <input type="hidden" value="footer" class="input-box signup_from" name="signup_from">
                        <input type="submit" value="Signup" class="footer-signup-btn">
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="footer-right">
                <div class="footer-social">
                    <a href="#"><i class="fa fa-linkedin"></i></a>
                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                </div>
                <div class="clr"></div>
                <ul class="footer-nav">
                    <li><a href="{{ url('custompage_load/faq') }}">Faq</a></li>
                    <li><a href="{{ url('custompage_load/privacy-policy') }}">Privacy policy</a></li>
                    <li><a href="{{ url('custompage_load/terms-&-conditions') }}">Terms & Conditions</a></li>
                    <li><a href="{{ url('custompage_load/cancellation-policy') }}">Cancellation Policy</a></li>
                </ul>
                <div class="clr"></div>
                <div class="footer-msg">
                    <a href="" class="mail-msg"><i class="fa fa-envelope"></i>wecan@thenudge.com</a>
                    <a href="" class="whatsapp-msg"><i class="whatsapp-icon"><img src="{{ asset('images/whatsapp-icon.png') }}"></i>Send Whatsapp Message</a>
                </div>
            </div>

        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            copyright@2019
        </div>
    </div>
</footer> -->
 <!-- footer section -->
    <footer class="footer-main">
        <div class="footer-top">
            <div class="container">
                <div class="footer-left">
                    <img src="images/we-can-footer.png">
                    <p>C9, 1st C Main Road, MCHS Colony, Sector 6, HSR Layout, Bengaluru, Karnataka - 560102 India</p>
                </div>
                <div class="footer-right">
                    <div class="footer-social">
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                    </div>
                    <div class="clr"></div>
                    <ul class="footer-nav">
                        <li><a href="{{ url('custompage_load/faq') }}">Faq</a></li>
                        <li><a href="{{ url('custompage_load/privacy-policy') }}">Privacy policy</a></li>
                        <li><a href="{{ url('custompage_load/terms-&-conditions') }}">Terms & Conditions</a></li>
                        <li><a href="{{ url('custompage_load/cancellation-policy') }}">Cancellation Policy</a></li>
                    </ul>

                </div>

                <div class="footer-b">
                    <div class="footer-b-col footer-form">
                        <div class="full-width">

                            {!! Form::open(array('url' => '/footer_signup')) !!}
                                <div class="footer-signup">

                                    <div class="footer-signup-col">
                                        <input type="text" value="" name="name" class="input-box" placeholder="Name">
                                    </div>
                                    <div class="footer-signup-col">
                                        <input type="email" value="" class="email input-box" placeholder="Email address" name="email">
                                    </div>

                                    <input type="submit" value="Signup" class="footer-signup-btn">
                                </div>
                            {!! Form::close() !!}

                            <!-- <div class="footer-signup">
                                <div class="footer-signup-col">
                                    <input type="email" value="" class="input-box" placeholder="Email address">
                                </div>
                                <div class="footer-signup-col">
                                    <input type="email" value="" class="input-box" placeholder="Email address">
                                </div>
                                <input type="submit" value="Signup" class="footer-signup-btn">
                            </div> -->
                        </div>
                    </div>
                    <div class="footer-b-col footer-msg-new">
                        <a href="" class="mail-msg"><i class="fa fa-envelope"></i>wecan@thenudge.com</a>
                    </div>
                    <div class="footer-b-col footer-msg-new">
                        <a href="https://web.whatsapp.com/send?phone=" class="whatsapp-msg" target="blank"><i class="whatsapp-icon"><img src="images/whatsapp-icon.png"></i>Send Whatsapp Message</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                copyright@2019
            </div>
        </div>
    </footer>
<!-- Login Popup -->
<div class="form-popup-main" id="form-popup-main" style="display: none;" >
    <div class="form-popup-head">Sign In <i class="fa fa-times-circle"></i></div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-popup-box">
            <div class="form-field-box">
                <input id="email" type="email" class="input-field form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email address" autofocus>

                @error('email')
                <script type="text/javascript">
                    document.getElementById("form-popup-main").showModal();

                </script>
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-field-box passowrd-field">
                <input id="password" type="password" class="input-field form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                @error('password')
                <script type="text/javascript">
                    document.getElementById("form-popup-main").showModal();

                </script>
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <i class="fa fa-eye-slash"></i>
            </div>
            <div class="forget-link">
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif

            </div>
            <input type="submit" class="defult-btn full-width" value="Sign In">
            <div class="form-popup-social">

                <a href="{{ url('/login/google') }}" class="btn btn-google" class="btn btn-google"><i class="fa fa-google" aria-hidden="true"></i> Google</a>

                <a href="{{ url('/login/facebook') }}" class="btn btn-facebook" class="btn btn-facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>

            </div>
        </div>
    </form>
</div>
<div class="form-popup-bg" id="form-popup-bg" style="display: none;"></div>


<div class="form-popup-main" id="alert-popup-main" style="display: none;" >
    <div class="form-popup-head" id="alert-popup-head">Messages<i class="fa fa-times-circle"></i></div>
    <form method="POST" action="{{ route('login') }}">
        @csrf        
        <div class="form-popup-box" id="alert-popup-box">
        </div>
    </form>
</div>

<div class="form-popup-bg" id="alert-popup-bg" style="display: none;"></div>