@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    @if(isset($Userdata) && $Userdata)
        <li class="breadcrumb-item">
            <a href="{{ url('users') }}">User Management</a>
        </li>
        <li class="breadcrumb-item active">Edit User</li>
        @php $title = 'Edit User'; @endphp
    @else
        <li class="breadcrumb-item active">Profile</li>
        @php $title = 'Profile'; @endphp
    @endif
</ol>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">{{$title}}</div>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @php
                if(isset($Userdata) && $Userdata){
                    $user_data = $Userdata;
                    $btn='Update';
                    $action=url('users',$user_data->id);
                    $route=url('users');
                    $method='patch';
                }else{
                    $user_data = Auth::user();
                    $action=route('edit_profile');
                    $btn='Edit Profile';
                    $route=route('dashboard');
                    $method='post';
                }
            @endphp

            <div class="card-body">
                    @if(isset($Userdata) && $Userdata)
                        {!! Form::model($user_data, [
                            'method' => 'PATCH',
                            'route' => ['users.update', $user_data->id],'files' => 'true'
                        ]) !!}
                    @else
                        <form method="POST" action="{{route('edit_profile')}}" enctype="multipart/form-data">
                    @endif

                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name*</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $user_data->name }}" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email*</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $user_data->email }}" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="profile_image" class="col-md-4 col-form-label text-md-right">Profile Image</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="profile_image" name="profile_image" value=""/>
                        </div>
                        @if($user_data->user_profile)
                            <div class="profile_image_section">
                                <input type="hidden" class="profile_image" value="{{$user_data->user_profile}}" name="profile_image_hidden">
                                <img title="Remove" src="{{ url('public/uploads/Users').'/'.$user_data->user_profile }}" style="width: 40px; height: 40px; border-radius: 50%;" class="profile_image_preview">
                                <a title="Remove" class="text-danger fa fa-close delete_profile_image pointer" aria-hidden="true" hrefpath="{{ url('destroy_profile_image/'.$user_data->user_profile) }}">x</a>
                            </div>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label for="phone_number" class="col-md-4 col-form-label text-md-right">Phone Number*</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="{{ $user_data->phone_number }}" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirm_password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" placeholder="Enter Confirm Password" />
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{$btn}}
                            </button>
                            <a href="{{$route}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection