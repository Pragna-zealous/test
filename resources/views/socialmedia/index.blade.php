@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Social Media Management</li>
</ol>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">Social Media Listing <a class="header_btn btn btn-sm btn-primary" href="{{ url('socialmedia/create') }}">Add New</a></div>
            
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
                                <th>Icon</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($socialmedias as $socialmedia)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            @if(!empty($socialmedia->icon))
                                                <img src="{{ url('public/uploads').'/'.$socialmedia->icon }}" style="width: 40px; height: 40px; border-radius: 50%;">
                                            @endif
                                        </td>
                                        <td>{{$socialmedia->title}}</td>
                                        <td>{{$socialmedia->link}}</td>
                                        
                                        <td>
                                            <a href="{{route('socialmedia.edit',$socialmedia->id)}}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-fw fa-edit"></i></a>
                                            
                                            {{Form::open([ 'method'  => 'delete','class'=>'destroy_form', 'route' => [ 'socialmedia.destroy', $socialmedia->id ] ])}}
                                                @csrf
                                                <button class="delete_page btn btn-danger btn-sm" title="Delete" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span><i class="fas fa-fw fa-trash"></i></button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection