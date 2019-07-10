@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Menu Setting</li>
</ol>

<h5><span>Setting: </span>
<a href="{{ url('headersetting') }}" class="{{ (Request::is('headersetting')) ? 'active' : '' }}">Header</a> <span class="divider">|</span>
<a href="{{ url('footersetting') }}" class="{{ (Request::is('footersetting')) ? 'active' : '' }}">Footer</a> <span class="divider">|</span>
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
            <!-- <div class="card-header"></div> -->
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card-body">
	            <?php $user = auth()->user(); ?>
	            {!! Form::open(array('url' => '/menuheadersetting', 'class' => "form-horizontal settings_form",'files' => true)) !!}
            
	            <div class="card-body">
	                <div >
					                 
	                     <div class="form-group row">
	                     	{!! Form::label('', 'No', ['class' => 'col-md-2 col-form-label']) !!}
	                        {!! Form::label('', 'Name', ['class' => 'col-md-4 col-form-label']) !!}
	                        {!! Form::label('', 'Title', ['class' => 'col-md-4 col-form-label']) !!}
	                    </div>                
	                    
	                    <div class="form-group row">
	                    	{!! Form::label('', '1', ['class' => 'col-md-2 col-form-label']) !!}
		                    {!! Form::label('', 'About Us', ['class' => 'col-md-3 col-form-label']) !!}
		                    {!! Form::hidden('id[]', $menuData[0]->id, ['class' => 'col-md-3 col-form-label']) !!}
		                    {!! Form::hidden('name[]', 'About Us', ['class' => 'form-control col-md-4']) !!}
		                    {!! Form::text('title[]', $menuData[0]->title, ['class' => 'form-control col-md-4']) !!}
	                    </div>
	                    
	                    <div class="form-group row">
	                    	{!! Form::label('', '2', ['class' => 'col-md-2 col-form-label']) !!}
		                    {!! Form::label('My Profile', 'My Profile', ['class' => 'col-md-3 col-form-label']) !!}
		                    {!! Form::hidden('id[]', $menuData[1]->id, ['class' => 'col-md-3 col-form-label']) !!}
		                    {!! Form::hidden('name[]', 'My Profile', ['class' => 'form-control col-md-4']) !!}
		                    {!! Form::text('title[]', $menuData[1]->title, ['class' => 'form-control col-md-4']) !!}
	                    </div>
	                    <div class="form-group row">
	                    	{!! Form::label('', '3', ['class' => 'col-md-2 col-form-label']) !!}
		                    {!! Form::label('Donate', 'Donate', ['class' => 'col-md-3 col-form-label']) !!}
		                    {!! Form::hidden('id[]', $menuData[2]->id, ['class' => 'col-md-3 col-form-label']) !!}
		                    {!! Form::hidden('name[]', 'Donate', ['class' => 'form-control col-md-4']) !!}
		                    {!! Form::text('title[]', $menuData[2]->title, ['class' => 'form-control col-md-4']) !!}
	                    </div>
					               
						
					</div>
					<input type="submit" class="btn btn-primary">
				</div>
				{!! Form::hidden('menu', 'header', ['class' => 'form-control col-md-4']) !!}
	 			{!! Form::close() !!}
            </div>
        </div>
    </div>
</div>



@endsection