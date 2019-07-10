@extends('layouts.app_front')
@section('content')
{!! Form::open(array('url' => '/dopayment', 'class' => "form-horizontal razorpay_form")) !!}
<button class="js-add-coin" data-coinid="buycoin1" data-amount="2000" data-qty="1" data-brand="Billabong" data-description="Credit 20 coins ($20)" data-themecolor="#B9A76E" data-img="https://logo.clearbit.com/billabong.com">20 coins</button>

<button class="js-add-coin" data-coinid="buycoin2" data-amount="5000" data-qty="1" data-brand="Microsoft" data-description="Credit 50 coins ($50)" data-themecolor="#B9A76E" data-img="https://logo.clearbit.com/microsoft.com">50 coins</button>

<button class="js-add-coin" data-coinid="buycoin3" data-amount="10000" data-qty="1" data-brand="IBM" data-description="Credit 100 coins ($100)" data-themecolor="#B9A76E" data-img="https://logo.clearbit.com/ibm.com">100 coins</button>
</form>
<script type="text/javascript" src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
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
    result.reject();
  };

  $("head")[0].appendChild(script);

  return result.promise();
};

var callStripeCheckoutScript = function(dataCoinId, dataAmount, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg) {

  var coinId = dataCoinId,
      amount = dataAmount,
      qty = dataQty,
      brand = dataBrand,
      description = dataDescription,
      themeColor = dataThemeColor,
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
        $.ajax({
          url: SITEURL + '/dopayment'+'?_token=' + csrftoken,
          type: 'post',
          dataType: 'json',
          data: {
            payment_id: token.id , 
            amount : 10,
            type:'stripe',
          }, 
          success: function (result) {
            console.log(result);
            // alert(result.msg);

                // window.location.href = SITEURL+'payment_success';
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

// Trigger addCoins CTA depending on the bundle selected
// -----------------------------------------------------
var $addCoinsBundle = $('.js-add-coin');

$addCoinsBundle.on('click', function(e) {
  var dataCoinId = $(this).data('coinid'),
      dataAmount = $(this).data('amount'),
      dataQty = $(this).data('qty'),
      dataBrand = $(this).data('brand'),
      dataDescription = $(this).data('description'),
      dataThemeColor = $(this).data('themecolor'),
      dataImg = $(this).data('img');

  callStripeCheckoutScript(dataCoinId, dataAmount, dataQty, dataBrand, dataDescription, dataThemeColor, dataImg);

  e.preventDefault();
});
</script>
@endsection