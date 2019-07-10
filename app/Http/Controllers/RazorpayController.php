<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Redirect;	
use App\PaymentTransactions;
use Auth;

use Illuminate\Support\Facades\Validator;

use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;

class RazorpayController extends Controller
{
    public function pay()
    {        
        // Detect location and if india then razorpay view or stripe
        return view('payment.payWithRazorpay');
        // return view('payment.paywithstripe');
    }

    
}
