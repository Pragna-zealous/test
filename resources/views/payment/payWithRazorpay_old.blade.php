@extends('layouts.app')
@section('content')
<!-- For Other currency, need to convert it to Rs and submit only INR to razorpay -->
@php
    $currency = 'INR';
    $currency_icon = '₹';
    $payment_type = '';
@endphp
<!-- $payment_type = 'monthly' -->

    @if($payment_type == 'monthly')
        <button id="rzp-button1">Pay</button>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
        var options = {
            "key": "rzp_test_lZAJDviG4Iirxp",
            "subscription_id": "sub_CeO41rHBybI2Cx",
            "name": "Pragna",
            "description": "Purchase Description",
            "image": "/your_logo.png",
            "handler": function (response){
                alert(response.razorpay_payment_id);
            },
            "prefill": {
                "name": "Pragna Brahmbhatt",
                "email": "pragna@email.com"
            },
            "notes": {
                "address": "Hello World"
            },
            "theme": {
                "color": "#F37254"
            }
        };
        var rzp1 = new Razorpay(options);

        document.getElementById('rzp-button1').onclick = function(e){
            rzp1.open();
            e.preventDefault();
        }
        </script>

    @else
        {!! Form::open(array('url' => '/dopayment', 'class' => "form-horizontal razorpay_form")) !!}
            
            <button class="js-add-coin" 
                data-amount="15000" 
                data-currency= "{{ $currency }}" 
                data-brand="WeCan" 
                data-description="Credit 150 coins (150 {{ $currency }})" 
                data-themecolor="#B9A76E" 
                data-img="https://logo.clearbit.com/microsoft.com"
            >150 {{ $currency_icon }}</button>

            <button class="js-add-coin" 
                data-amount="25000" 
                data-currency= "{{ $currency }}" 
                data-brand="WeCan" 
                data-description="Credit 250 coins (250 {{ $currency }})" 
                data-themecolor="#B9A76E" 
                data-img="https://logo.clearbit.com/microsoft.com"
            >250 {{ $currency_icon }}</button>

            <button class="js-add-coin" 
                data-amount="50000" 
                data-currency= "{{ $currency }}" 
                data-brand="WeCan" 
                data-description="Credit 500 coins (500 {{ $currency }})" 
                data-themecolor="#B9A76E" 
                data-img="https://logo.clearbit.com/microsoft.com"
            >500 {{ $currency_icon }}</button>

            <button class="js-add-coin" 
                data-amount="100000" 
                data-currency= "{{ $currency }}" 
                data-brand="WeCan" 
                data-description="Credit 1000 coins (1000 {{ $currency }})" 
                data-themecolor="#B9A76E" 
                data-img="https://logo.clearbit.com/microsoft.com"
            >1000 {{ $currency_icon }}</button>

            <input type="text" name="manual_amount" placeholder="Other Amount" id="manual_amount" value="" />
            <button class="js-add-coin" 
                data-amount="" 
                data-currency= "{{ $currency }}" 
                data-brand="WeCan" 
                data-description="" 
                data-themecolor="#B9A76E" 
                data-img="https://logo.clearbit.com/microsoft.com">Other amount</button>
        {!! Form::close() !!}

        <script type="text/javascript">
            // Function to load script externally on demand
            // -----------------------------------------------
            var loadExternalScript = function(path) {
                var result = $.Deferred(),
                    script = document.createElement("script");

                script.async = "async";
                script.type = "text/javascript";
                script.src = path;
                script.onload = script.onreadystatechange = function(_, isAbort) {
                    if (!script.readyState || /loaded|complete/.test(script.readyState)) {
                        if (isAbort)
                            result.reject();
                        else
                            result.resolve();
                    }
                };

                script.onerror = function() {
                    console.log('error found');
                    result.reject();
                };

                $("head")[0].appendChild(script);

                return result.promise();
            };

            // Use loadScript to load the Razorpay checkout.js
            // -----------------------------------------------

            var SITEURL = '{{URL::to('')}}';
             $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
             }); 

            var callRazorPayScript = function(dataAmount,dataCurrency, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg) {

                var amount = dataAmount,
                    currency = dataCurrency,
                    qty = dataQty,
                    brand = dataBrand,
                    description = dataDescription,
                    themeColor = dataThemeColor,
                    img = dataImg;

                loadExternalScript('https://checkout.razorpay.com/v1/checkout.js').then(function() {
                    var options = {
                        key: 'rzp_test_lZAJDviG4Iirxp', // Replace with your RazorPay public key
                        protocol: 'https',
                        hostname: 'api.razorpay.com',
                        amount: amount,
                        currency: currency,
                        name: brand,
                        description: description,
                        image: img,
                        theme: {
                            color: themeColor
                        },
                        handler: function(transaction, response) {
                            console.log(response);
                            console.log(transaction);
                            // console.log('Transaction Id: ', transaction.razorpay_payment_id);
                            // console.log('Razor Payment Id: ', response.razorpay_payment_id);
                            // $(".razorpay_form").submit();
                            var url = SITEURL + '/dopayment'+'?_token=' + '{{ csrf_token() }}';
                            console.log(url);
                            $.ajax({
                                url: url,
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    razorpay_payment_id: transaction.razorpay_payment_id , 
                                    amount : amount
                                }, 
                                success: function (result) {
                                    console.log(result);
                                        alert(result.msg);
                                    
                                    // window.location.href = SITEURL;
                                }
                           });
                        }
                    };

                    window.rzpay = new Razorpay(options);
                    rzpay.open();
                });

                console.log('Amount: ', amount);
                console.log('currency: ', currency);
                console.log('Quantity: ', qty);
                console.log('Brand: ', brand);
                console.log('Description: ', description);
                console.log('ThemeColor: ', themeColor);
                console.log('Image: ', img);
            }

            // Trigger addCoins CTA depending on the bundle selected
            // -----------------------------------------------------
            var $addCoinsBundle = $('.js-add-coin');

            $addCoinsBundle.on('click', function(e) {
                var amount = $(this).data('amount');
                if (amount == 0) {
                    if ($("#manual_amount").val() == '') {
                        e.preventDefault();
                        alert('Please enter amount');return;
                    }
                    var dataItemId = $(this).data('itemid'),
                        dataAmount = $("#manual_amount").val()+'00',
                        dataCurrency = $(this).data('currency'),
                        dataQty = $(this).data('qty'),
                        dataProcessorid = $(this).data('processorid'),
                        dataBrand = $(this).data('brand'),
                        dataDescription = "Credit "+ $('#manual_amount').val() +" coins ("+ $('#manual_amount').val() +" {{ $currency }} )",
                        dataThemeColor = $(this).data('themecolor'),
                        dataImg = $(this).data('img');
                } else{
                    var dataItemId = $(this).data('itemid'),
                        dataAmount = $(this).data('amount'),
                        dataCurrency = $(this).data('currency'),
                        dataQty = $(this).data('qty'),
                        dataProcessorid = $(this).data('processorid'),
                        dataBrand = $(this).data('brand'),
                        dataDescription = $(this).data('description'),
                        dataThemeColor = $(this).data('themecolor'),
                        dataImg = $(this).data('img');
                }

                callRazorPayScript(dataAmount, dataCurrency, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg);

                e.preventDefault();
            });
        </script>
    @endif
@endsection    
    