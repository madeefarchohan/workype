@section('headers')
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
  <meta charset="utf-8" />
  <title>Workype | Verify Company</title>
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
  <!-- BEGIN PAGE LEVEL PLUGINS 
  <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />-->
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL STYLES -->
  <link href="webicosoft-assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
  <link href="webicosoft-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
  <!-- END THEME GLOBAL STYLES -->
  <!-- BEGIN THEME LAYOUT STYLES -->
  <link href="webicosoft-assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
  <link href="webicosoft-assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
  <link href="webicosoft-assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" />
  <!-- END THEME LAYOUT STYLES -->
  <!-- BEGIN PAGE LEVEL STYLES -->
  <!-- END PAGE LEVEL STYLES -->
  <link rel="shortcut icon" href="favicon.ico" />
  <link rel="stylesheet" type="text/css" href="webicosoft-assets/webicosoft/webicosoft.css">
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
                  <img src="webicosoft-assets/layouts/layout3/img/logo-default.png" alt="logo" class="logo-default">
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
              <!-- BEGIN TOP FORM -->
              <form class="form-inline login-top" role="form">
                <div class="form-group">
                  <label class="sr-only" for="email">Email address</label>
                  <div class="input-icon">
                    <i class="fa fa-envelope"></i>
                    <input type="email" class="form-control btn-circle" id="email" placeholder="Enter email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="sr-only" for="password">Password</label>
                  <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input type="password" class="form-control btn-circle" id="password" placeholder="Password" required>
                  </div>
                </div>
                <a href="forgot.html">Forgot password?</a>
                <button type="submit" class="btn btn-primary btn-circle">Sign in</button>
              </form>
              <!-- END TOP FORM -->
            </div>
          </div>
          <!-- END HEADER TOP -->
        </div>
        <!-- END HEADER -->
      </div>
    </div>
@show