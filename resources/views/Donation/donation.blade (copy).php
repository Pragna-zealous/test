@extends('layouts.app_front')

@section('content')
        <?php
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $res = json_decode(file_get_contents('https://www.iplocate.io/api/lookup/'.$ipaddress));
        // $res->country_code='USD';
        if($res->country_code=='IN' || empty($res->country_code)){
            $payment_type = 'razorpay';
            $currency = 'INR';
            $currencyicon = '₹';
        }else{
            $payment_type = 'stripe';
            $currency = 'USD';
            $currencyicon = '$';
        }
        ?>
        <div class="donation-banner">
            <div class="banner-container">
                <!-- banner form -->
                <div class="banner-form">
                    {!! Form::open(array('url' => '/dopayment', 'class' => "form-horizontal razorpay_form")) !!}
                        <input type="hidden" id="loggedin_user" value="{{(Auth::user() ? Auth::user()->id : '')}}">
                        <input type="hidden" id="payment_type" value="{{ $payment_type }}" />
                        <input type="hidden" id="currency" value="{{ $currency }}" />
                        <div class="banner-form-title">
                            “I would <b>like to contribute</b> for people like chaiya majhi”
                        </div>
                        <div class="donation-tab">
                            <div class="donation-tab-top">
                                <a class="active give_donation cursor" give="once">Give Once</a>
                                <a class="give_donation cursor" give="monthly">Give Monthly</a>
                            </div>
                            <div class="donation-price-tag">
                                <input type="hidden" id="order_id" value="{{ (($orderdata) ? $orderdata->order_id : '') }}">
                                <a class="js-pay-bundle active js-pay-bundle_amount cursor selected_amount" data-currency= "{{ $currency }}" data-itemid="donate1000" data-amount="100000" data-ramount="1000" data-processorid="razor" data-qty="1" data-brand="WeCan"data-description="Credit 1000 coins"data-themecolor="#B9A76E"data-img="https://logo.clearbit.com/microsoft.com">{{$currencyicon}} 1000</a>

                                <a class="js-pay-bundle js-pay-bundle_amount cursor" data-currency= "{{ $currency }}"  data-itemid="donate500" data-amount="50000" data-ramount="500" data-processorid="razor" data-qty="1" data-brand="WeCan"data-description="Credit 500 coins"data-themecolor="#B9A76E"data-img="https://logo.clearbit.com/microsoft.com">{{$currencyicon}} 500</a>

                                <a class="js-pay-bundle js-pay-bundle_amount cursor" data-currency= "{{ $currency }}"  data-itemid="donate250" data-amount="25000" data-ramount="250" data-processorid="razor" data-qty="1" data-brand="WeCan"data-description="Credit 250 coins"data-themecolor="#B9A76E"data-img="https://logo.clearbit.com/microsoft.com">{{$currencyicon}} 250</a>
                               
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
                                        <input type="phone_number" class="form-control input-field phone_number" name="phone_number" value="{{(Auth::user() ? Auth::user()->phone_number : '')}}" required autocomplete="phone_number" placeholder="Phone Number*" style="margin-bottom: 10px;">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-10" style="margin-bottom: 10px;">
                                        <input id="notification" type="checkbox" value=1 class="notification" name="notification" ><span> I want to subscribe email and whatsapp to get latest updates from We/Can</span>
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
            <div class="donation-banner-tag">
                <span>“<b>I was afraid</b> of not<br/> being able to eat food”</span>
                <i>Chhaya Majhi</i>
            </div>
        </div>
        <div class="top-support-section">
            <h2>Top 100 Supporters</h2>
            <div class="top-support-box">
                <marquee behavior="scroll" direction="left" scrollamount="5">
                    <ul>
                        {{--
                        @foreach ($supportersData as $key => $data)
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    @php
                                    $user = new User;
                                    @endphp
                                    <span>{{ $user->username }}</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        --}}
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="support-text-box">
                                <div class="support-text-avtar">
                                    <img src="images/avtar-img.png" title="" alt="" />
                                </div>
                                <div class="support-text">
                                    <span>Ramesh Krishnan</span>
                                    <b>$1,00,000</b>
                                </div>
                            </div>
                        </li>
                    </ul>
                </marquee>
            </div>
        </div>
        <div class="donation-sub-banner">
            <div class="donation-sub-banner-tag">
                <span>“<strong>That fear</strong> of not having 2 meals a <br/> day <strong>is gone,</strong> <b>We’re Happy”</b></span>
                <i>Chhaya Majhi</i>
            </div>
        </div>
        <section class="day-box">
            <div class="container">
                <div class="day-box-title "> Rs 34 a day</div>
                <h3>1 in 3 indians live on less than Rs 34 a day</h3>
                <h2>we are on mission to change that</h2>
            </div>
        </section>
        <!-- we support section -->
        <section class="support-section">
            <div class="container">
                <h2>
                    We had your support <span>along the way</span><br/>
                    <img src="images/support-icon.png">
                </h2>
                <div class="testimonial-section">
                    <h2>Testimonial</h2>
                    <div class="testimonial-slide">
                        <div class="testimonial-slides">
                            @foreach($testimonialData as $Data)
                            <div class="testimonial-box">
                                <div class="testimonial-box-sub">
                                    <div class="testimonial-avtar"><img src="{{asset('/uploads/').'/'.$Data->user_image}}"></div>
                                    <div class="testimonial-detail">
                                        <h3>{{$Data->user_name}}</h3>
                                        <span>{{$Data->user_designation}}</span>
                                        <p><?php echo $Data->description;?></p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- we can section -->
        <section class="wecan-section">
            <div class="container">
                <img src="images/wecan-icon.png">
                <h2>We Can</h2>
                <h4>strives to set standards in transparency & ethics</h4>
            </div>
        </section>
        <!-- Graph section -->
        <section class="graph-section">
            <div class="container">
                <h2>Check how are your <b>donation</b> is used?</h2>
                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                <div class="graph-box">
                    <div class="graph-box-img">
                        <img src="images/graph-img.png">
                    </div>
                    <div class="graph-box-img right">
                        <img src="images/graph-text.png">
                    </div>
                </div>
            </div>
        </section>
        <!-- need love section -->
        <section class="need-love-section">
            <div class="container">
                <h2>
                    <img src="images/love-icon.png"><br/> Not just money <b>they need our love</b> too
                </h2>
                <div class="need-love-msg">
                    <div class="need-love-row">
                        <div class="need-love-col">
                            <div class="need-love-box">
                                <h3>Manish Pandey</h3>
                                <span>3 days ago</span>
                                <p>“Lorem ipsum dolor sit amet, consectetur elit sed do eiusmod tempor incididunt ut labore et dolore
                                    Lorem ipsum dolor sit amet.”
                                </p>
                            </div>
                        </div>
                        <div class="need-love-col">
                            <div class="need-love-box">
                                <h3>Manish Pandey</h3>
                                <span>3 days ago</span>
                                <p>“Lorem ipsum dolor sit amet, consectetur elit sed do eiusmod tempor incididunt ut labore et dolore
                                    Lorem ipsum dolor sit amet.”
                                </p>
                            </div>
                        </div>
                        <div class="need-love-col">
                            <div class="need-love-box">
                                <h3>Manish Pandey</h3>
                                <span>3 days ago</span>
                                <p>“Lorem ipsum dolor sit amet, consectetur elit sed do eiusmod tempor incididunt ut labore et dolore
                                    Lorem ipsum dolor sit amet.”
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- tax section -->
        <section class="tax-section">
            <div class="container">
                <h2>Donations are <b>exempted</b> from tax</h2>
                <div class="tax-col">
                    <img src="">
                    <p>All Indian donations are tax exempted under section 80G of the Income Tax Act, 1961</p>
                    <a href="{{ url('custompage_load/6') }}"><span>80G Certficate</span></a>
                </div>
                <div class="tax-col">
                    <img src="">
                    <p>All US donations are tax exempted under 501(C)(3)</p>
                    <span><a href="{{ url('custompage_load/7') }}">501 (C) (3) certificate</a></span>
                </div>
            </div>
        </section>
        <script type="text/javascript">
            var chart_data = [{
                    name: 'Internet Explorer',
                    y: 11.84,
                    color:'#000000'
                }, {
                    name: 'Firefox',
                    y: 10.85,
                    color:'#af0012'
                }, {
                    name: 'Edge',
                    y: 4.67,
                    color:'#F30552'
                }]
            // alert(typeof chart_data_color);
            var chart_data_color = '<?php //echo json_encode($chartData_color); ?>';
            // var chart_data = [{
            //         name: 'Chrome',
            //         y: 61.41,
            //         sliced: true,
            //         selected: true
            //     }, {
            //         name: 'Internet Explorer',
            //         y: 11.84
            // }];
        </script>
@endsection


