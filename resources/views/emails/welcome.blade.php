<!DOCTYPE html>
<html>
    <head>
        <title>Welcome Email</title>
    </head>

    <body>
        <h2>Welcome to the site {{$user['name']}}</h2>
        <br/>
            Your registered email-id is {{$user['email']}}
            Your login credentials are as below:
            Email Address: {{$user['email']}}
            Password: {{$password}}
        <br/>
            @php
            $str = base64_encode('email='.$user['email'].'&password='.$password.'&&id='.$user['id']);
            @endphp
            please click on below link to activate your account.
        <br/>
        <a href="{{url(config('app.url').'/verify_email?account='.$str)}}">Click Here</a>
    </body>

</html>