@extends('layouts.frontend')
@section('content')


<div class="page-container">
          <!-- BEGIN CONTENT -->
          <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <!-- BEGIN PAGE CONTENT BODY -->
            <div class="page-content">
              <div class="container">
                <!-- BEGIN PAGE BREADCRUMBS -->
                <!-- BEGIN LOGO -->
                <div class="logo">
                  <a href="{{config('constants.base_url')}}">
                    <img src="webicosoft-assets/pages/img/logo-big.png" alt=""> </a>
                  </div>
                  <!-- END LOGO -->
                  <!-- BEGIN LOGIN -->
                  <div class="content">
                    <!-- BEGIN REGISTRATION FORM -->
                    <form class="register-form mt-0" action="{{config('constants.base_url')}}" method="post">

                    <div class="portlet-body form" style="border-bottom: 1px solid #f5f5f5">
                      <div class="form-wizard">
                          <ul class="nav nav-pills nav-justified steps no-margin">
                            <li class="done">
                              <a href="#tab1" data-toggle="tab" class="step">
                                <span class="number"> 1 </span>
                                <span class="desc"> <i class="fa fa-check"></i> Account Setup </span>
                              </a>
                            </li>
                            <li class="done">
                              <a href="#tab2" data-toggle="tab" class="step">
                                <span class="number"> 2 </span>
                                <span class="desc">  <i class="fa fa-check"></i> Email Confirm </span>
                              </a>
                            </li>
                            <li class="done">
                              <a href="#tab3" data-toggle="tab" class="step active">
                                <span class="number"> 3 </span>
                                <span class="desc"> <i class="fa fa-check"></i> Register Company </span>
                              </a>
                            </li>
                            <li class="active">
                              <a href="#tab4" data-toggle="tab" class="step">
                                <span class="number"> 4 </span>
                                <span class="desc"> <i class="fa fa-check"></i> Company Verify </span>
                              </a>
                            </li>
                          </ul>
                      </div>
                    </div>
                    <div class="note border-green margin-top-40">
                      <h4 class="block font-green">Success !</h4>
                      <p> Your company email <b>{{session()->get('status')}}</b> is been verified. </p><br>

                    </div>
                    </form>
                    <!-- END REGISTRATION FORM -->
                  </div>
                  <!-- END PAGE CONTENT INNER -->
                </div>
              </div>
              <!-- END PAGE CONTENT BODY -->
              <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
          </div>
<!-- END CONTAINER -->


@endsection