<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
  <meta charset="utf-8" />
  <title>Workype | Register Company</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta content="Preview page of Metronic Admin Theme #3 for " name="description" />
  <meta content="" name="author" />
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
  <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
  <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
  <!-- END GLOBAL MANDATORY STYLES -->
  <!-- BEGIN PAGE LEVEL PLUGINS
  <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />-->
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL STYLES -->
  <link href="{{config('constants.base_url')}}/webicosoft-assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
  <link href="{{config('constants.base_url')}}/webicosoft-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
  <!-- END THEME GLOBAL STYLES -->
  <!-- BEGIN THEME LAYOUT STYLES -->
  <link href="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
  <link href="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
  <link href="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" />
  <!-- END THEME LAYOUT STYLES -->
  <!-- BEGIN PAGE LEVEL STYLES -->
  <!-- END PAGE LEVEL STYLES -->
  <link rel="shortcut icon" href="favicon.ico" />
  <link rel="stylesheet" type="text/css" href="{{config('constants.base_url')}}/webicosoft-assets/webicosoft/webicosoft.css">
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-header-top-fixed">
<div class="page-wrapper">
  <div class="page-wrapper-row">







    <div class="page-wrapper-top">
      <!-- BEGIN HEADER -->
      <div class="page-header">
        <!-- BEGIN HEADER TOP -->
        <div class="page-header-top">
          <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
              <a href="{{config('constants.base_url')}}">
                <img src="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/img/logo-default.png" alt="logo" class="logo-default">
              </a>
            </div>
            <!-- END LOGO -->
            <nav class="top-nav">
              <a href="javascript:;">Home</a>
              <a href="javascript:;">About</a>
              <a href="javascript:;">Contact</a>
            </nav>
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->

            @if (!Auth::check())
            <!-- BEGIN TOP FORM -->
            <form class="form-inline login-top" role="form" method="post" action="{{ route('login') }}">
              @csrf
              <div class="form-group">
                <label class="sr-only" for="email">Email address</label>
                <div class="input-icon">
                  <i class="fa fa-envelope"></i>
                  <input type="email" class="form-control btn-circle" id="email" name="email" placeholder="Enter email" required>
                </div>
              </div>
              <div class="form-group">
                <label class="sr-only" for="password">Password</label>
                <div class="input-icon">
                  <i class="fa fa-user"></i>
                  <input type="password" class="form-control btn-circle" id="password" name="password" placeholder="Password" required>
                </div>
              </div>
              {{--<a href="forgot.html">Forgot password?</a>--}}
              <button type="submit" class="btn btn-primary btn-circle">Sign in</button>
            </form>
            <!-- END TOP FORM -->
            @else
                <nav class="  pull-right">
                  <a href="{{url('logout')}}" style="padding-top: 23px;"   class="btn pull-right">Logout</a>
                </nav>


              @endif





          </div>
        </div>
        <!-- END HEADER TOP -->
      </div>
      <!-- END HEADER -->
    </div>

















  </div>
  <div class="page-wrapper-row full-height workype-form bg-1">
    <div class="page-wrapper-middle">





      <!-- BEGIN CONTAINER -->
       @yield('content')
      <!-- END CONTAINER -->







    </div>
  </div>
  <div class="page-wrapper-row">
    <div class="page-wrapper-bottom">
      <!-- BEGIN FOOTER -->

     <div class="footer">

        <!-- BEGIN PRE-FOOTER -->
        {{--<div class="page-prefooter">--}}
          {{--<div class="container">--}}
            {{--<div class="row">--}}
              {{--<div class="col-md-3 col-sm-6 col-xs-12 footer-block">--}}
                {{--<h2>About</h2>--}}
                {{--<p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam dolore. </p>--}}
              {{--</div>--}}
              {{--<div class="col-md-3 col-sm-6 col-xs12 footer-block">--}}
                {{--<h2>Subscribe Email</h2>--}}
                {{--<div class="subscribe-form">--}}
                  {{--<form action="javascript:;">--}}
                    {{--<div class="input-group">--}}
                      {{--<input type="text" placeholder="mail@email.com" class="form-control">--}}
                      {{--<span class="input-group-btn">--}}
                            {{--<button class="btn" type="submit">Submit</button>--}}
                          {{--</span>--}}
                    {{--</div>--}}
                  {{--</form>--}}
                {{--</div>--}}
              {{--</div>--}}
              {{--<div class="col-md-3 col-sm-6 col-xs-12 footer-block">--}}
                {{--<h2>Follow Us On</h2>--}}
                {{--<ul class="social-icons">--}}
                  {{--<li>--}}
                    {{--<a href="javascript:;" data-original-title="rss" class="rss"></a>--}}
                  {{--</li>--}}
                  {{--<li>--}}
                    {{--<a href="javascript:;" data-original-title="facebook" class="facebook"></a>--}}
                  {{--</li>--}}
                  {{--<li>--}}
                    {{--<a href="javascript:;" data-original-title="twitter" class="twitter"></a>--}}
                  {{--</li>--}}
                  {{--<li>--}}
                    {{--<a href="javascript:;" data-original-title="googleplus" class="googleplus"></a>--}}
                  {{--</li>--}}
                  {{--<li>--}}
                    {{--<a href="javascript:;" data-original-title="linkedin" class="linkedin"></a>--}}
                  {{--</li>--}}
                  {{--<li>--}}
                    {{--<a href="javascript:;" data-original-title="youtube" class="youtube"></a>--}}
                  {{--</li>--}}
                  {{--<li>--}}
                    {{--<a href="javascript:;" data-original-title="vimeo" class="vimeo"></a>--}}
                  {{--</li>--}}
                {{--</ul>--}}
              {{--</div>--}}
              {{--<div class="col-md-3 col-sm-6 col-xs-12 footer-block">--}}
                {{--<h2>Contacts</h2>--}}
                {{--<address class="margin-bottom-40"> Phone: 800 123 3456--}}
                  {{--<br> Email:--}}
                  {{--<a href="mailto:info@workype.com">info@workype.com</a>--}}
                {{--</address>--}}
              {{--</div>--}}
            {{--</div>--}}
          {{--</div>--}}
        {{--</div>--}}
        <!-- END PRE-FOOTER -->

        <!-- BEGIN INNER FOOTER -->
        <div class="page-footer">
          <div class="container">
            <a target="_blank" href="http://workype.com">Workype.com</a>  &copy; 2017, All rights reserved. &nbsp;|&nbsp;
            Various trademarks held by their respective owners.
          </div>
        </div>
        <div class="scroll-to-top">
          <i class="icon-arrow-up"></i>
        </div>
        <!-- END INNER FOOTER -->
    </div>

      <!-- END FOOTER -->




    </div>
  </div>
</div>
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script>
<script src="assets/global/plugins/ie8.fix.min.js"></script>
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
<!-- <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script> -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/webicosoft/webicosoft.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>