@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">User Management</li>
</ol>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">User Listing <a class="header_btn btn btn-sm btn-primary" href="{{ url('users/create') }}">Add New</a></div>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>User Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Registration Date</th>
                                <th>Signup From</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($Userdata as $user)
                                @if($user->user_type != 'admin')
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            @if(!empty($user->user_profile))
                                                <img src="{{ url('public/uploads').'/Users/'.$user->user_profile }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                            @else
                                                <img src="{{ url('public/images/user_placeholder.png') }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                            @endif
                                        </td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone_number}}</td>
                                        <td>{{date('Y-m-d',strtotime($user->created_at))}}</td>
                                        <td>{{$user->signup_from}}</td>
                                        <td>
                                            <a href="{{route('users.edit',$user->id)}}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a>
                                            <!-- <a href="{{url('users/delete',$user->id)}}" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-fw fa-trash"></i></a> -->
                                            <form action="{{url('users/delete',$user->id)}}" method="GET" class="destroy_form">
                                                @method('DELETE')
                                                @csrf
                                                <button class="delete_page btn btn-danger btn-sm" title="Delete" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span><i class="fas fa-fw fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection