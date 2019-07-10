<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Testimonial;
use App\Models\ChartSetting;
use App\PaymentTransactions;
use App\Models\CustomPage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use App\Mail\SuccessMail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;
use Session;
use Redirect; 
use Auth;
use PDF;

class DonationController extends Controller
{
    // public function __construct(){
    //     /* Stripe secret key */

    //     $secret_key = env('STRIPE_SECRET');

    //     $this->stripe = new Stripe($secret_key,'2017-12-14');
    // }
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
        return $this->dopayment($request->all());
    }

    public function dopayment($data)
    {
        if ($data['type'] == 'razorpay') {
            return $this->PayWithRazorpay($data);
        }else{
            return $this->PayWithStripe($data);
        }
    }

    public function PayWithRazorpay($data)
    {
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

            $paymenttransaction->save();

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

    public function PayWithStripe($data)
    {
        $order_id = $data['order_id'];
        $stripe = Stripe::make('sk_test_KOKv6djbziQhpPN7fbmbr6HY00CIwPx7rr');
        try {
            $charge = $stripe->charges()->create([
                'card' => $data['payment_id'],
                'currency' => 'USD',
                'amount' => $data['amount'],
                'expand' => array('balance_transaction'),
                'metadata' => ["order_id" => $order_id],
                'description' => 'Add in wallet',
            ]);
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

                $paymenttransaction->save();

                $paymentsuccess = true;
            }

            //Send Email notification after successfull payment
            if( $paymentsuccess == true ){ //echo 1;
                $this->SendEmailNotification($charge['currency'], $charge['id'], $data['user_id']);
                $arr = array('msg' => 'Payment successfully credited', 'status' => true);
            }else{
                $arr = array('msg' => 'Money not add in wallet!!', 'status' => true);
            }
            return Response()->json($arr);

        } catch (Exception $e) {
            $arr = array('msg' => $e->getMessage(), 'status' => false);
            return Response()->json($arr);
        }
    }

    public function payment_success()
    {
        return view('Donation.thankyou');
    }

    public function payment_failed()
    {
        return view('Donation.payment_failed');
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
        $file_path = url('/') . '/public/uploads/PDF/'.$filename;
        $user = User::find($user_id);
        if($filename){
            $user->file_name = $filename;
        }
        $toEmail = $user->email;
        Mail::to($toEmail)->send(new SuccessMail($user));

        $data = [
            'phone' => '919909524492',
            // 'body' => $file_path,
            'body' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
            "filename" => $filename,
        ];
        $json = json_encode($data); // Encode data to JSON
        $token = env('WHATSAPP_TOKEN');
        // URL for request POST /message
        $url = env('WHATSAPP_API_FILE').$token;

        // Make a POST request
        $options = stream_context_create(['http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => $json
            ]
        ]);
        // Send a request
        $result = file_get_contents($url, false, $options);

        //print_r($result);


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
