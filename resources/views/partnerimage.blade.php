
@extends('layouts.app')

@section('content')

  
<style>
    .draggable img{
        width: 100px;
        height: 100px;
    }
    .item {
        position:relative;
        padding-top:20px;
        display:inline-block;
        margin-left: 10px;
    }
    .notify-badge {
        position: absolute;
        right: -5px;
        top: 10px;
        background: #dc3545;
        text-align: center;
        border-radius: 40px;
        color: white;
        padding: 2px;
        font-size: 10px;
        height: 20px;
        width: 20px;
    }
    .droppable .imageThumb {
        border: 1px solid;
        cursor: move;
    }
    .field.droppable.ui-sortable {
        min-height: 332px;
        width: 100%;
        border: 1px dashed #8c8a8a;
        margin-top: 15px;
    }
 
</style>

<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">
            <div class="card-header">Upload Partner Images</div>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card-body">
            <?php $user = auth()->user(); ?>
            {!! Form::open(array('url' => '/store_partner_images', 'class' => "form-horizontal",'files' => true, 'enctype' => 'multipart/form-data')) !!}
            @csrf
            <input type="hidden" value="{{ count($images) }}" name="total_count" id="total_count">
            <!-- <div class="form-group row">
                {!! Form::label('partner_images', 'Partner Images', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-6">
                    <input type="file" name="partner_images" multiple>
                </div>
            </div> -->
            <input type="file" id="files" name="files[]" multiple/ value="{{ $images }}">
            <div class="field droppable" align="left">
                @if(!empty($images))
                    @php 
                        $i=1;
                    @endphp
                    @foreach($images as $image)
                        @php
                            $name=$image['image_name'];
                            $id=$image['id'];
                        @endphp
                            <span class="pip draggable item">
                                <img class="imageThumb" src="{{ url('public/uploads').'/Partners/'.$name }}" title="" />
                                <input type="hidden" name="stored_image_id_{{$i}}" class="stored_image_id" value="{{ $id }}">
                                <input type="hidden" name="url" class="url" value="{{url('ajaxRequestPartner')}}">
                                <br/><span class="remove notify-badge">X</span>
                            </span>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @endif
            </div>
            
            <div class="form-group row">
            {!! Form::hidden('author_id', $user->id,['class' => 'form-control']) !!}
            </div>
            
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                {!! Form::button('Cancel', ['class' => 'btn btn-danger', 'onclick' => 'window.location="'.url('/partner_images').'" ']) !!}
                </div>
            </div>

            {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script> -->

  
@endsection