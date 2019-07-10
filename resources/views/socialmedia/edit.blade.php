@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    
        <li class="breadcrumb-item">
            <a href="{{ url('users') }}">User Management</a>
        </li>
        <li class="breadcrumb-item active">Edit Social Media</li>
    </ol>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">Edit Social Media</div>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

           <div class="card-body">
                    
                    {!! Form::model($mediadata, ['method' => 'PATCH','route' => ['socialmedia.update', $mediadata->id],'files' => 'true'
                        ]) !!}
                    @csrf
                   

                    <div class="form-group row">
                        <label for="profile_image" class="col-md-4 col-form-label text-md-right">Icon</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="icon" name="icon" value=""/>
                        </div>
                        @if($mediadata->icon)
                            <div class="profile_image_section">
                                <input type="hidden" class="icon" value="{{$mediadata->icon}}" name="profile_image_hidden">
                                <img title="Remove" src="{{ url('public/uploads/').'/'.$mediadata->icon }}" style="width: 40px; height: 40px; border-radius: 50%;" class="profile_image_preview">
                                <a title="Remove" class="text-danger fa fa-close delete_profile_image pointer" aria-hidden="true" hrefpath="{{ url('destroy_profile_image/'.$mediadata->icon) }}">x</a>
                            </div>
                        @endif
                    </div>

                   
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label text-md-right">Title*</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{$mediadata->title}}" required />
                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="link" class="col-md-4 col-form-label text-md-right">Link*</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="link" name="link" placeholder="Enter URL" value="{{$mediadata->link}}" required />
                           
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{url('socialmedia')}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection