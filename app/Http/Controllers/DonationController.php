<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Testimonial;
use App\Models\ChartSetting;
use App\PaymentTransactions;
use App\Models\CustomPage;
use App\Models\Subscriptions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use App\Mail\SuccessMail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;
use Stripe\Error\Card;
// use Cartalyst\Stripe\Stripe;
use Stripe;
// use Stripe\Customer;
use Session;
use Redirect; 
use Auth;
use PDF;

class DonationController extends Controller
{
    public function __construct(){
        /* Stripe secret key */

        $secret_key = env('STRIPE_SECRET');

        $this->stripe = new Stripe($secret_key,'2017-12-14');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonialData = Testimonial::orderBy('id', 'desc')->take(3)->get();
        $chartData = ChartSetting::orderBy('id', 'desc')->get();
        $chartData_color = ChartSetting::orderBy('id', 'desc')->pluck('color');
        $orderdata = null;

        if (Auth::user()) {
            $orderdata = PaymentTransactions::select('order_id')->where('user_id', Auth::user()->id)->where('payment_id','')->where('status','!=','failed')->latest()->first();
        }
        // $supportersData = PaymentTransactions::groupBy('user_id')->selectRaw('sum(amount) as sum, user_id',"desc")->pluck('sum','user_id');

        $supportersData = PaymentTransactions::with('user')->select('*')->selectRaw('sum(amount) as amount')->where('payment_id','!=','')->groupBy('user_id')->orderBy('amount','DESC')->get();

        // dd($supportersData);

        return view('Donation/donation',compact('testimonialData','chartData','chartData_color','orderdata','supportersData'));
    }

    public function payment(Request $request)
    {
        $data =$request->all();
        if (isset($data['error']) && $data['error']) {
            $paymenttransaction = PaymentTransactions::where('order_id',$data['order_id'])->first();
            $paymenttransaction->user_id = $data['user_id'];
            $paymenttransaction->status = 'failed';
            $paymenttransaction->description = $data['error']['description'];
            // $paymenttransaction->payment_id = $data['razorpay_payment_id'];
            $paymenttransaction->save();

            \Session::flash('flash_pay_error', $data['error']['code']);
            return redirect('donation');
        }

        $order_id = $data['order_id'];

        //get API Configuration 
        $api = new Api('rzp_test_lZAJDviG4Iirxp', 'DKYxyzOceZwqpePHwWVTEaTS');

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($data['razorpay_payment_id']);
        $flag=0;

        try {
            $response = $api->payment->fetch($data['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));

            $paymenttransaction = PaymentTransactions::where('order_id',$order_id)->first();
            $paymenttransaction->user_id = $data['user_id'];
            $paymenttransaction->amount = substr($response['amount'], 0, -2);
            $paymenttransaction->fee = substr($response['fee'], 0, -2);
            $paymenttransaction->tax = substr($response['tax'], 0, -2);
            $paymenttransaction->currency = $response['currency'];
            $paymenttransaction->method = $response['method'];
            $paymenttransaction->status = $response['status'];
            $paymenttransaction->description = $response['description'];
            $paymenttransaction->payment_id = $data['razorpay_payment_id'];
            $paymenttransaction->payment_type = $data['subscription_type'];

            $paymenttransaction->save();

            if($data['subscription_type'] == 'monthly'){
                // $this->razorpay_subscription($data,$payment,$paymenttransaction);
                $date = date('Y-m-d',strtotime($paymenttransaction->created_at));
                $plan = $api->plan->create(
                    array('period' => 'monthly', 'interval' => 1, 'item' => array('name' => 'Test Monthly 1 plan', 'description' => 'Description for the monthly 1 plan', 'amount' => $paymenttransaction->amount.'00', 'currency' => $paymenttransaction->currency))
                );
                
                $subscription  = $api->subscription->create(
                    array('plan_id' => $plan->id, 'customer_notify' => 1, 'total_count' => 10, 'start_at' => strtotime("$date +1 month"), 'addons' => array(array('item' => array('name' => 'Donation', 'amount' => $paymenttransaction->amount.'00', 'currency' => $paymenttransaction->currency))))
                );
                // dd($paymenttransaction->id);
                $paymenttransaction = PaymentTransactions::find($paymenttransaction->id);
                $paymenttransaction->subscription_id = $subscription->id;
                $paymenttransaction->save();
            }

            $arr = array('msg' => 'Payment successfully credited', 'status' => true);

            //Send Email notification after successfull payment
            $flag = 1;            

        } catch (\Exception $e) {
            \Session::flash('flash_pay_error', $e->getMessage());
            return redirect('donation');
        }

        if ($flag) {
            try {
                $this->SendEmailNotification($response['currency'], $data['razorpay_payment_id'], $data['user_id']);
                return redirect('payment_success');
            }catch (\Exception $e) {
                return redirect('payment_success');
            }
        }    
    }

    public function PayWithStripe(Request $request)
    {
        $data=$request->all();
        $order_id = $data['order_id'];
        $stripe = Stripe::make('sk_test_KOKv6djbziQhpPN7fbmbr6HY00CIwPx7rr');
        $userdata = User::find($data['user_id']);
        $flag=0;


        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            // $tokendata = \Stripe\Token::retrieve($data['token']); //to retrieve token
            
            $customer_id = '';
            if($data['customer_id'] == ''){
                $customer = \Stripe\Customer::create([
                  "description" => "Customer for wecan donation",
                  "card" => $data['token'] // obtained with Stripe.js
                ]);

                $userdata=User::find($data['user_id']);
                $userdata->stripe_customer_id = $customer->id;
                $userdata->save();

                $customer_id=$customer->id;
            }else{
                $customer_id=$data['customer_id'];
            }

            $charge = \Stripe\Charge::create(array(
                "amount" => $data['amount'].'00',
                'expand' => array('balance_transaction'),   //to see stripe fee
                "currency" => "usd",
                "customer" => $customer_id,
                "description" => "Add in wallet",
                "metadata" => ["order_id" => $order_id],
            ));
           
            $paymentsuccess = false;
            if($charge['status'] == 'succeeded') {
                // PaymentTransactions::create($data);
                $paymenttransaction = PaymentTransactions::where('order_id',$order_id)->first();
                $paymenttransaction->user_id = $data['user_id'];
                $paymenttransaction->amount = substr($charge['amount'], 0, -2);
                $paymenttransaction->fee = sprintf('%.2f', $charge['balance_transaction']['fee'] / 100);
                $paymenttransaction->currency = $charge['currency'];
                $paymenttransaction->method = $charge['payment_method_details']['type'];
                $paymenttransaction->status = $charge['status'];
                $paymenttransaction->description = $charge['description'];
                $paymenttransaction->payment_id = $charge['id'];
                $paymenttransaction->payment_type = $data['subscription_type'];
                $paymenttransaction->save();

                $date = date('Y-m-d',strtotime($paymenttransaction->created_at));
                if($data['subscription_type'] == 'monthly'){
                    
                    $plan = \Stripe\Plan::create(array(
                        "amount" => $paymenttransaction->amount.'00',
                        "interval" => "month",
                        "product" => array(
                            "name" => "Donation"
                        ),
                        "currency" => $paymenttransaction->currency,
                    ));
// dd(strtotime("$date +1 month"));
                    $subscription = \Stripe\Subscription::create([
                      "customer" => $customer_id,
                       'trial_end' => strtotime("$date +1 month"),
                        'ends_at' => null,
                      "items" => [["plan" => $plan->id]],
                    ]);
                   
                    $paymenttransaction = PaymentTransactions::find($paymenttransaction->id);
                    $paymenttransaction->subscription_id = $subscription->id;
                    $paymenttransaction->save();
                }

                $flag = 1;
                $arr = array('msg' => 'Payment successfully credited', 'status' => true);
            }
        } catch (\Exception $e) {
            \Session::flash('flash_pay_error', $e->getMessage());
            return redirect('donation');
        }

        if ($flag) {
            try {
                $this->SendEmailNotification($response['currency'], $data['razorpay_payment_id'], $data['user_id']);
                return redirect('payment_success');
            }catch (\Exception $e) {
                return redirect('payment_success');
            }
        }

    }

    public function payment_success()
    {
        return view('Donation.thankyou');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function donation_backend()
    {
        return view('Donation/donation_backend');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function donation_save(Request $request)
    {
        dd($request);
        return view('Donation/donation_backend');
    }

    public function SendEmailNotification($currency, $id, $user_id)
    {
        $filename = $this->generatePDF($currency,$id);
        $user = User::find($user_id);
        if($filename){
            $user->file_name = $filename;
        }
        $toEmail = $user->email;
        Mail::to($toEmail)->send(new SuccessMail($user));
        return;
    }

    /**
     * GeneratePDF
     */
    public function generatePDF($currency, $pay_id = '')
    {
        if($currency == 'usd' ){
            $page_slug = '80g-certficate';
        }else{
            $page_slug = '501-c-3-certificate';
        }
        $pdf = '';
        if( $page_slug ){
        $customdata = CustomPage::select('description')->where('page_slug',$page_slug)->latest()->first();
            if($customdata['description']){
                $pdf = PDF::loadHTML($customdata['description']);
                // dd(public_path() . '/uploads/PDF/' .$pay_id.'.pdf');
                file_put_contents(public_path() . '/uploads/PDF/' .$pay_id.'.pdf', $pdf->output());
                $pdf = $pay_id.'.pdf';
            }
        }
        return $pdf;
    }

    public function verify_email(Request $request)
    {
        $get_string = base64_decode($request->account);
        parse_str($get_string, $get_array);
        $email = $get_array['email'];
        $password = $get_array['password'];
        $id = $get_array['id'];

        $user = User::find($id);
        $flag = 0;
        
        if(empty($user)){
            //fail session
            Session::set('failure', $value);
            return redirect('/');              
        }
        
        if($user->active_status == 1){
            return redirect('/');
        }
        $user->active_status = 1;
        $user->save();
        $flag = 1;
        //session success thanks.
        return redirect('/');  
    }

    public function change_currency(Request $request)
    {
        Session::put('header_currency',$request->status);
        // return Redirect()->back();
        return $request->status;
    }
}
