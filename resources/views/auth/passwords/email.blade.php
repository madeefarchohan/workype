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
                    {{--<div class="logo">--}}
                        {{--<a href="{{config('constants.base_url')}}">--}}
                            {{--<img src="assets/pages/img/logo-big.png" alt="" /> </a>--}}
                    {{--</div>--}}
                    <!-- END LOGO -->
                    <!-- BEGIN LOGIN -->
                    <div class="content">
                        <!-- BEGIN REGISTRATION FORM -->


                            <form class="register-form"  method="POST" action="{{ route('password.email') }}">
                                @csrf
                            <h3 class="font-green">Forgot Password</h3>

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                                @if (!session('status'))
                                <p class="hint"> Enter your email address below: </p>
                                <div class="form-group">
                                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                    <label class="control-label visible-ie8 visible-ie9">Email</label>

                                    <input id="email" type="email" placeholder="Email"  class="form-control placeholder-no-fix form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="color:red">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif


                                </div>
                                <div class="form-group">
                                    <a href="{{config('constants.base_url')}}" class="btn btn-default">Back</a>
                                    {{--<a href="{{config('constants.base_url')}}" class="pull-right">Get started - it's free!</a>--}}
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success uppercase btn-block">Send</button>
                                </div>
                                    @endif



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
    <style>
        .page-wrapper-middle{
            background-image: none !important;
            background: #eff3f8 !important;
        }
    </style>

@endsection