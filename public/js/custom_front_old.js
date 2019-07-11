$(document).ready(function(){
	//disable autocomplete 
	$('input').attr("autocomplete", "off");
	$('input[type=email]').attr("autocomplete", "nope");
	
	var all_errors = $("#all_errors").html();
	var flashsuccess = $("#flashsuccess").html();
	var flash_error = $("#flash_error").html();
	if (all_errors || flashsuccess || flash_error) {
		var message = '';
		if ((flash_error && typeof flash_error !== "undefined") || (all_errors && typeof all_errors !== "undefined")) {
			// message += '<div class="alert alert-danger alert-dismissible" role="alert">';
			if (flash_error && typeof flash_error !== "undefined") {
				message += flash_error ;
			}
			if (all_errors && typeof all_errors !== "undefined") {
				message += '<br>'+all_errors;
			}
			// message += flash_error+'</div>';
		}
		if (flashsuccess) {
			message += '<div class="alert alert-success alert-dismissible" role="alert">';
			message += flashsuccess;
			message += '</div>';
		}
		$("#alert-popup-box").html(message);
		$("#alert-popup-bg").fadeIn();
  		$("#alert-popup-main").fadeIn();

  		$("#alert-popup-head i").on('click', function() {
		    $("#alert-popup-bg").fadeOut();
		    $("#alert-popup-main").fadeOut();
		});
	}

	$('.fa-eye-slash').click(function(){
		var current_type = $('#password').attr('type');
		var changed_type = (current_type == "password") ? "text" : "password";
		var type_class = (current_type == "password") ? "fa fa-eye" : "fa fa-eye-slash";
		$('#password').attr('type',changed_type);
		$('.form-field-box.passowrd-field i').removeClass();
		$('.form-field-box.passowrd-field i').addClass(type_class);
	});

	$(".give_donation").on('click',function(e){
		var this1 = $(this);
		$(".give_donation").each(function() {
			$(this).removeClass('active');
		});
		console.log(this1.attr('give'));
		$("#subscription_type").val(this1.attr('give'));
		this1.addClass('active');
	});

	$(".donation-btn").on('click',function(e){
		var loggedin_user = $("#loggedin_user").val();
		if (loggedin_user) {
			// $("#make_payment").trigger("click");
			$(".register_user").trigger("click");
		}else{
			$(".razorpay_form").hide();
			$(".signup_form").show();
		}
	});

	$(".js-pay-bundle_amount").on('click',function(e){
		var this1 = $(this);
		$(".js-pay-bundle_amount").each(function() {
			$(this).removeClass('selected_amount');
			$(this).removeClass('active');
		});
		this1.addClass('selected_amount');
		this1.addClass('active');
	});

	$(".register_user").on('click',function(e){
		// e.preventDefault();
		
		var currency = $("#currency").val();
		var payment_type = $("#payment_type").val();
		var name = $(".signup_form .name").val();
		var email = $(".signup_form .email").val();
		var phone_number = $(".signup_form .phone_number").val();
		var country_code = parseInt($(".signup_form .country_code").val());
		var signup_from = $(".signup_form .donation").val();
		var notification = 0;
		if ($(".signup_form #notification").prop('checked') == true) {
			notification = 1;
		}
		var loggedin_user = $("#loggedin_user").val();
		var exist_user = 0;
		if (loggedin_user) {
			exist_user = 1;
			//temporary code for milestone2
			if (country_code == '') {
			country_code='00';
			}
		}
		
		if (name && email && phone_number && country_code) {
			$(".pageloader").show();
			var csrftoken =$('meta[name="csrf-token"]').attr('content')
			var url = SITEURL + '/ajax_register'+'?_token=' + csrftoken;
			var amount = $(".selected_amount").data('ramount');
			var order_id = $("#order_id").val();
			var customer_id = $("#customer_id").val();
			console.log(amount);
			$.ajax({
	        	url: url,
	        	headers: {
		           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		       	},
	        	type: 'post',
	        	dataType: 'json',
	        	data: {
	        		name:name,
					email:email,
					phone_number:phone_number,
					country_code:country_code,
					signup_from:signup_from,
	        		notification:notification,
	        		user:loggedin_user,
	        		payment_type:payment_type,
	        		amount:amount,
	        		currency:currency,
	        		order_id:order_id,
	        		customer_id:customer_id,
	        	}, 
	        	success: function (result) {
	        		// $(".signup_form .name").val('');
	        		// $(".signup_form .email").val('');
	        		// $(".signup_form .phone_number").val('');
	        		// $(".signup_form #notification").prop('checked',false);

	        		$(".razorpay_form").show();
					$(".signup_form").hide();
					console.log(result.order_id);
					console.log(result.user_id);
					$("#order_id").val(result.order_id);
					$("#customer_id").val(result.customer_id);
					$("#loggedin_user").val(result.user_id);
					$("#make_payment").trigger("click");
					
	            },
	            error: function(xhr, status, error) {
	            	alert('Some error found!');
	            	$(".pageloader").fadeOut("slow");
	            },
	            complete: function(){
                    $(".pageloader").fadeOut("slow");
                }
	        });
		} else{
			alert("Please provide required details.");
		}
	});
	
	$.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });

	$("#currency_manager").on('change',function(){
		$(".pageloader").show();
		// $("#change_currency").trigger('click');

		var status = $("#header_currency").val();
		if (status==0){
			status=1;
		}else{
			status=0;
		}
		var csrftoken =$('meta[name="csrf-token"]').attr('content');
		$.ajax({
        	url: SITEURL+'/change_currency?_token='+csrftoken+'&&status='+status,
        	success: function (result) {
        		change(result);
            },
        });
		
	})

	var $addCoinsBundle = $('#make_payment');
	
	$addCoinsBundle.on('click', function(e) {
		var payment_type = $("#payment_type").val();
		var user_id = $("#loggedin_user").val();
		var order_id = $("#order_id").val();
		var customer_id = $("#customer_id").val();
		var subscription_type = $("#subscription_type").val();
		
		if (payment_type == 'razorpay') {
			selected_amount = $('.selected_amount');
			var amount = selected_amount.data('amount');
			if (amount == 0) {
				if ($("#manual_amount").val() == '') {
					e.preventDefault();
					alert('Please enter amount');return;
				}
				var dataItemId = selected_amount.data('itemid'),
				dataAmount = $("#manual_amount").val()+'00',
				dataCurrency = selected_amount.data('currency'),
				dataQty = selected_amount.data('qty'),
				dataProcessorid = selected_amount.data('processorid'),
				dataBrand = selected_amount.data('brand'),
				dataDescription = "Credit "+ $('#manual_amount').val() +" coins ("+ $('#manual_amount').val() +" {{ $currency }} )",
				dataThemeColor = selected_amount.data('themecolor'),
				dataImg = selected_amount.data('img');
			} else{
				var dataItemId = selected_amount.data('itemid'),
				dataAmount = selected_amount.data('amount'),
				dataCurrency = selected_amount.data('currency'),
				dataQty = selected_amount.data('qty'),
				dataProcessorid = selected_amount.data('processorid'),
				dataBrand = selected_amount.data('brand'),
				dataDescription = selected_amount.data('description'),
				dataThemeColor = selected_amount.data('themecolor'),
				dataImg = selected_amount.data('img');
			}

			callRazorPayScript(dataAmount, dataCurrency, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg, user_id, order_id, subscription_type, customer_id);

			e.preventDefault();
		}
	});

	$addCoinsBundle.on('click', function(e) {
		var payment_type = $("#payment_type").val();
		var subscription_type = $("#subscription_type").val();

		var user_id = $("#loggedin_user").val();
		var order_id = $("#order_id").val();
		var customer_id = $("#customer_id").val();
		if (payment_type == 'stripe') {
			var dataCoinId = $(this).data('coinid'),
			dataAmount = $(this).data('amount'),
			dataQty = $(this).data('qty'),
			dataBrand = $(this).data('brand'),
			dataDescription = $(this).data('description'),
			dataThemeColor = $(this).data('themecolor'),
			dataImg = $(this).data('img');

			callStripeCheckoutScript(dataCoinId, dataAmount, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg, user_id, order_id, subscription_type, customer_id);

			e.preventDefault();
		}
	});
});

