@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Front Settings</li>
</ol>

<h5><span>Settings: </span>
<a href="{{ url('custompage') }}" class="">Donation</a>
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
            {!! Form::open(array('url' => '/donation_save', 'class' => "form-horizontal settings_form",'files' => true)) !!}
            
	            <div class="card-body">
	                <div class="table-responsive" id="table-scroll">
	                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
	                        <thead>
	                            <tr>
	                            <th>S/N</th>
	                            <th>Section Name</th>
	                            <th>CMS Page</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        @php $i=1; @endphp
	                        	<tr>
	                        		<td>1</td>
	                        		<td>Donation Banner</td>
	                        		<input type="hidden" name="title" value="Donation Banner">
	                        		<td>
	                        			@php
	                        			$title_values = DB::table('custom_pages')->select('title', 'id')->get();
	                        			@endphp
	                        			<select name="donation_banner">
	                        				@foreach ($title_values as $user)
											    <option  value="donation_banner##{{ $user->id}}">{{ $user->title}}</option>
											@endforeach
	                        			</select>
	                        		</td>
	                        	</tr>
	                        	<tr>
	                        		<td>2</td>
	                        		<td>Donation Sub Banner</td>
	                        		<td>
	                        			@php
	                        			$title_values = DB::table('custom_pages')->select('title', 'id')->get();
	                        			@endphp
	                        			<select name="donation_sub_banner">
	                        				@foreach ($title_values as $user)
											    <option  value="donation_sub_banner##{{ $user->id}}">{{ $user->title}}</option>
											@endforeach
	                        			</select>
	                        		</td>
	                        	</tr>
	                        	<tr>
	                        		<td>3</td>
	                        		<td>Rs 34 a day</td>
	                        		<td>
	                        			@php
	                        			$title_values = DB::table('custom_pages')->select('title', 'id')->get();
	                        			@endphp
	                        			<select name="rs_34_a_day">
	                        				@foreach ($title_values as $user)
											    <option  value="rs_34_a_day##{{ $user->id}}">{{ $user->title}}</option>
											@endforeach
	                        			</select>
	                        		</td>
	                        	</tr>
	                        	<tr>
	                        		<td>4</td>
	                        		<td>Donations are exempted from tax</td>
	                        		<td>
	                        			@php
	                        			$title_values = DB::table('custom_pages')->select('title', 'id')->get();
	                        			@endphp
	                        			<select name="donations_are_exempted_from_tax">
	                        				@foreach ($title_values as $user)
											    <option value="donations_are_exempted_from_tax##{{ $user->id}}">{{ $user->title}}</option>
											@endforeach
	                        			</select>
	                        		</td>
	                        	</tr>
	                        </tbody>
	                    </table>
	                    <input type="submit" class="btn btn-primary">
	                </div>
	            </div>

            {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


<div class="row justify-content-center">
    <div class="col-md-12">
        @include('errors.alerts')

        <div class="card">            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
        </div>
    </div>
</div>
@endsection