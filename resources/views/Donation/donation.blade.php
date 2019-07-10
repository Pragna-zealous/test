@extends('layouts.app_front')

@section('content')
    <?php
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $res = json_decode(file_get_contents('https://www.iplocate.io/api/lookup/'.$ipaddress));
    
    if(Session::has('header_currency')){
        if (Session::get('header_currency') == 1) {
            $payment_type = 'stripe';
            $currency = 'USD';
            $currencyicon = '$';
            $customer_id = (Auth::user() ? Auth::user()->stripe_customer_id : '' );
        }else{
            $payment_type = 'razorpay';
            $currency = 'INR';
            $currencyicon = '₹';
            $customer_id = (Auth::user() ? Auth::user()->razorpay_customer_id : '' );
        }
    }else{
        if($res->country_code=='IN' || empty($res->country_code)){
            $payment_type = 'razorpay';
            $currency = 'INR';
            $currencyicon = '₹';
            $customer_id = (Auth::user() ? Auth::user()->razorpay_customer_id : '' );
        } else { 
            $payment_type = 'stripe';
            $currency = 'USD';
            $currencyicon = '$';
            $customer_id = (Auth::user() ? Auth::user()->stripe_customer_id : '' );
        } 
    }
    ?>
        <div class="donation-banner">
            <div class="banner-container">
                <!-- banner form -->
                <div class="banner-form">
                    {!! Form::open(array('url' => '/dopayment', 'class' => "form-horizontal razorpay_form")) !!}
                        <input type="hidden" id="loggedin_user" value="{{(Auth::user() ? Auth::user()->id : '')}}">
                        <input type="hidden" id="customer_id" value="{{$customer_id}}">
                        <input type="hidden" id="payment_type" value="{{ $payment_type }}" />
                        <input type="hidden" id="currency" value="{{ $currency }}" />
                        @if(Session::has('flash_pay_error'))
                            <p class="error">{!! nl2br(Session::get('flash_pay_error')) !!}</p>
                        @endif
                        <div class="banner-form-title">
                            “I would <b>like to contribute</b> for people like chaiya majhi” 
                        </div>
                        <div class="donation-tab">
                            <div class="donation-tab-top">
                                <input type="hidden" id="subscription_type" value="once">
                                <a class="active give_donation cursor" give="once">Give Once</a>
                                <a class="give_donation cursor" give="monthly">Give Monthly</a>
                            </div>
                            <div class="donation-price-tag">
                                <input type="hidden" id="order_id" value="{{ (($orderdata) ? $orderdata->order_id : '') }}">
                                <a class="js-pay-bundle active js-pay-bundle_amount cursor selected_amount" data-currency= "{{ $currency }}" data-itemid="donate1000" data-amount="100000" data-ramount="1000" data-processorid="razor" data-qty="1" data-brand="WeCan"data-description="Credit 1000 coins"data-themecolor="#B9A76E" data-img="{{ asset('images/razorpaylogo.png') }}">{{$currencyicon}} 1000</a>

                                <a class="js-pay-bundle js-pay-bundle_amount cursor" data-currency= "{{ $currency }}"  data-itemid="donate500" data-amount="50000" data-ramount="500" data-processorid="razor" data-qty="1" data-brand="WeCan"data-description="Credit 500 coins"data-themecolor="#B9A76E" data-img="{{ asset('images/razorpaylogo.png') }}">{{$currencyicon}} 500</a>

                                <a class="js-pay-bundle js-pay-bundle_amount cursor" data-currency= "{{ $currency }}"  data-itemid="donate250" data-amount="25000" data-ramount="250" data-processorid="razor" data-qty="1" data-brand="WeCan"data-description="Credit 250 coins"data-themecolor="#B9A76E" data-img="{{ asset('images/razorpaylogo.png') }}">{{$currencyicon}} 250</a>
                               
                            </div>
                            
                        </div>
                        <div class="donation-check">
                            <div class="checkbox">
                                <input id="check3" type="checkbox" name="check" value="check3">
                                <label for="check3">You will be charge 3% as transaction fees</label>
                            </div>
                        </div>
                        <button type="button" class="donation-btn" id="donation-btn"><i class="fa fa-heart" aria-hidden="true"></i>Donate</button>
                        <button style="display: none;" type="button" id="make_payment"><i class="fa fa-heart" aria-hidden="true"></i>Donate</button>
                       <!--  <input 
                            id="get_profile_submit"
                            type="submit" 
                            value="stripe"
                            data-key="pk_test_5B5loe91O0AsFmXh6zgniWwF000QFzbmuk"
                            data-amount="1000"
                            data-currency="USD"
                            data-name="WeCan"
                            data-description="Stripe payment for donation"
                            class="get-started"
                        /> -->
                    </form>
                    <div class="signup_form" style="display: none;">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control input-field name" name="name" value="{{(Auth::user() ? Auth::user()->name : '')}}" required autocomplete="name" placeholder="{{ __('Name') }}*" style="margin-bottom: 10px;" autofocus >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="email" class="form-control input-field email" name="email" value="{{(Auth::user() ? Auth::user()->email : '')}}" placeholder="{{ __('E-Mail Address') }}*" required autocomplete="email" style="margin-bottom: 10px;">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control input-field country_code" name="country_code" value="{{(Auth::user() ? Auth::user()->country_code : '')}}" required placeholder="Country Code*" style="margin-bottom: 10px;">
                                        <input type="phone_number" class="form-control input-field phone_number" name="phone_number" value="{{(Auth::user() ? Auth::user()->phone_number : '')}}" required autocomplete="phone_number" placeholder="Phone Number*" style="margin-bottom: 10px;">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-10" style="margin-bottom: 10px;">
                                        <input id="notification" type="checkbox" value=1 class="notification" name="notification" ><span> I want to subscribe email and whatsapp to get latest updates from We/Can</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-10" style="margin-bottom: 10px;">
                                        <input type="hidden" value="donation" class="donation" name="donation" >
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <a class="defult-btn pull-right register_user"> Make Payment </a>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
            <!-- <div class="donation-banner-tag">
                <span>“<b>I was afraid</b> of not<br/> being able to eat food”</span>
                <i>Chhaya Majhi</i>
            </div> -->
            <div class="donation-bannerTag">
                <span>I got married in age of 13. My husband died when i was 16 with 2 children and no money, then i joined gurukul program from We/Can”</span>
                <i>Jyothi</i>
            </div>
        </div>
        <div class="top-support-section">
            <h2>Top 100 Supporters</h2>
            <div class="top-support-box">
                <marquee behavior="scroll" direction="left" scrollamount="5">
                    <ul class="supporter-ui">
                        <?php
                        $array = [];
                        ?> 
                        @foreach ($supportersData as $key => $data)
                            @if(!in_array($data['user_id'],$array))
                                @php
                                    $array[] = $data['user_id']
                                @endphp
                                <li class="supporter-li">
                                    <div class="support-text-box">
                                        <div class="support-text-avtar">
                                            @if($data['user']['user_profile'])
                                            <img src="{{ url('public/uploads').'/Users/'.$data['user']['user_profile'] }}" title="" alt="" />
                                            @else
                                            <img src="{{ url('public/images/user_placeholder.png') }}" title="" alt="" />
                                            @endif
                                        </div>
                                        <div class="support-text">
                                            <span>{{ $data['user']['name']}}</span> <b> @if($data['currency'] == 'INR') ₹ @else $ @endif {{ $data['amount'] }}</b>
                                        </div>
                                    </div>
                                </li>
                            @else
                                @php
                                    $array[] = $data['user_id']
                                @endphp
                            @endif
                        @endforeach
                    </ul>
                </marquee>
            </div>
        </div>
        <section class="certification-section">
        <img src="images/donation-sub-banner.jpg">
        <h3>
            “My life has completely changed” - jyothi
            <span> 12,000 monthly income  |  Children going to school  |  Out of poverty</span>
        </h3>
    </section>

    <!-- here-now -->
    <section class="here-now-main">
        <div class="container">
            <p>India will continue to add<span class="million">1 million</span>to its workforce every<span class="month">month</span>for
                the next 15 years. 50% of them come from<span class="poor">poor background</span>lacking hard skills needed
                for job.</p>
            <h2>
                We are on mission to change that.<br/>
                <b>Here's how?</b>
            </h2>
        </div>
    </section>

    <!-- gurukul program -->
    <section class="gurukul-main">
        <h2>Gurukul Program</h2>
        <div class="gurukul-program-section">
            <div class="full-width">
                <!-- poort box -->
                <div class="poor-box">
                    <div class="poor-box-icon">
                        <img src="images/poor-icon.png">
                    </div>
                    <div class="poor-box-text">
                        - Poor<br/>- Unskilled<br/>- 0 income
                    </div>
                </div>
                <!-- poort box end-->
                <!-- gurukul line -->
                <div class="gurukul-line">
                    <img src="images/line-img.png">
                </div>
                <!-- gurukul line end-->

                <!-- enter box -->
                <div class="enter-box">
                    <div class="enter-box-icon">
                        <img src="images/enter-icon.png">
                    </div>
                    <div class="gurukul-text">Enter Gurukul</div>
                </div>
                <!-- enter box end-->

                <!-- driving skil -->
                <div class="driving-skil driving-img-main">
                    <div class="gurukul-img-box">
                        <img src="images/driving-skil-img.png">
                    </div>
                    <div class="gurukul-text">Driving skill</div>
                </div>

                <!-- g-map -->
                <div class="g-map icon-box">
                    <div class="g-icon">
                        <img src="images/g-map.png">
                    </div>
                    <div class="gurukul-text">Google Map</div>
                </div>

                <!-- english -->
                <div class="english-skil driving-img-main">
                    <div class="gurukul-img-box">
                        <img src="images/english-img.png">
                    </div>
                    <div class="gurukul-text">English</div>
                </div>

                <!-- skills section -->
                <div class="skills-box">
                    <div class="skills-img">
                        <img src="images/skills-icon.png">
                    </div>
                    <div class="skills-text">
                        <span><i class="fa fa-check"></i>Skills</span>
                        <span><i class="fa fa-check"></i>Knowledge</span>
                        <span><i class="fa fa-check"></i>Mindset</span>
                    </div>
                </div>

                <!-- yoga section -->
                <div class="gurukul-yoga driving-img-main">
                    <div class="gurukul-img-box">
                        <img src="images/yoga-img.png">
                    </div>
                    <div class="gurukul-text">Yoga</div>
                </div>
                <!-- yoga section -->
                <div class="gurukul-graduate driving-img-main">
                    <div class="gurukul-img-box">
                        <img src="images/graduate-img.png">
                    </div>
                    <div class="gurukul-text">Graduate</div>
                </div>

                <!-- exit gurukul -->
                <div class="exit-gurkul icon-box">
                    <div class="g-icon">
                        <img src="images/exit-gurukul-icon.png">
                    </div>
                    <div class="gurukul-text">Exit Gurukul</div>
                </div>

                <!-- gurukul income -->
                <div class="gurukul-income">
                    <div class="gurukul-income-img">
                        <img src="images/income-icon.png">
                    </div>
                    <div class="gurukul-income-text">
                        12,000 income
                    </div>
                </div>

                <!-- career section -->
                <div class="gurukul-career icon-box">
                    <div class="g-icon">
                        <img src="images/career-icon.png">
                    </div>
                    <div class="gurukul-text">career guidance</div>
                </div>

                <!-- gurukul job -->
                <div class="gurukul-job driving-img-main">
                    <div class="gurukul-img-box">
                        <img src="images/graduate-img.png">
                    </div>
                    <div class="gurukul-text">Job Growth</div>
                </div>

                <!-- gurukul family -->
                <div class="gurukul-family icon-box">
                        <div class="g-icon">
                            <img src="images/happy-family.png">
                        </div>
                        <div class="gurukul-text">Happy Family</div>
                    </div>

            </div>
        </div>
    </section>
    <!-- gurukul program end-->
    <!-- Progress bar-->
    <section class="progress-main">
        <div class="container">
            <div class="section-row">
                <div class="section-col3">
                    <div class="circle-main full-width">
                        <div class="circle-box">8</div>
                        <label>Livelihoods</label>
                    </div>
                </div>
                <div class="section-col3">
                    <div class="circle-main full-width">
                        <div class="circle-box">100%</div>
                        <label>Placement</label>
                    </div>
                </div>
                <div class="section-col3">
                    <div class="circle-main full-width">
                        <div class="circle-box">5000</div>
                        <label>Student graduated</label>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- we support section -->
    <section class="support-section">
        <div class="container">
            <h2 class="sub-titlenew">We had your support along the way<br/>
                <img src="images/support-icon.png">
            </h2>

            <div class="testimonial-section">
                <div class="testimonial-slide">
                    <div class="testimonial-slides">
                        @if($testimonialData && !empty($testimonialData->toArray()))
                        @foreach($testimonialData as $Data)
                            <div class="testimonial-box">
                                <div class="testimonial-box-sub">
                                    <div class="testimonial-avtar">
                                    @if($Data->user_image)
                                        <img src="{{asset('/uploads').'/Testimonials/'.$Data->user_image}}">
                                    @else
                                    <img src="{{asset('/images/user_placeholder.png')}}">
                                    @endif
                                    </div>
                                    <div class="testimonial-detail">
                                        <h3>{{$Data->user_name}}</h3>
                                        <span>{{$Data->user_designation}}</span>
                                        <p><?php echo $Data->description;?></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                            <div class="testimonial-box">
                                <div class="testimonial-box-sub">
                                    <div class="testimonial-avtar"><img src="images/naveen-photo.jpg"></div>
                                    <div class="testimonial-detail">
                                        <h3>Naveen Tiwari</h3>
                                        <span>Founder & CEO, InMobi</span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-box">
                                <div class="testimonial-box-sub">
                                    <div class="testimonial-avtar"><img src="images/manish-photo.jpg"></div>
                                    <div class="testimonial-detail">
                                        <h3>Manish Sabharwal</h3>
                                        <span>Chairman and Co-founder, TeamLease</span>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-box">
                                <div class="testimonial-box-sub">
                                    <div class="testimonial-avtar"><img src="images/vijay-photo.jpg"></div>
                                    <div class="testimonial-detail">
                                        <h3>Vijay Shekhar Sharma </h3>
                                        <span>Founder, Paytm & One97</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- partner logo section -->
    <section class="partner-logo-main pt-0">
        <div class="container">
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

    <!-- we can section -->
    <section class="audit-main">
        <div class="container">
            <h3>Since the beginning, we’ve believed transparency was the only way to operate.<br/> Once you donate we clearly
                show what impact your money has with photos.
            </h3>
            <h2>We regularly audit our finances and share with our donors.</h2>
        </div>
    </section>

    <!-- Graph section -->
    <section class="graph-section">
        <div class="container">
            <h2 class="sub-titlenew">Check how are your donation is used?</h2>
            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
            
        </div>
    </section>
    <!-- need love section -->
    <section class="need-love-section">
        <div class="container">
            <h2 class="sub-titlenew">Not just money they need our love too
            </h2>
            <div class="need-love-from full-width">
                <div class="need-love-form-box">
                    <div class="need-love-form-col">
                        <h3>Send them a message</h3>
                        <h4>and we will make sure it reaches them.</h4>
                        <textarea placeholder="write something"></textarea>
                    </div>
                    <div class="need-love-form-col need-love-form-left">
                        <div class="need-form-field full-width">
                            <input type="text" value="" placeholder="your name">
                        </div>
                        <div class="need-form-field full-width">
                            <input type="text" value="" placeholder="email">
                        </div>
                        <div class="need-form-field full-width">
                            <input type="text" value="" placeholder="phone">
                        </div>
                        <div class="need-form-check">
                            <div class="checkbox">
                                <input id="check1" type="checkbox" name="check" value="check1">
                                <label for="check1">Send me email & whatsapp update about impact from my money</label>
                            </div>
                        </div>
                        <input type="submit" class="btn-box" value="Send MEssage" />
                    </div>
                </div>
            </div>
            <div class="need-love-msg">
                <div class="need-love-row">
                    <div class="need-love-col">
                        <div class="need-love-box">
                            <h3>Manish Pandey</h3>
                            <span>3 days ago</span>
                            <p>“Lorem ipsum dolor sit amet, consectetur elit sed do eiusmod tempor incididunt ut labore et dolore
                                Lorem ipsum dolor sit amet.”</p>
                        </div>
                    </div>
                    <div class="need-love-col">
                        <div class="need-love-box">
                            <h3>Manish Pandey</h3>
                            <span>3 days ago</span>
                            <p>“Lorem ipsum dolor sit amet, consectetur elit sed do eiusmod tempor incididunt ut labore et dolore
                                Lorem ipsum dolor sit amet.”</p>
                        </div>
                    </div>
                    <div class="need-love-col">
                        <div class="need-love-box">
                            <h3>Manish Pandey</h3>
                            <span>3 days ago</span>
                            <p>“Lorem ipsum dolor sit amet, consectetur elit sed do eiusmod tempor incididunt ut labore et dolore
                                Lorem ipsum dolor sit amet.”</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- tax section -->
    <section class="tax-section">
        <div class="container">
            <h2 class="sub-titlenew">Donations are exempted from tax</h2>
            <div class="tax-col">
                <img src="images/indian-flag.jpg">
                <br/>
                <p>All Indian donations are tax exempted under section 80G of the Income Tax Act, 1961</p>
                <span>80G Certficate</span>
            </div>
            <div class="tax-col">
                <img src="images/us-flag.jpg">
                <br/>
                <p>All US donations are tax exempted under 501(C)(3)</p>
                <span>501 (C) (3) certificate</span>
            </div>
        </div>
    </section>
@endsection