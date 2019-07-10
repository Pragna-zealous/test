@extends('layouts.app_front')

@section('content')
        
        @php
            $user_data = Auth::user();
            $action=route('edit_profile');
            $btn='Edit Profile';
            $route=route('dashboard');
            $method='post';
        @endphp
        <!-- profile start -->
        <section class="profile-section">
            <div class="container">
                <form method="POST" action="{{ route('edit_profile') }}" enctype="multipart/form-data">
                        @csrf
                    <div class="profile-box">
                        <div class="profile-pic">
                            @if($user_data->user_profile)
                                <span class="bg-img profile_image_preview" style="background-image:url('public/uploads/Users/{{$user_data->user_profile}}');" >
                                    <b><input type="file" id="profile_image" name="profile_image"></b>
                                </span>
                            @else
                                <span class="bg-img profile_image_preview"  >
                                    <b><input type="file" id="profile_image" name="profile_image"></b>
                                </span>
                            @endif    

                        @if($user_data->user_profile)
                            <div class="profile_image_section">
                                <input type="hidden" class="profile_image" value="{{$user_data->user_profile}}" name="profile_image_hidden">
                                <a title="Remove" class="text-danger fa fa-close delete_profile_image pointer" aria-hidden="true" hrefpath="{{ url('destroy_profile_image/'.$user_data->user_profile) }}"></a>
                            </div>
                        @endif


                        </div>
                        <div class="profile-edit">
                            <div class="profile-row">
                                <div class="profile-col">
                                    <input type="text" name="name" class="input-field" value="{{ $user_data->name }}" placeholder="Name">
                                </div>

                                <div class="profile-col">
                                    <input type="email" class="input-field" value="{{ $user_data->email }}" placeholder="Email*" name="email" required readonly>
                                </div>
                            </div>
                            <div class="profile-row">
                                <div class="profile-col">
                                    <input type="text" name="phone_number" name="phone_number" class="input-field" value="{{ $user_data->phone_number }}" placeholder="Enter Phone Number*" required>
                                </div>

                                <div class="profile-col">
                                    <div class="subscribe-box">
                                        I want to subscribe email and whatsapp to get latest updates from We/Can
                                        <label class="switch">
                                            <input type="checkbox" class="status_checkbox" name="status_checkbox" <?php echo ($user_data->whatsapp_notification == 1 ? 'checked' : '') ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-row  password-change pass-fields"  style="display: none;" >
                                <div class="profile-col">
                                    <input type="password" class="input-field old_password" value="" placeholder="Old password" name="old_password">
                                </div>
                                <div class="profile-col" >
                                    <input type="password" class="input-field new_password" value="" name="password" placeholder="New password">
                                </div>
                            </div>
                            <div class="profile-row pass-fields">
                                <div class="profile-col password-change" style="display: none;">
                                    <input type="password" class="input-field confirm_password" value="" name="password_confirmation" placeholder="Confirm new password">
                                </div>
                                <div class="profile-col password-change-btn">
                                        <input type="button" class="defult-btn full-width" value="I want to change password">
                                </div>
                                <div class="profile-col">
                                    <input type="button" class="defult-btn password-change cancel_password" value="Cancel" style="display: none;">
                                    <input type="submit" class="defult-btn pull-right" value="Save">
                                </div>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </form>
            </div>
        </section>
        <!-- profile end -->
       
@endsection