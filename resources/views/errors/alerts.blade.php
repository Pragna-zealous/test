@if(isset($errors))
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div id="all_errors">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br/>
                @endforeach
            </div>
        </div>
    @endif
@endif

@if(Session::has('flash_success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div id="flashsuccess">
            {!! nl2br(Session::get('flash_success')) !!}
        </div>
    </div>
@endif

@if(Session::has('flash_error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div id="flash_error">
            {!! nl2br(Session::get('flash_error')) !!}
        </div>
    </div>
@endif
