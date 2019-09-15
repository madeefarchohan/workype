@section('header')
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Workype | Home</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #3 for " name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="webicosoft-assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="webicosoft-assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="webicosoft-assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="webicosoft-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="webicosoft-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="webicosoft-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="webicosoft-assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="webicosoft-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- <link href="webicosoft-assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="webicosoft-assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="webicosoft-assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- END THEME LAYOUT STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="webicosoft-assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" type="text/css" href="webicosoft-assets/webicosoft/webicosoft.css">
</head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN : LOGIN PAGE 5-1 -->
<div class="user-login-5">
    <div class="row bs-reset">
        <div class="col-md-6 bs-reset mt-login-5-bsfix">
            <div class="login-bg" style="background-image:url(webicosoft-assets/pages/img/login/bg1.jpg)">
                <img class="login-logo" src="webicosoft-assets/pages/img/logo-big.png" /> </div>
        </div>
    
        <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
            <div class="login-5-top col-sm-12">
                <nav class="top-nav">
                    <a href="javascript:;">Home</a>
                    <a href="javascript:;">About</a>
                    <a href="javascript:;">Contact</a>
                </nav>
                @if($_SERVER['REQUEST_URI']=='/workype/SignUp')
                <a href="{{url('SignIn')}}" id="login-form" class="btn pull-right">Sign in</a>
                @endif
                @if($_SERVER['REQUEST_URI']=='/workype/SignIn')
                <a href="{{url('SignUp')}}" id="register-form" class="btn pull-right">Sign Up</a>
                @endif
            </div>
            @endsection
            @yield('header')
            
            
            
            
            
            
            
            