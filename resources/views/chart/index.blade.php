@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Chart Settings</li>
</ol>

<div class="row justify-content-center">
    <div class="col-md-12">
       <div class="response_message">
        @include('errors.alerts')
        </div>
        <div class="card">
            <div class="card-header">Chart Settings</div>
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card-body">
                @csrf
                @php 
                    $count = 1;
                @endphp
                <div class="col-sm-9">
                <table class="table table-bordered lhs_rhs" id="chart_table">
                    <input type="hidden" id="pie_count" value="<?php echo $count;?>">
                    <tbody>
                        <tr class="pie" style="">
                            <th width="15%"></th>
                            <th width="27%">Title</th>
                            <th width="28%">Legend</th>
                            <th width="30%">Value</th>
                            <th width="30%">Colour</th>
                        </tr>
                        @php 
                        if(count($Chartdata) > 0){
                            foreach($Chartdata as $data){
                        @endphp
                        <tr id="pie<?php echo $count;?>" class="tr_values">
                            <td>
                                @php
                                if($count > 1){
                                @endphp
                                    <a class="text-danger pointer" onclick="remove_pie($(this));" ><i class="fa fa-close"></i> Remove</a>
                                @php
                                }
                                @endphp
                            </td>
                            <td>
                                <input type="text" name="title_<?php echo $count;?>" class="form-control title" id="title_<?php echo $count;?>" placeholder="Title" value="<?php echo $data['title']; ?>">
                            </td>
                            <td>
                                <input type="text" name="legend_<?php echo $count;?>" class="form-control legend" id="legend_<?php echo $count;?>" placeholder="Legend" value="<?php echo $data['legend']; ?>">
                            </td>
                            <td>
                                <input type="text" name="value_<?php echo $count;?>" id="value_<?php echo $count;?>" class="form-control value" placeholder="Value" value="<?php echo $data['value']; ?>">
                            </td>
                            <td>
                                <input type="color" class="form-control colour" id="color_<?php echo $count;?>" name="color_<?php echo $count;?>" placeholder="Select Color" value="<?php echo $data['color']; ?>"/>
                            </td>
                        </tr>
                        @php 
                            $count++;
                            }
                        }else{
                        @endphp
                        <tr id="pie<?php echo $count;?>" class="tr_values">
                            <td>
                            </td>
                            <td>
                                <input type="text" name="title_<?php echo $count;?>" class="form-control title" id="title_<?php echo $count;?>" placeholder="Title">
                            </td>
                            <td>
                                <input type="text" name="legend_<?php echo $count;?>" class="form-control legend" id="legend_<?php echo $count;?>" placeholder="Legend">
                            </td>
                            <td>
                                <input type="text" name="value_<?php echo $count;?>" id="value_<?php echo $count;?>" class="form-control value" placeholder="Value">
                            </td>
                            <td>
                                <input type="color" class="form-control colour" id="color_<?php echo $count;?>" name="color_<?php echo $count;?>" placeholder="Select Color"/>
                            </td>
                        </tr>
                        @php    
                        }
                        @endphp
                        <tr class="gray_bg add_pie" style="">
                            <td colspan="5">
                                <span class="col-sm-12">
                                    <button id="add_pie" onclick="add_pie();" class="btn btn-default" style="width: 100%;"> <i class="fa fa-plus-circle"></i> Add Row</button>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary save_chart_data">
                            Save
                        </button>
                        <a href="{{ url('users') }}" class="btn btn-danger">
                            Cancel
                        </a>
                        <input type="hidden" class="url" value="{{url('ajaxRequest')}}">
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection