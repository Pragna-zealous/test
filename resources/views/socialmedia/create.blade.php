@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('users') }}">Social Media Management</a>
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
                {!! Form::open(array('url' => '/socialmedia', 'class' => "form-horizontal",'files' => true,'autocomplete'=>'off')) !!}
                    @csrf
                    <div class="form-group row">
                        <label for="icon" class="col-md-4 col-form-label text-md-right">Icon*</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="icon" name="icon" value=""/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label text-md-right">Title*</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" required />
                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="link" class="col-md-4 col-form-label text-md-right">Link*</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="link" name="link" placeholder="Enter URL" value="" required />
                           
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