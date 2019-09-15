<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
<h2>Hello {{$company->created_by->first_name}} {{$company->created_by->last_name}}</h2>
{{--<h2>Welcome to the site {{$company['name']}}</h2>--}}
<br/>
{{$company['token']}}
Your new company "{{$company['name']}}", has been added successfully.To verify please <a href="{{url('company/verify', $company->verifyCompany->token)}}">click here</a>  or below link.
<br/>
<a href="{{url('company/verify', $company->verifyCompany->token)}}">Verify Email</a>

<div style="margin-top: 30px;">
    Regards, <br>
    workype
</div>
</body>
</html>