if (window.location.href.indexOf("donation") > -1) {
	// payments();
}
/*
function payments() {

	 // Function to lazy load a script
	// -----------------------------------------------
	var payment_type = $("#payment_type").val();
	//RAZORPAY
	// var $addCoinsBundle = $('.js-pay-bundle');
	// var $addCoinsBundle = $('#donation-btn');
	var user_id = $("#loggedin_user").val();
	var order_id = $("#order_id").val();
	var $addCoinsBundle = $('#make_payment');
	var subscription_type = $('#subscription_type');
	if (payment_type == 'razorpay') {
		selected_amount = $('.selected_amount');
		var amount = selected_amount.data('amount');
		
		if (amount == 0) {
			if ($("#manual_amount").val() == '') {
				e.preventDefault();
				alert('Please enter amount');return;
			}
			var dataItemId = selected_amount.data('itemid'),
			dataAmount = $("#manual_amount").val()+'00',
			dataCurrency = selected_amount.data('currency'),
			dataQty = selected_amount.data('qty'),
			dataProcessorid = selected_amount.data('processorid'),
			dataBrand = selected_amount.data('brand'),
			dataDescription = "Credit "+ $('#manual_amount').val() +" coins ("+ $('#manual_amount').val() +" {{ $currency }} )",
			dataThemeColor = selected_amount.data('themecolor'),
			dataImg = selected_amount.data('img');
		} else{
			var dataItemId = selected_amount.data('itemid'),
			dataAmount = selected_amount.data('amount'),
			dataCurrency = selected_amount.data('currency'),
			dataQty = selected_amount.data('qty'),
			dataProcessorid = selected_amount.data('processorid'),
			dataBrand = selected_amount.data('brand'),
			dataDescription = selected_amount.data('description'),
			dataThemeColor = selected_amount.data('themecolor'),
			dataImg = selected_amount.data('img');
		}
		callRazorPayScript(dataAmount,dataCurrency, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg, user_id, order_id, subscription_type);
	}else{
		var dataCoinId = $(this).data('coinid'),
			dataAmount = $(this).data('amount'),
			dataQty = $(this).data('qty'),
			dataBrand = $(this).data('brand'),
			dataDescription = $(this).data('description'),
			dataThemeColor = $(this).data('themecolor'),
			dataImg = $(this).data('img');

		callStripeCheckoutScript(dataCoinId, dataAmount, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg, user_id, order_id);
	}

}*/

