@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('users') }}">User Management</a>
    </li>
    <li class="breadcrumb-item active">Add New</li>
</ol>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">Add New</div>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card-body">
                {!! Form::open(array('url' => '/users', 'class' => "form-horizontal",'files' => true)) !!}
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name*</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email*</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" required />
                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="profile_image" class="col-md-4 col-form-label text-md-right">Profile Image</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="profile_image" name="profile_image" value=""/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone_number" class="col-md-4 col-form-label text-md-right">Phone Number*</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="" required />
                           
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
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input id="notification" type="checkbox" value=1 class="" name="notification" ><span> Subscribe email and whatsapp to get latest updates from We/Can</span>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                            <a href="{{ url('users') }}" class="btn btn-danger">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection