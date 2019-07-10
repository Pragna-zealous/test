@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Mass Communication</li>
</ol>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card-body">
                    <?php $user = auth()->user(); ?>
                {!! Form::open(array('url' => '/masscommunication_send', 'class' => "form-horizontal settings_form",'files' => true)) !!}

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
                    {!! Form::label('all_users', 'All User', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                    <div class="col-md-6">
                        {!! Form::radio('radio', 'all_users', false, ['class' => 'radio-box-users']) !!}
                    </div>
                    {!! Form::label('specified_user', 'Specified User', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                    <div class="col-md-6">
                        {!! Form::radio('radio', 'specified_user', false, ['class' => 'radio-box-users']) !!}
                    </div>
                </div>

                <div class="all_user display-none">
                    <p>{{$all_users}} Records Found</p>
                </div>
                
                <div class="specified_user display-none">
                    <input class="form-control" id="tags" type="text">
                    <input type="hidden" class="tags_id">
                    <button type="button" class="add_specified_user" data-selected="">+Add</button>
                </div>

                <div class="specified_users">
                </div>
                
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                    {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
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