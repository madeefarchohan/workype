<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
<h2>Welcome to the site {{$user['first_name']}} {{$user['last_name']}}</h2>
<br/>
Your have been registered on workype, Now please click on the below link to verify your email account
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email</a>

<div style="margin-top: 30px;">
    Regards, <br>
    workype
</div>
</body>
</html>
