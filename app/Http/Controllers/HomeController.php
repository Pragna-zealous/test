<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\ChartSetting;
use App\Models\CustomPage;
use App\Models\Partner;
use App\Models\Programme;
use App\PaymentTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Response;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('welcome');
        $partnerimages = Partner::orderBy('image_order', 'asc')->get();
        $programmeimages = Programme::orderBy('image_order', 'asc')->get();
        return view('home_front', compact('partnerimages','programmeimages'));
    }

    public function profile(){
        // return view('user/profile');
        return view('user/profile_front');
    }

    public function edit_profile(Request $request){
        // dd($request->all());
        $rules = array(
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::user()->id],
            'phone_number' => 'required|numeric|digits_between:10,25',
            'profile_image' => 'mimes:jpeg,jpg,png',
            
        );
        if ($request->password != '') {
            $rules['password'] = ['sometimes','required', 'string', 'min:8', 'confirmed'];
        }
       
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('profile')->withErrors($validator)->withInput();
        } 
        
        // $imageName = '';
        // if(!empty(request()->profile_image)){
        //     $imageName = time().'.'.request()->profile_image->getClientOriginalExtension();
        //     $imagearray = request()->profile_image->move(public_path('uploads'), $imageName);
        // }  
        $user = User::find(Auth::user()->id);
        if($request->password != '' && !Hash::check($request->old_password, $user->password)) {
            \Session::flash('flash_success', 'The current password is incorrect.');
            return redirect('profile');
        }
        $profile_image = '';
        if(!empty(request()->profile_image)){
            $imageName = time().'.'.request()->profile_image->getClientOriginalExtension();
            $imagearray = request()->profile_image->move(public_path('uploads/Users/'), $imageName);
            $user->user_profile = $imageName;
            if(!empty(request()->profile_image_hidden)){
                $old_image=$request->profile_image_hidden;
                if(file_exists(public_path('uploads').'/Users/'.$old_image)){
                    unlink(public_path('uploads').'/Users/'.$old_image);
                }
            }
        }elseif(empty(request()->profile_image_hidden)){
            $old_image=$user->user_profile;
            
            if($old_image && file_exists(public_path('uploads').'/Users/'.$old_image)){
                unlink(public_path('uploads').'/Users/'.$old_image);
            }
            $user->user_profile = '';
        }
        // dd(request()->status_checkbox);
        if(request()->status_checkbox == "on"){
            $status_checkbox = 1;
        }else{
            $status_checkbox = 0;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->whatsapp_notification = $status_checkbox;
        $user->email_notification = $status_checkbox;
        // if($profile_image){
        //     $user->user_profile = $profile_image;
        // }
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        \Session::flash('flash_success', 'Profile updated successfully.');
        return redirect('profile');
    }

    public function dashboard()
    {
        return view('home');
    }

    public function chart_settings()
    {
        $Chartdata = ChartSetting::all();
        if($Chartdata){
            $Chartdata = $Chartdata->toArray();
        }
        return view('chart.index',compact('Chartdata'));
    }

    public function transaction()
    {
        if (Auth::user()->user_type == 'admin') {
            $TransactionData = PaymentTransactions::with('user')->orderBy('created_at','DESC')->get();
        }else{
            $TransactionData = PaymentTransactions::with('user')->where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
        }
        
        return view('payment.history',compact('TransactionData'));
    }

    public function privacypolicy()
    {
        return view('privacy-policy');
    }
    
    public function termsofuse()
    {
        return view('privacy-policy');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequest()
    {
        return view('ajaxRequest');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequestPost(Request $request)
    {
        // $v = Validator::make($request->all(), [
        //     'title' => 'required',
        //     'legend' => 'required',
        //     'value' => 'required',
        //     'colour' => 'required',
        // ]);

        // if ($v->fails())
        // {
        //     return redirect()->back()->withErrors($v->errors());
        // }

        ChartSetting::truncate();
        $data = $request->all();
        foreach ($data as $data_value){ 
            if($data_value['legend'] == ''){
                $data_value['legend'] = $data_value['title'];
            }
            $data_save = [
                'title' => $data_value['title'],
                'legend' => $data_value['legend'],
                'value' => $data_value['value'],
                'color' => $data_value['colour'],
            ];
            $user = ChartSetting::create($data_save);
        }
        return response()->json(['success'=>'Chart value saved successfully']);
    }

    public function custompage_load($page_slug){
        $customdata = CustomPage::where('page_slug',$page_slug)->first();
        return view('custompage_load',compact('customdata'));
    }


    public function create_user_ajax(Request $request)
    {
        // dd($request->all());
        $pay_user_id = '';
        $data = $request->all();
        if (!$data['user']) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone_number' => 'required|numeric|digits_between:10,100',
                'country_code' => 'required|numeric',
                // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400); 
            }

            $exist_user = User::where('email', $data['email'])->first();
            if (! $exist_user) {
                $password = random_num(8);
                //dd($data['notification']);
                if($data['notification'] == 1 || $data['notification'] == '1' ){
                    $notification = 1;
                }else{
                    $notification = 0;
                }
                
                $data['notification'];
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'country_code' => $data['country_code'],
                    'phone_number' => $data['phone_number'],
                    'whatsapp_notification' => $notification,
                    'email_notification' => $notification,
                    'password' => Hash::make($password),
                    'signup_from' => $data['signup_from'],
                ]);
                $pay_user_id = $user->id;
                Mail::to($data['email'])->send(new WelcomeMail($user,$password));
            }else{
                //dd($request->all());
                $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'phone_number' => 'required|numeric|digits_between:10,100',
                    'country_code' => 'required|numeric|digits_between:1,100',
                    // 'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
    
                if ($validator->fails()) {
                    return Response::json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
    
                    ), 400);
                }

                if($data['notification'] == 1 || $data['notification'] == '1' ){
                    $notification = 1;
                }else{
                    $notification = 0;
                }
                $pay_user_id = $exist_user['id'];
                if( $exist_user['active_status'] == 0 ){
                    // $user = User::find(Auth::user()->id);
                    $password = random_num(8);
                    $exist_user->name = $data['name'];
                    $exist_user->country_code = $data['country_code'];
                    $exist_user->phone_number = $data['phone_number'];
                    $exist_user->password = Hash::make($password);
                    $exist_user->whatsapp_notification = $notification;
                    $exist_user->email_notification = $notification;
                    $exist_user->save();
                    Mail::to($data['email'])->send(new WelcomeMail($exist_user,$password));
                }else{
                    Auth::login($exist_user);
                }
            }
        }else{
            $pay_user_id = $data['user'];
        }

        if ($data['order_id']) {
            $order_id = $data['order_id'];
            $payment_order = PaymentTransactions::where('order_id',$order_id)->where('payment_id','')->latest()->first();
            if (empty($payment_order)) {
                $data['order_id'] = '';
            }
        }

        if (empty($data['order_id'])) {
            $payment_order = PaymentTransactions::select('order_id')->where('user_id', $pay_user_id)->where('payment_id','')->where('status','!=','failed')->latest()->first();

            if (! $payment_order) {
                $payment_order = PaymentTransactions::latest()->first();
                if ($payment_order) {
                    $order_id = filter_var($payment_order->order_id, FILTER_SANITIZE_NUMBER_INT);
                    $str = "wecan";
                    $order_id = str_pad($str, 16, "0", STR_PAD_RIGHT).($order_id+1);
                }else{
                    $str = "wecan";
                    $order_id = str_pad($str, 16, "0", STR_PAD_RIGHT).'1';
                }
                $data = [
                    'user_id'       =>      $pay_user_id,
                    'type'          =>      $data['payment_type'],
                    'amount'        =>      $data['amount'],
                    'fee'           =>      0,
                    'tax'           =>      0,
                    'currency'      =>      $data['currency'],
                    'method'        =>      '',
                    'status'        =>      'initialized',
                    'email'         =>      $data['email'],
                    'contact'       =>      $data['phone_number'],
                    'description'   =>      '',
                    'payment_id'    =>      '',
                    'order_id'      =>      $order_id,
                ];
                PaymentTransactions::create($data);
            }else{
                $order_id = $payment_order->order_id;
            }
            /*if ($data['payment_type'] == 'razorpay') {
                //get API Configuration 
                $api = new Api('rzp_test_lZAJDviG4Iirxp', 'DKYxyzOceZwqpePHwWVTEaTS');
                $orderData = [
                    'receipt' => $order_id,
                    'amount' => $_POST['amount'] * 100,
                    'currency' => $_POST['currency'],
                    'payment_capture' => 1
                ];
                $razorpayOrder = $api->order->create($orderData);
                // dd($razorpayOrder);
                $order_id = $razorpayOrder->id;

                $payment_order->order_id = $order_id;
                $payment_order->save();
            }*/
        }

        return Response::json(array('success' => true,'order_id'=>$order_id,'user_id'=>$pay_user_id), 200);
    }

    public function about_us(){
        return view('about_us');
    }

    public function footer_signup(Request $request){
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); 
        }

        $exist_user = User::where('email', $data['email'])->first();
        if (! $exist_user) {
            $password = random_num(8);
            $notification = 0;
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                // 'country_code' => $data['country_code'],
                // 'phone_number' => $data['phone_number'],
                'whatsapp_notification' => $notification,
                'email_notification' => $notification,
                'password' => Hash::make($password),
                'signup_from' => 'footer',
            ]);
            $pay_user_id = $user->id;

            $orderdata = null;
        }
        return redirect('/');
    }
}
