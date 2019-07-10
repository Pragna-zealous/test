<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Userdata = User::all();
        return view('user.index',compact('Userdata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $rules =  [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => 'required|numeric|digits_between:10,13',
            'profile_image' => 'mimes:jpeg,jpg,png',
        ];

        if ($request->password != '') {
            $rules['password'] = ['sometimes','required', 'string', 'min:8', 'confirmed'];
            $password = $request->password;
        }else{
            $password = random_num(8);
        }

        
        $validator = Validator::make($data,$rules);

        if ($validator->fails()) {
            return redirect()->route('users.create')->withErrors($validator)->withInput();
        } 
        $imageName = '';
        if(!empty(request()->profile_image)){
            $imageName = time().'.'.request()->profile_image->getClientOriginalExtension();
            $imagearray = request()->profile_image->move(public_path('uploads/Users/'), $imageName);
        }

        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($password),
            'user_profile' => $imageName,
            'whatsapp_notification' => ((!empty(request()->notification) ? $data['notification'] : 0)),
            'email_notification' => ((!empty(request()->notification) ? $data['notification'] : 0)),
            'user_type' => 'member'
        ];

        $user = User::create($data);

        Mail::to($data['email'])->send(new WelcomeMail($user,$password));
        \Session::flash('flash_success', 'User added successfully.');
        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Userdata = User::find($id);
        return view('user/profile',compact('Userdata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'phone_number' => 'required|numeric|digits_between:10,13',
            'profile_image' => 'mimes:jpeg,jpg,png',
            
        );
        if ($request->password != '') {
            $rules['password'] = ['sometimes','required', 'string', 'min:8', 'confirmed'];
        }
       
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('users.edit',$id)->withErrors($validator)->withInput();
        } 

        $user = User::find($id);
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

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        \Session::flash('flash_success', 'User updated successfully.');
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::find($id);    
        $user->delete();

        \Session::flash('flash_success', 'User deleted successfully.');
        return redirect('users');
    }

    // /**
    //  * Remove the image from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy_profile_image($id)
    // {
    //     dd('asdasd');
    //     $users = User::find($id);
    //     $image_name = $users->user_image;
    //     $path = public_path() . '/uploads/' . $image_name[0];
    //     if (file_exists($path) && !empty($image_name[0])) {
    //         unlink($path);
    //     }
    //     $users->user_image = '';
    //     $users->save();
    //     // CustomPage::find($id)->delete();
    // 	return redirect('/users')->with('success','Image removed successfully.');
    // }
}