function callRazorPayScript(dataAmount,dataCurrency, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg, user_id, order_id, subscription_type, customer_id) {
	var amount = dataAmount,
	currency = dataCurrency,
	qty = dataQty,
	brand = dataBrand,
	description = dataDescription,
	themeColor = dataThemeColor,
	img = dataImg;
	// var order_id = $("#order_id").val();
	// var user_id = $("#loggedin_user").val();
	console.log('user_id'+user_id);
	console.log('order_id'+order_id);
	loadExternalScript('https://checkout.razorpay.com/v1/checkout.js').then(function() { 
		var order_id = $("#order_id").val();
		var customer_id = $("#customer_id").val();
		var options = {
            key: 'rzp_test_lZAJDviG4Iirxp', // Replace with your RazorPay public key
            protocol: 'https',
            hostname: 'api.razorpay.com',
            amount: amount,
            customer_id:customer_id,
            notes:{ 
            	order_id: order_id,
            	customer_id: customer_id,
            	user_id: user_id
            },
            currency: currency,
            name: brand,
            description: description,
            image: img,
            theme: {
            	color: themeColor,
            },
            callback_url: SITEURL+'/payment?order_id='+order_id+'&&user_id='+user_id+'&type=razorpay&subscription_type='+subscription_type+'&customer_id='+customer_id,
  			redirect: true,
            /*handler: function(transaction, response) {
            	console.log(response);debugger;
            	$(".pageloader").show();

				var csrftoken =$('meta[name="csrf-token"]').attr('content')
				

            	if (typeof transaction.razorpay_payment_id == 'undefined' ||  transaction.razorpay_payment_id < 1) {
            		alert();
            	} else {
	            	console.log(response);
	            	console.log(transaction);
	                // console.log('Transaction Id: ', transaction.razorpay_payment_id);
	                // console.log('Razor Payment Id: ', response.razorpay_payment_id);
	                // $(".razorpay_form").submit();
	                var url = SITEURL + '/dopayment'+'?_token=' + csrftoken;

	                console.log(url);
	                $.ajax({
	                	url: url,
	                	type: 'post',
	                	dataType: 'json',
	                	data: {
	                		payment_id: transaction.razorpay_payment_id , 
	                		amount : amount,
	                		type:'razorpay',
	                		order_id:order_id
	                	},
	                	success: function (result) {
	                		console.log(result);
	                		// alert(result.msg);
	                		$(".pageloader").fadeOut("slow");
							window.location.href = SITEURL+'/payment_success';
	                        // window.location.href = SITEURL;
	                    },
	                    error: function(xhr, status, error) {
	                    	alert('Something went wrong!');
	                    },
	                    complete: function(){
		                    $(".pageloader").fadeOut("slow");
		                }
	                });
            	}
            },*/
            /*success: function (result) {
            	console.log('result');
            	console.log(result);
            },
            error : function(response){    
            	// var error_obj = response.error;    
            	console.log('error');    
            	console.log(response);    
            	// if(error_obj.field)        
            	// 	$('input[name=' + error_obj.field+']').addClass('invalid');
            }*/
		    // "modal": {
		    //     "ondismiss": function(){
		    //         console.log('Checkout form closed');
		    //     }
		    // }
        }

        window.rzpay = new Razorpay(options);
        rzpay.open();
    });
}
function loadExternalScript(path) {
	var result = $.Deferred(),
	script = document.createElement("script");

	script.async = "async";
	script.type = "text/javascript";
	script.src = path;
	script.onload = script.onreadystatechange = function(_, isAbort) {
		if (!script.readyState || /loaded|complete/.test(script.readyState)) {
			if (isAbort){
				alert(1);
				result.reject();
			} else{
				alert(2);
				result.resolve();
			}
		}
	};

	script.onerror = function() {
		result.reject();
		alert(3);
	};

	$("head")[0].appendChild(script);

	return result.promise();
}
function callStripeCheckoutScript(dataCoinId, dataAmount, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg, user_id, order_id, subscription_type, customer_id) {
	var coinId = dataCoinId,
		amount = dataAmount,
		qty = dataQty,
		brand = dataBrand,
		description = dataDescription,
		themeColor = dataThemeColor,
		subscription_type = subscription_type,
		img = dataImg;

	loadExternalScript('https://checkout.stripe.com/checkout.js').then(function() {

		var handler = StripeCheckout.configure({
			key: 'pk_test_5B5loe91O0AsFmXh6zgniWwF000QFzbmuk',
			locale: 'auto',
			token: function(token) {
				// Use the token to create the charge with a server-side script.
				// You can access the token ID with `token.id`
				console.log('Token Id', token.id);
				console.log('Token Email', token.email);        
				var csrftoken =$('meta[name="csrf-token"]').attr('content')
				// var url = SITEURL + '/dopayment'+'?_token=' + csrftoken;
				var url = SITEURL + '/payment'+'?order_id='+order_id+'&&user_id='+user_id+'&type=stripe&subscription_type='+subscription_type+'&customer_id='+customer_id;
				var amount = $(".selected_amount").data('ramount');

				console.log(url);
				$.ajax({
					url: url,
					type: 'post',
					dataType: 'json',
					data: {
						payment_id: token.id , 
						amount : amount,
						type:'stripe',
						order_id:order_id,
						customer_id:customer_id,
						user_id:user_id,
					}, 
					success: function (result) {
						console.log(result);
						// alert(result.msg);

						window.location.href = SITEURL+'/payment_success';
					},
					error: function(error) {
						console.log(error);
					}
				});
			},
			opened: function() {
				console.log('Opened Stripe modal');
			},
			closed: function() {
				console.log('Closed Strip modal');
			}
		});

		// Open Checkout with further options
		handler.open({
			name: brand,
			image: img,
			description: description,
			amount: amount,
			currency: 'USD'
		});

		// CLose checkout on page navigation
		$(window).on('popstate', function() {
			handler.close();
		});
	});


	console.log('Coin Id: ', coinId);
	console.log('Amount: ', amount);
	console.log('Quantity: ', qty);
	console.log('Brand: ', brand);
	console.log('Description: ', description);
	console.log('ThemeColor: ', themeColor);
	console.log('Image: ', img);	
}
function loadExternalScript(path) {
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
		result.reject();
	};

	$("head")[0].appendChild(script);

	return result.promise();
}
function change(status) {
	$("#header_currency").val(status);
	console.log(status);
	var currency = '';
	var amount = '';
	var type = '';
	var logo = '';
	var ramount = '';
	if(status==1){
		$("#payment_type").val('stripe');
		currency = 'USD';
		type='stripe';
		logo = '$';
	}else{
		$("#payment_type").val('razorpay');
		currency = 'INR';
		type='razor';
		logo = '₹';
	}

	console.log(currency);
	console.log(type);
	console.log(logo);

	$(".donation-price-tag .js-pay-bundle").each(function(){
		ramount = $(this).data('ramount');
		if($(this).prop('checked')){
	    	amount = ramount;
	    }else{
	    	amount = ramount+'00';
	    }
		$("#currency").val(currency);
		$(this).data('currency',currency);
		$(this).data('amount',amount);
		$(this).data('processorid',type);
		$(this).html(logo+' '+ramount);
	});
	$(".pageloader").fadeOut("slow");
}