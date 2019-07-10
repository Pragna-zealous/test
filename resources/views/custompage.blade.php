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
<a>Partners</a>
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
            <div class="card-header">CMS Pages <a class="header_btn btn btn-sm btn-primary" href="{{ route('custompage.create') }}">Add New</a></div>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive" id="table-scroll">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                            <th>S/N</th>
                            <th>Banner Image</th>
                            <th>Title</th>
                            <th>Description</th>
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
                                    @if(!empty($pgdata['banner_image']))
                                        <img title="Remove" src="{{ url('public/uploads/CMS').'/'.$pgdata['banner_image'] }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                        <a title="Remove" class="text-danger fa fa-close listing_image_delete pointer" aria-hidden="true" hrefpath="{{ url('destroy_banner_image/'.$pgdata['id']) }}">x</a>
                                    @endif
                                </td>
                                <td>{{ $pgdata['title'] }}</td>
                                <td><?php echo str_limit(strip_tags($pgdata['description']),50); ?> </td>
                                <td>
                                    <button type="button" title="Edit" class="btn btn-warning btn-sm" onclick="window.location='{{ URL::to('custompage/'.$pgdata['id'].'/edit') }}'">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        <i class="fas fa-fw fa-edit"></i>
                                    </button>
                                    <form action="{{route('custompage.destroy',$pgdata['id'])}}" method="POST" class="destroy_form">
                                        @method('DELETE')
                                        @csrf
                                        <button class="delete_page btn btn-danger btn-sm" title="Delete" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span><span><i class="fas fa-fw fa-trash"></i></button>
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
<script>
    /*CKEDITOR.replace( 'messageArea',
    {
        customConfig : 'config.js',
        toolbar : 'simple'
    })*/
</script>