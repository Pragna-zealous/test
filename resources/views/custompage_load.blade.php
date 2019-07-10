@extends('layouts.app_front')

@section('content')
    
    <div class="container cms-pages">
        <h2 class="title_center">{{ $customdata['title'] }}</h2>
        <div class="page_description">
            <?php echo $customdata['description']; ?>
        </div>
        <div class="clr"></div>
    </div>
       
@endsection