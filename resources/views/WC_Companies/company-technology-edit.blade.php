@extends('layouts.backend')
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
                    <!-- BEGIN LOGIN -->
                    <div class="content">
                        @include('layouts.backend.search-form')
                        <div class="create-company">
                            <div class="portlet light border border-grey">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-social-dribbble font-purple-soft"></i>
                                        <span class="caption-subject font-purple-soft bold uppercase">Manage company - {{$company_obj->name}}</span>
                                    </div>
                                    <div class="actions">

                                        {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                                            {{--<i class="fa fa-question"></i>--}}
                                        {{--</a>--}}
                                    </div>
                                </div>
                                <div class="portlet-body margin-bottom-20">
                                    <div class="row">


                                        @include('layouts.backend.left-sidebar')



                                        <form role="form" class=""  method="post" action="{{url('/company/'.$company_obj->id)}}" enctype="multipart/form-data">

                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <div class="col-md-9 col-sm-9 col-xs-9">
                                                <div class="tab-content">

                                                    <div class="">
                                                        @if($errors->any())
                                                            <div class="alert alert-danger">
                                                                <button class="close" data-close="alert"></button>
                                                                @foreach($errors->all() as $error)
                                                                    {{$error}}<br>
                                                                @endforeach
                                                            </div>

                                                        @endif

                                                        @if(session()->get('status') != null)
                                                            <div class="alert alert-success">
                                                                <button class="close" data-close="alert"></button>
                                                                {{ session()->get('status') }}<br>
                                                            </div>
                                                        @endif

                                                    </div>
                                                    <div class="clearfix"></div>


                                                    <div class="row">
                                                        <div class="col-sm-12"><h5 class="bold">Technology</h5><hr/></div>

                                                        <div class="col-sm-12">
                                                            <div class="form-group  ">
                                                                <textarea rows="5"  placeholder=" " name="technology" class="form-control address-field">{{@$company_obj->technology}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-actions pull-left">

                                                        <input type="submit" name="btn_company_technology" value="submit" class="btn btn-success uppercase ">
                                                        <button type="reset" class="btn btn-default uppercase">Reset</button>
                                                    </div>



                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END PAGE CONTENT BODY -->
    <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection