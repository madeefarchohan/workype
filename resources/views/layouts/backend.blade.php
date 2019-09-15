<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Workype | Business Agent</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Preview page of Metronic Admin Theme #3 for " name="description" />
    <meta content="" name="author" />



    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @php
        use Illuminate\Support\Facades\Request;
        $request_path = Request::path();
    @endphp
    <script>
        var base_url = "<?php echo config('constants.base_url') ?>";
    </script>




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


    <link href="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />

    <link media="all" type="text/css" rel="stylesheet" href="http://webicosoft.zeemanager.com/webicosoft-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css">
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



    <link href="{{config('constants.base_url')}}/webicosoft-assets/pages/css/chatter.css" rel="stylesheet" type="text/css" />


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
                            <a href="{{url('business-agents')}}" class="active">Business-Agent</a>
                            {{--<a href="javascript:void(0)">Convention</a>--}}
                            <a href="{{url('user/chats')}}">Chatter</a>

                            <a href="{{url('company')}}">My Companies</a>
                            <a href="{{url('company')}}/create">+Create Your Company</a>
                        </nav>

                        </nav>
                        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                        <a href="javascript:;" class="menu-toggler"></a>
                        <!-- END RESPONSIVE MENU TOGGLER -->
                        <!-- BEGIN TOP FORM -->
                        <div class="top-menu">
                            <ul class="nav navbar-nav pull-right">

                                <?php
                                /*

                                <!-- BEGIN NOTIFICATION DROPDOWN -->
                                <!-- DOC: Apply "dropdown-hoverable" class after "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                                <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                                <li class="dropdown dropdown-extended dropdown-notification"
                                    id="header_notification_bar">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                       data-hover="dropdown" data-close-others="true">
                                        <i class="icon-bell"></i>
                                        <span class="badge badge-default">7</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="external">
                                            <h3>You have
                                                <strong>12 pending</strong> tasks</h3>
                                            <a href="javascript:;">view all</a>
                                        </li>
                                        <li>
                                            <ul class="dropdown-menu-list scroller" style="height: 250px;"
                                                data-handle-color="#637283">
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">just now</span>
                                                        <span class="details">
                                  <span class="label label-sm label-icon label-success">
                                    <i class="fa fa-plus"></i>
                                  </span> New user registered. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">3 mins</span>
                                                        <span class="details">
                                    <span class="label label-sm label-icon label-danger">
                                      <i class="fa fa-bolt"></i>
                                    </span> Server #12 overloaded. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">10 mins</span>
                                                        <span class="details">
                                      <span class="label label-sm label-icon label-warning">
                                        <i class="fa fa-bell-o"></i>
                                      </span> Server #2 not responding. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">14 hrs</span>
                                                        <span class="details">
                                        <span class="label label-sm label-icon label-info">
                                          <i class="fa fa-bullhorn"></i>
                                        </span> Application error. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">2 days</span>
                                                        <span class="details">
                                          <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                          </span> Database overloaded 68%. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">3 days</span>
                                                        <span class="details">
                                            <span class="label label-sm label-icon label-danger">
                                              <i class="fa fa-bolt"></i>
                                            </span> A user IP blocked. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">4 days</span>
                                                        <span class="details">
                                              <span class="label label-sm label-icon label-warning">
                                                <i class="fa fa-bell-o"></i>
                                              </span> Storage Server #4 not responding dfdfdfd. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">5 days</span>
                                                        <span class="details">
                                                <span class="label label-sm label-icon label-info">
                                                  <i class="fa fa-bullhorn"></i>
                                                </span> System Error. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">9 days</span>
                                                        <span class="details">
                                                  <span class="label label-sm label-icon label-danger">
                                                    <i class="fa fa-bolt"></i>
                                                  </span> Storage server failed. </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <!-- END NOTIFICATION DROPDOWN -->
                                <!-- BEGIN TODO DROPDOWN -->
                                <li class="dropdown dropdown-extended dropdown-tasks " id="header_task_bar">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                       data-hover="dropdown" data-close-others="true">
                                        <i class="icon-calendar"></i>
                                        <span class="badge badge-default">3</span>
                                    </a>
                                    <ul class="dropdown-menu extended tasks">
                                        <li class="external">
                                            <h3>You have
                                                <strong>12 pending</strong> tasks</h3>
                                            <a href="javascript:;">view all</a>
                                        </li>
                                        <li>
                                            <ul class="dropdown-menu-list scroller" style="height: 275px;"
                                                data-handle-color="#637283">
                                                <li>
                                                    <a href="javascript:;">
                                                            <span class="task">
                                                      <span class="desc">New release v1.2 </span>
                                                            <span class="percent">30%</span>
                                                            </span>
                                                        <span class="progress">
                                                      <span style="width: 40%;"
                                                            class="progress-bar progress-bar-success" aria-valuenow="40"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                            </span>
                                                            </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                            <span class="task">
                                                      <span class="desc">Application deployment</span>
                                                            <span class="percent">65%</span>
                                                            </span>
                                                        <span class="progress">
                                                      <span style="width: 65%;" class="progress-bar progress-bar-danger"
                                                            aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">65% Complete</span>
                                                            </span>
                                                            </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                            <span class="task">
                                                      <span class="desc">Mobile app release</span>
                                                            <span class="percent">98%</span>
                                                            </span>
                                                        <span class="progress">
                                                      <span style="width: 98%;"
                                                            class="progress-bar progress-bar-success" aria-valuenow="98"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">98% Complete</span>
                                                            </span>
                                                            </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                            <span class="task">
                                                      <span class="desc">Database migration</span>
                                                            <span class="percent">10%</span>
                                                            </span>
                                                        <span class="progress">
                                                      <span style="width: 10%;"
                                                            class="progress-bar progress-bar-warning" aria-valuenow="10"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">10% Complete</span>
                                                            </span>
                                                            </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                            <span class="task">
                                                      <span class="desc">Web server upgrade</span>
                                                            <span class="percent">58%</span>
                                                            </span>
                                                        <span class="progress">
                                                      <span style="width: 58%;" class="progress-bar progress-bar-info"
                                                            aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">58% Complete</span>
                                                            </span>
                                                            </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                            <span class="task">
                                                      <span class="desc">Mobile development</span>
                                                            <span class="percent">85%</span>
                                                            </span>
                                                        <span class="progress">
                                                      <span style="width: 85%;"
                                                            class="progress-bar progress-bar-success" aria-valuenow="85"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">85% Complete</span>
                                                            </span>
                                                            </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                            <span class="task">
                                                      <span class="desc">New UI release</span>
                                                            <span class="percent">38%</span>
                                                            </span>
                                                        <span class="progress progress-striped">
                                                      <span style="width: 38%;"
                                                            class="progress-bar progress-bar-important"
                                                            aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">38% Complete</span>
                                                            </span>
                                                            </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <!-- END TODO DROPDOWN -->
                                <li class="droddown dropdown-separator">
                                    <span class="separator"></span>
                                </li>

                                */ ?>




                                <!-- BEGIN INBOX DROPDOWN -->
                                <?php
                                use App\Http\Controllers\WC_Chatter\CompanyChatterController;
                                $CompanyChatterControllerObj = new CompanyChatterController();
                                $user_conversations_obj = $CompanyChatterControllerObj->cur_user_conversations();


                                $logged_user_obj = App\User::find(Auth::id());

                                 if(isset($_GET['conversation_id']) && !empty($_GET['conversation_id'])) {
                                    foreach($logged_user_obj->unreadNotifications as $unreadNotification){
                                        if($unreadNotification->data['conversation_id'] == $_GET['conversation_id']) {
                                            $unreadNotification->markAsRead();
                                        }

                                    }
                                }
                                    $logged_user_obj1 = App\User::find(Auth::id());
                                $unread_notifications_obj = $logged_user_obj1->unreadNotifications;


                                ?>



                                <li class="dropdown dropdown-extended dropdown-inbox " id="header_inbox_bar">

                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                       data-hover="dropdown" data-close-others="true">
                                        <span class="circle"> <i class="fa fa- "><span  id="append_messages_count"> {{count($unread_notifications_obj)}}</span></i></span>
                                        <span class="corner"></span>
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li class="external">
                                            <h3>Click on the message to see details</h3>
                                            {{--<a href="javascript:;">view all</a>--}}
                                        </li>
                                        <li >
                                            <ul id="append_messages" class="dropdown-menu-list scroller" style="height: 275px;"  data-handle-color="#637283">
                                                @if($user_conversations_obj)

                                                @foreach($user_conversations_obj as $user_conversation_obj)
                                                        <li>

                                                            <a href="{{url('company')}}/{{$user_conversation_obj->fk_company_id}}/chatter?conversation_id={{$user_conversation_obj->id}}">
                                                                    <span class="photo">
                                                                    <img src="{{config('constants.base_url')."/".config('constants.company_logo_small')}}{{@($user_conversation_obj->company)->company_image->filename}}"


                                                                     class="img-circle" alt=""> </span>
                                                                <span class="subject">
                                                                  <span class="from"> {{@$user_conversation_obj->company->name}}   </span>
                                                                    {{--<span class="time">Just Now </span>--}}
                                                                    </span>
                                                                <span class="message"> {{@$user_conversation_obj->last_message()}}  </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif

                                            </ul>
                                        </li>
                                    </ul>

                                </li>






                                <!-- END INBOX DROPDOWN -->
                                <!-- BEGIN USER LOGIN DROPDOWN -->
                                <li class="dropdown dropdown-user ">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                       data-hover="dropdown" data-close-others="true">




                                        @if(@Auth::user()->avatar->filename)
                                            <img src="{{config('constants.base_url')}}/{{config('constants.user_avatar_large')}}{{@Auth::user()->avatar->filename}}" id="auth_img" class="img-circle  img-responsive" alt="">
                                        @else
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" id="auth_no_img"  class="img-responsive img-circle" alt="1">
                                        @endif

                                        <span class="username username-hide-mobile">{{{ isset(Auth::user()->first_name) ? Auth::user()->first_name.' '.Auth::user()->last_name : Auth::user()->email }}}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-default">
                                        <li>
                                            <a href="{{url('users')}}/{{Auth::id()}}/edit">
                                                <i class="icon-user"></i> My Profile </a>
                                        </li>
                                        {{--<li>--}}
                                        {{--<a href="javascript:;">--}}
                                        {{--<i class="icon-calendar"></i> My Calendar </a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                        {{--<a href="javascript:;">--}}
                                        {{--<i class="icon-envelope-open"></i> My Inbox--}}
                                        {{--<span class="badge badge-danger"> 3 </span>--}}
                                        {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                        {{--<a href="javascript:;">--}}
                                        {{--<i class="icon-rocket"></i> My Tasks--}}
                                        {{--<span class="badge badge-success"> 7 </span>--}}
                                        {{--</a>--}}
                                        {{--</li>--}}
                                        <li class="divider"></li>
                                        {{--<li>--}}
                                        {{--<a href="javascript:;">--}}
                                        {{--<i class="icon-lock"></i> Lock Screen </a>--}}
                                        {{--</li>--}}
                                        <li>
                                            <a href="{{config('constants.base_url')}}/logout">
                                                <i class="icon-key"></i> Log Out </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- END USER LOGIN DROPDOWN -->



                            </ul>
                        </div>
                        <!-- END TOP FORM -->
                    </div>
                </div>
                <!-- END HEADER TOP -->
            </div>
            <!-- END HEADER -->



        </div>
    </div>
    <div class="page-wrapper-row full-height workype-form business-agent">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
        @yield('content')
        <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
    </div>
</div>
<div class="page-wrapper-row">
    <div class="page-wrapper-bottom">
        <!-- BEGIN FOOTER -->
        <!-- BEGIN PRE-FOOTER -->
        <div class="page-prefooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                        <h2>About</h2>
                        <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam dolore. </p>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs12 footer-block">
                        <h2>Subscribe Email</h2>
                        <div class="subscribe-form">
                            <form action="javascript:;">
                                <div class="input-group">
                                    <input type="text" placeholder="mail@email.com" class="form-control">
                                    <span class="input-group-btn">
                                                                    <button class="btn" type="submit">Submit</button>
                                                                  </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                        <h2>Follow Us On</h2>
                        <ul class="social-icons">
                            <li>
                                <a href="javascript:;" data-original-title="rss" class="rss"></a>
                            </li>
                            <li>
                                <a href="javascript:;" data-original-title="facebook" class="facebook"></a>
                            </li>
                            <li>
                                <a href="javascript:;" data-original-title="twitter" class="twitter"></a>
                            </li>
                            <li>
                                <a href="javascript:;" data-original-title="googleplus" class="googleplus"></a>
                            </li>
                            <li>
                                <a href="javascript:;" data-original-title="linkedin" class="linkedin"></a>
                            </li>
                            <li>
                                <a href="javascript:;" data-original-title="youtube" class="youtube"></a>
                            </li>
                            <li>
                                <a href="javascript:;" data-original-title="vimeo" class="vimeo"></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                        <h2>Contacts</h2>
                        <address class="margin-bottom-40"> Phone: 800 123 3456
                            <br> Email:
                            <a href="mailto:info@workype.com">info@workype.com</a>
                        </address>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PRE-FOOTER -->
        <!-- BEGIN INNER FOOTER -->
        <div class="page-footer">
            <div class="container">
                <a target="_blank" href="http://workype.com">Workype.com</a> &copy; 2017, All rights reserved. &nbsp;|&nbsp;
                Various trademarks held by their respective owners.
            </div>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->
    </div>
</div>
</div>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="http://webicosoft.zeemanager.com/webicosoft-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>

<script src="{{config('constants.base_url')}}/webicosoft-assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/pages/scripts/form-dropzone.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
<script src="{{config('constants.base_url')}}/webicosoft-assets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="{{config('constants.base_url')}}/webicosoft-assets/webicosoft/webicosoft.js" type="text/javascript"></script>

@yield('chatter-messages')

<script>
$(document).ready(function () {
    setInterval(function(){
    $.ajax({
        type: "GET",
        url:  "<?php echo url('get_notifications'); ?>",
        dataType: "JSON",
        //method:"post",

        success: function (response) {

            $("#append_messages_count").empty();
            $("#append_messages_count").text(response.unread_messages_count);


            $("#append_messages").html(response.unread_messages_html);


        },
        error: function (jqXHR, exception) {   // when return null
            // $('.load-more-spinner').fadeOut('slow');
            // $this.find('span').text('Error Occured!');
            // processing = false;
        }
    });


    }, 10000);
});
</script>




</body>

</html>