<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title> @yield('title') - Workype</title>
    <?php /*<link rel="icon" href="{{config('constants.base_url')}}/webicosoft-assets/uploads/favicon/{{get_favicon()}}" type="image/gif" sizes="16x16">*/?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- <link href="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" /> -->
    <!-- END THEME LAYOUT STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{config('constants.base_url')}}/webicosoft-assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" type="text/css" href="{{config('constants.base_url')}}/webicosoft-assets/webicosoft/webicosoft.css">


</head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN : LOGIN PAGE 5-1 -->
<div class="user-login-5">
    <div class="row bs-reset">
        <div class="col-md-6 bs-reset mt-login-5-bsfix">
            <div class="login-bg" style="background-image:url({{config('constants.base_url')}}/webicosoft-assets/pages/img/login/bg1.jpg)">
                <img class="login-logo" src="{{config('constants.base_url')}}/webicosoft-assets/pages/img/logo-big.png" /> </div>
        </div>
        <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">

           <!-- Header Starts -->
            <div class="login-5-top col-sm-12">
                <nav class="top-nav">
                    <a href="javascript:;">Home</a>
                    <a href="javascript:;">About</a>
                    <a href="javascript:;">Contact</a>
                </nav>

                    @if(url('register') == url()->current() || url('password/reset') == url()->current()  )
                    <a href="{{url('login')}}"    class="btn pull-right">Sign in</a>
                    @endif

                    @if(url('login') == url()->current() || url('password/reset') == url()->current() )
                    <a href="{{url('register')}}"   class="btn pull-right">Sign Up</a>
                    @endif

                    @if (Auth::check())
                    <a href="{{url('logout')}}"   class="btn pull-right">Logout</a>
                    @endif

            </div>
            <!-- Header Ends Here-->


            <!-- Content area starts here -->
            <div class="login-content">
                <h3>Workype’s goal is to provide you and enterprise with the best business platform for new business opportunity and success.</h3>

                @yield('content')


            </div>
            <!-- Content area ends here -->


            <!-- Footer starts here-->
            <div class="login-footer">
                <div class="row bs-reset">
                    <div class="col-xs-5 bs-reset">
                        <ul class="login-social">
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-dribbble"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-7 bs-reset">
                        <div class="login-copyright text-right">
                            <p>Copyright &copy; Workype 2018</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Footer ends  here-->

        </div>
    </div>
</div>
<!-- END : LOGIN PAGE 5-1 -->
<!--[if lt IE 9]>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/respond.min.js"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/excanvas.min.js"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- <script src="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
  <script src="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script> -->
<!-- END THEME LAYOUT SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!--<script src="{{config('constants.base_url')}}/webicosoft-assets/pages/scripts/login-5.min.js" type="text/javascript"></script>-->
<!-- END PAGE LEVEL SCRIPTS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/webicosoft/webicosoft.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/webicosoft/custom.js" type="text/javascript"></script>

</body>

</html>