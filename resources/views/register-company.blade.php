@extends('layouts.frontend')
@section('content')
    <!-- BEGIN CONTAINER -->
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
                            <img src="webicosoft-assets/pages/img/logo-big.png" alt="" /> </a>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN LOGIN -->
                    <div class="content">
                        <!-- BEGIN REGISTRATION FORM -->
                        <form class="register-form mt-0"  method="post" action="{{url("/company")}}">
                            @csrf
                            <input type="hidden" name="_token" value="{{@csrf_token()}}" />
                            <input type="hidden" name="reg_company" value="1" >
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
                                        <li class="active">
                                            <a href="#tab3" data-toggle="tab" class="step active">
                                                <span class="number reg_company"> 3 </span>
                                                <span class="desc"> <i class="fa fa-check"></i> Register Company </span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="#tab4" data-toggle="tab" class="step">
                                                <span class="number comp_verification"> 4 </span>
                                                <span class="desc"> <i class="fa fa-check"></i> Company Verify </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="testing_purpose">
                                @if(session()->get('status') != null)
                                    <div class="alert alert-success">
                                        <button class="close" data-close="alert"></button>
                                        {{ session()->get('status') }}<br>
                                    </div>
                                @endif
                                <?php
                                    $please_verify_email = @session()->get('flag');
                                    ?>
                                <div @php if($please_verify_email == "please_verify_email") echo "style='display:none;'"; @endphp>

                                <p class="hint"> Enter your company details below: </p>
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <button class="close" data-close="alert"></button>
                                        @foreach($errors->all() as $error)
                                            {{$error}}<br>
                                        @endforeach

                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Company Name</label>
                                    <input class="form-control placeholder-no-fix" type="text" name="name" pattern="^[A-Za-z\s]{1,191}$" title="Characters only" placeholder="Company Name" value="{{old('name')}}" required />
                                </div>

                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Company Website: http://www.xyz.com</label>
                                    <input class="form-control placeholder-no-fix" name="website" value="{{old('website')}}" type="text" data-type="url" placeholder="Company Website: http://www.xyz.com" required/>
                                </div>


                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Company Email</label>
                                    <input class="form-control placeholder-no-fix" name="email" type="email" value="{{old('email')}}" placeholder="Company Email: example@gmail.com" required>
                                </div>


                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Job title</label>

                                    @if($job_titles)
                                        <select name="fk_job_title_id" class="form-control select2-multiples" data-placeholder="Please Select" required multiples>
                                            <option value="">Please choose job title</option>
                                            @foreach($job_titles as $job_title)
                                                <option value="{{$job_title->id}}" {{ (Input::old("fk_job_title_id") == $job_title->id ? "selected":"") }} >{{$job_title->name}}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                </div>


                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Your detail roles</label>

                                    <textarea class="form-control placeholder-no-fix" name="details" placeholder="Your detail roles" required>{{old('details')}}</textarea>

                                </div>


                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Country</label>
                                    <select class="form-control" name="country" required>
                                        <option value="">Please choose country</option>
                                        @foreach(get_countries_list() as $key => $val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">City</label>
                                    <input  class="form-control placeholder-no-fix" pattern="^[A-Za-z]{0,191}$" title="Characters only" placeholder="City" value="{{old('city')}}" type="text" name="city" required/>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <label class="control-label visible-ie8 visible-ie9">+1</label>
                                            <input class="form-control placeholder-no-fix" name="ph_countrycode" value="{{old('ph_countrycode')}}" type="number" placeholder="+1" required/>
                                        </div>
                                        <div class="col-xs-3">
                                            <label class="control-label visible-ie8 visible-ie9">Code</label>
                                            <input class="form-control placeholder-no-fix" name="ph_areacode" value="{{old('ph_areacode')}}" type="number" placeholder="Code" required/>
                                        </div>
                                        <div class="col-xs-6">
                                            <label class="control-label visible-ie8 visible-ie9">Number</label>
                                            <input class="form-control placeholder-no-fix" name="ph_number" value="{{old('ph_number')}}" type="number" placeholder="Number" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Skype ID</label>
                                    <input class="form-control placeholder-no-fix" type="text" value="{{old('skype')}}" name="skype" placeholder="Skype ID" required/>
                                </div>
                                <div class="form-group margin-top-20">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" name="tnc" /> I agree to the
                                        <a href="javascript:;">Terms of Service </a> &
                                        <a href="javascript:;">Privacy Policy </a>
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-actions">
                                    <!-- <button type="submit" class="btn btn-success uppercase btn-block">Confirm &nbsp; <i class="fa fa-arrow-right"></i></button> -->

                                    <a  href="{{url('/')}}" class="btn btn-danger uppercase col-md-5  " name="btn_register_company" > &nbsp; <i class="fa fa-arrow-left"></i> Skip</a>

                                    <button type="submit" class="btn btn-success uppercase  col-md-5 pull-right " name="btn_register_company" >Confirm &nbsp; <i class="fa fa-arrow-right"></i></button>
                                    <div class="clearfix"></div>
                                </div>
                            </div>




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