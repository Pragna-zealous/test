@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Pages</li>
</ol>

<h5><span>Pages: </span>
<a href="{{ url('custompage') }}" class="{{ (Request::is('custompage') || Request::is('custompage/create') || Request::route()->getName()=='custompage.edit' ) ? 'active' : '' }}">CMS Pages</a> <span class="divider">|</span>
<a href="{{ url('testimonial') }}" class="{{ (Request::is('testimonial') || Request::is('testimonial/create') || Request::route()->getName()=='testimonial.edit' ) ? 'active' : '' }}">Testimonial</a> <span class="divider">|</span>
<a href="{{ url('partner_images') }}" class="{{ (Request::is('partner_images') || Request::route()->getName()=='partner_images' ) ? 'active' : '' }}">Partners</a> <span class="divider">|</span>
<a href="{{ url('programme_images') }}" class="{{ (Request::is('testimonial') || Request::is('testimonial/create') || Request::route()->getName()=='testimonial.edit' ) ? 'active' : '' }}">Programme</a>
</h5>

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">Testimonial <a class="header_btn btn btn-sm btn-primary" href="{{ route('testimonial.create') }}">Add New</a></div>
            
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
                            <th>User Name</th>
                            <th>Description</th>
                            <th>Designation</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                        @if(!$pagedata->isEmpty())
                            @foreach($pagedata as $pgdata)
                            <tr>
                                <td>{{$i++}}</td>
                                <td class="center">
                                    @if(!empty($pgdata['user_image']))
                                        <img title="Remove" src="{{ url('public/uploads').'/Testimonials/'.$pgdata['user_image'] }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                        <a title="Remove" class="text-danger listing_image_delete pointer" aria-hidden="true" hrefpath="{{ url('destroy_user_image/'.$pgdata['id']) }}">x</a>
                                    @else
                                        <img src="{{ url('public/images/user_placeholder.png') }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                    @endif
                                </td>
                                <td>{{ $pgdata['user_name'] }}</td>
                                <td><?php echo str_limit(strip_tags($pgdata['description']),50); ?> </td>
                                <td>{{ $pgdata['user_designation'] }}</td>
                                <td>
                                    <button type="button" title="Edit" class="btn btn-warning btn-sm" onclick="window.location='{{ URL::to('testimonial/'.$pgdata['id'].'/edit') }}'"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span><i class="fas fa-fw fa-edit"></i></button>
                                    
                                    <form action="{{route('testimonial.destroy',$pgdata['id'])}}" method="POST" class="destroy_form">
                                        @method('DELETE')
                                        @csrf
                                        <button class="delete_page btn btn-danger btn-sm" title="Delete" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span><i class="fas fa-fw fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr><td colspan="5" class="center">No record found</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection