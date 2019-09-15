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
                            <img src="assets/pages/img/logo-big.png" alt="" /> </a>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN LOGIN -->
                    <div class="content">




                        <div class="register-form"  method="POST" action="{{ route('password.request') }}">

                            <h3 class="font-green">Success!</h3>


                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <br/>
                        </div>

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