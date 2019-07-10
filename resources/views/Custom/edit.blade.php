@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ url('custompage') }}">CMS Pages</a>
    </li>
    <li class="breadcrumb-item active">Edit Custom Page</li>
    @php $title = 'Edit Custom Page'; @endphp
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
                {!! Form::open(array('route' => array('custompage.update', $editData->id),'files' => true)) !!}
        
                    @method('PATCH')
                    
                    <div class="form-group row">
                        {!! Form::label('title', 'Title*', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-6">
                            {!! Form::text('title', $editData->title, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        {!! Form::label('description', 'Description*', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description', $editData->description, ['class' => 'form-control ckeditor'],['id' => 'messageArea']) !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('banner_image', 'Banner Image', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                        <div class="col-md-6">
                            {!! Form::file('banner_image', null, ['class' => 'form-control']) !!}
                        </div>
                        @error('title')
                            <div class="alert-danger">{{ $message }}</div>
                        @enderror

                        @if($editData['banner_image'])
                            {!! Form::hidden('banner_image_hidden', $editData['banner_image'],['class' => 'form-control banner_image col-md-4 col-form-label text-md-right']) !!}
                            <div class="banner_image_section">
                                <img src="{{ url('public/uploads/CMS').'/'.$editData['banner_image'] }}" style="width: 40px; height: 40px; border-radius: 50%;" class="banner_image_preview" title="Remove">
                                <a class="fa fa-close delete_banner pointer" aria-hidden="true" hrefpath="{{ url('destroy_image/'.$editData['id']) }}" title="Remove">x</a>
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group row">
                    {!! Form::hidden('author_id', '1',['class' => 'form-control']) !!}
                    </div>
                    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                        {!! Form::button('Cancel', ['class' => 'btn btn-danger', 'onclick' => 'window.location="'.url('/custompage').'" ']) !!}
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