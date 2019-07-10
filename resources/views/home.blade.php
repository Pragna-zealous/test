@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Overview</li>
</ol>
<div class="row justify-content-center">
    <div class="col-md-12">
        <!-- <div class="card"> -->
            <!-- <div class="card-header">Dashboard</div> -->

            <!-- <div class="card-body"> -->
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            <!-- </div> -->

            <div class="row">
                @if(Auth::user()->user_type == "member")
                    <div class="col-xl-4 col-sm-6 mb-4">
                        <div class="card text-white bg-primary o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa-pager"></i>
                                </div>
                                <div class="mr-5">Transaction History</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="{{ route('transaction') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="col-xl-4 col-sm-6 mb-4">
                        <div class="card text-white bg-warning o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa-users"></i>
                                </div>
                                <div class="mr-5">User Management</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="{{url('users')}}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-4">
                        <div class="card text-white bg-success o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa-comments"></i>
                                </div>
                                <div class="mr-5">Comments</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="#">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-4">
                        <div class="card text-white bg-danger o-hidden h-100">
                            <div class="card-body">
                                <div class="card-body-icon">
                                    <i class="fas fa-fw fa-list"></i>
                                </div>
                                <div class="mr-5">Pages</div>
                            </div>
                            <a class="card-footer text-white clearfix small z-1" href="{{ url('custompage') }}">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        <!-- </div> -->
    </div>
</div>
@endsection