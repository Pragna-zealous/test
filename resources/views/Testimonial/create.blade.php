@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('testimonial') }}">Testimonial</a>
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
                    <?php $user = auth()->user(); ?>
                {!! Form::open(array('url' => '/testimonial', 'class' => "form-horizontal settings_form",'files' => true)) !!}
                

                <div class="form-group row">
                    {!! Form::label('user_name', 'Name*', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                    <div class="col-md-6">
                        {!! Form::text('user_name', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('designation', 'Designation', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                    <div class="col-md-6">
                        {!! Form::text('designation', null, ['class' => 'form-control ckeditor']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('user_image', 'Image', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                    <div class="col-md-6">
                        {!! Form::file('user_image', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('description', 'Description*', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                    <div class="col-md-6">
                        {!! Form::textarea('description', null, ['class' => 'form-control ckeditor'],['id' => 'messageArea']) !!}
                    </div>
                    @error('description')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group row">
                {!! Form::hidden('created_by', $user->id,['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    {!! Form::button('Cancel', ['class' => 'btn btn-danger', 'onclick' => 'window.location="'.url('/testimonial').'" ']) !!}
                    </div>
                </div>
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    CKEDITOR.replace( 'messageArea',
    {
        customConfig : 'config.js',
        toolbar : 'simple'
    })
</script>
@endpush