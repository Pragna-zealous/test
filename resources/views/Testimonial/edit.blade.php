@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('testimonial') }}">Testimonial</a>
    </li>
    <li class="breadcrumb-item active">Edit Testimonial</li>
    @php $title = 'Edit Testimonial'; @endphp
</ol>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">{{$title}}</div>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-body">
                @if(isset($Userdata) && $Userdata)
                    {!! Form::model($user_data, [
                        'method' => 'PATCH',
                        'route' => ['users.update', $user_data->id]
                    ]) !!}
                @else
                <?php $user = auth()->user(); ?>
                    {!! Form::open(array('route' => array('testimonial.update', $editData->id),'files' => 'true')) !!}
                    
                    @method('PATCH')
                    

                    <div class="form-group row">
                        {!! Form::label('user_name', 'Name*', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-6">
                            {!! Form::text('user_name', $editData->user_name, ['class' => 'form-control']) !!}
                        </div>
                        @error('user_name')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group row">
                        {!! Form::label('designation', 'Designation', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-6">
                            {!! Form::text('designation', $editData->user_designation, ['class' => 'form-control ckeditor']) !!}
                        </div>
                        @error('designation')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group row">
                        {!! Form::label('user_image', 'Image', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-6">
                            {!! Form::file('user_image', null, ['class' => 'form-control']) !!}
                        </div>
                        @error('user_image')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror

                        @if($editData['user_image'])
                        {!! Form::hidden('user_image_hidden', $editData['user_image'],['class' => 'form-control user_image']) !!}
                        <div class="user_image_section">
                            <img src="{{ url('public/uploads').'/Testimonials/'.$editData['user_image'] }}" style="width: 40px; height: 40px; border-radius: 50%;" class="user_image_preview" title="Remove">
                            <a class="text-danger fa fa-close delete_user_image pointer" aria-hidden="true" hrefpath="{{ url('destroy_image/'.$editData['id']) }}" title="Remove">x</a>
                        </div>
                        @endif
                    </div>
                    
                    <div class="form-group row">
                        {!! Form::label('description', 'Description*', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description', $editData->description, ['class' => 'form-control ckeditor'],['id' => 'messageArea']) !!}
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
                        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                        {!! Form::button('Cancel', ['class' => 'btn btn-danger', 'onclick' => 'window.location="'.url('/testimonial').'" ']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}
                @endif
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