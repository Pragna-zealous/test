<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Mail\Mailable;
use App\Mail\Masscommunication;
use Illuminate\Support\Facades\Mail;

class MasscommunicationController extends Controller
{
    public function mass_communication(){
        $all_users = User::select('id')->where('user_type','member')->get()->count();
        return view('Mass Communication/mass_communication',compact('all_users'));
    }

    /**
     * Autocomplete data from database
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = User::select(["id","name","email"])->where('user_type','member')
                ->get();
        return response()->json($data);
    }

    public function masscommunication_send(Request $request)
    {
        if($request['radio'] == 'all_users'){
            $description = $request['description'];
            $emails = User::select('email')
                        ->where('user_type','member')
                        ->where('email_notification',1)
                        ->pluck('email')
                        ->toArray();

            $phone_number = User::select('phone_number','country_code')
                                ->where('user_type','member')
                                ->where('whatsapp_notification',1)
                                ->get()
                                ->toArray();
            return $this->masscommunication_send_email($description,$emails,$phone_number);
            //return $this->masscommunication_send_whatsapp($description,$phone_number);
        }else if($request['radio'] == 'specified_user' && $request['specified_users'] != ''){
            $description = $request['description'];
            $emails = User::select('email')
                            ->whereIn('id',$request['specified_users'])
                            ->where('email_notification',1)
                            ->pluck('email')
                            ->toArray();
            $phone_number = User::select('phone_number','country_code')
                                ->whereIn('id',$request['specified_users'])
                                ->where('whatsapp_notification',1)
                                ->get()
                                ->toArray();
            return $this->masscommunication_send_email($description,$emails,$phone_number);
            //return $this->masscommunication_send_whatsapp($description,$phone_number);
        }
        $all_users = User::select('id')->where('user_type','member')->get()->count();
        return view('Mass Communication/mass_communication',compact('all_users'));
    }

    public function masscommunication_send_email($description,$emails,$phone_number)
    {
        $adminemail = User::select('email')->where('user_type','admin')->latest()->first();
        
        $data['to']=(($adminemail && $adminemail->email) ? $adminemail->email : 'admin@zealousys.com');
        $data['bcc']=$emails;
        $data['description']=$description;
        //dd($data['bcc']);

        Mail::to($data['to'])
        ->bcc($data['bcc'])
        ->send(new Masscommunication($data));
        return $this->masscommunication_send_whatsapp($description,$phone_number);
    }

    public function masscommunication_send_whatsapp($description,$phone_number)
    {
        foreach ($phone_number as $number) {
            $data = [
                'phone' => $number['country_code'].$number['phone_number'],
                'body' => html_entity_decode(strip_tags($description)),
            ];
            $json = json_encode($data); // Encode data to JSON
            // $token = 'iydlpki6b92wrx3e';
            $token = env('WHATSAPP_TOKEN');
            // URL for request POST /message

            // $url = 'https://eu36.chat-api.com/instance51378/message?token='.$token;
            $url = env('WHATSAPP_API_MESSAGE').$token;

            // Make a POST request
            $options = stream_context_create(['http' => [
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json',
                    'content' => $json
                ]
            ]);
            // Send a request
            $result = file_get_contents($url, false, $options);
        }
        return;
    }
}
