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
                    {{--@include('layouts.backend.search-form')--}}
                    <div class="create-company">
                        <div class="portlet light border border-grey">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-social-dribbble font-purple-soft"></i>
                                    <span class="caption-subject font-purple-soft bold uppercase">Manage company - {{$company_obj->name}}</span>
                                </div>
                                <div class="actions">

                                    <a class="btn green circle" href="<?php echo e(url('company')); ?>/<?php echo e($company_obj->id); ?>">
                                        View company
                                    </a>

                                    {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                                        {{--<i class="fa fa-question"></i>--}}
                                    {{--</a>--}}
                                </div>
                            </div>
                            <div class="portlet-body margin-bottom-20">
                                <div class="row">


                                    @include('layouts.backend.left-sidebar')




                                        <div class="col-md-9 col-sm-9 col-xs-9">
                                            <div class="tab-content">







                                                </div>
                                                <div class="clearfix"></div>

                                                <div class="tab-pane fade active in" id="tab_1_1">



                                                    <div class=" ">
                                                        <!-- BEGIN PORTLET -->
                                                        <div class="portlet light ">
                                                            <div class="portlet-title">
                                                                <div class="caption caption-md">
                                                                    <i class="icon-bar-chart theme-font hide"></i>
                                                                    <span class="caption-subject font-blue-madison bold uppercase">Company Admins</span>
                                                                    <span class="caption-helper"></span>
                                                                </div>
                                                                <div class="inputs">
                                                                    <div class="">



                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="portlet-body">

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


                                                                {{Form::open(array('action' => array('CompanyController@admins', $company_obj->id)))}}
                                                                <div class="input-group  ">
                                                                    <select  name="admins[]" data-placeholder="Select company admins" class="form-control select2" multiple>

                                                                        @foreach($users as $user)
                                                                            @if($company_obj->fk_user_id != $user->id)
                                                                            <option value="{{$user->id}}" @php   selected(true, in_array($user->id,$company_obj->company_admins_arr()), true);    @endphp>
                                                                                {{$user->first_name}} {{$user->last_name}} ({{$user->email}})

                                                                            </option>
                                                                            @endif
                                                                        @endforeach

                                                                    </select>

                                                                    <span class="input-group-btn">
                                                                                    <button class="btn green" type="submit">Go</button>
                                                                                </span>
                                                                </div>
                                                                </form>

                                                                <div class="timeline">
                                                                    <!-- TIMELINE ITEM -->
                                                                    <div class="timeline-item">
                                                                        <div class="timeline-badge">
                                                                            <a href="#">

                                                                            @if(@($company_obj->created_by)->avatar->filename)
                                                                            <img class="timeline-badge-userpic" src="{{config('constants.base_url')}}/{{config('constants.user_avatar_large')}}{{@($company_obj->created_by)->avatar->filename}}">
                                                                        @else
                                                                            <img class="timeline-badge-userpic" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">

                                                                            @endif
                                                                            </a>
                                                                    </div>


                                                                        <div class="timeline-body">
                                                                            <div class="timeline-body-arrow"> </div>
                                                                            <div class="timeline-body-head">
                                                                                <div class="timeline-body-head-caption">
                                                                                    <a href="#" class="timeline-body-title font-blue-madison">  {{@$company_obj->created_by->first_name}} {{@$company_obj->created_by->last_name}}</a>
                                                                                    <span class="timeline-body-time font-grey-cascade"><b>Owner</b> <!--Replied at 17:45 PM--></span>
                                                                                </div>
                                                                                <div class="timeline-body-head-actions">
                                                                                    {{--<div class="btn-group">--}}
                                                                                        {{--<button class="btn btn-circle green btn-outline btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> Actions--}}
                                                                                            {{--<i class="fa fa-angle-down"></i>--}}
                                                                                        {{--</button>--}}
                                                                                        {{--<ul class="dropdown-menu pull-right" role="menu">--}}
                                                                                            {{--<li>--}}
                                                                                                {{--<a href="javascript:;">Action </a>--}}
                                                                                            {{--</li>--}}
                                                                                            {{--<li>--}}
                                                                                                {{--<a href="javascript:;">Another action </a>--}}
                                                                                            {{--</li>--}}
                                                                                            {{--<li>--}}
                                                                                                {{--<a href="javascript:;">Something else here </a>--}}
                                                                                            {{--</li>--}}
                                                                                            {{--<li class="divider"> </li>--}}
                                                                                            {{--<li>--}}
                                                                                                {{--<a href="javascript:;">Separated link </a>--}}
                                                                                            {{--</li>--}}
                                                                                        {{--</ul>--}}
                                                                                    {{--</div>--}}
                                                                                </div>
                                                                            </div>
                                                                            <div class="timeline-body-content">
                                                                            <span class="font-grey-cascade"> {{@$company_obj->created_by->email}} </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                    @if(@$company_obj->company_admins->count() > 0)
                                                                        @foreach($company_obj->company_admins as $company_admin)

                                                                            <div class="timeline">
                                                                                <!-- TIMELINE ITEM -->
                                                                                <div class="timeline-item">
                                                                                    <div class="timeline-badge">
                                                                                        <a href="#">

                                                                                            @if(@($company_admin->user)->avatar->filename)
                                                                                                <img class="timeline-badge-userpic" src="{{config('constants.base_url')}}/{{config('constants.user_avatar_large')}}{{@($company_admin->user)->avatar->filename}}">
                                                                                            @else
                                                                                                <img class="timeline-badge-userpic" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">

                                                                                            @endif
                                                                                        </a>
                                                                                    </div>


                                                                                    <div class="timeline-body">
                                                                                        <div class="timeline-body-arrow"> </div>
                                                                                        <div class="timeline-body-head">
                                                                                            {{--<form action="{{url('company-admin')}}/{{$company_admin->id}}" method="post">--}}
                                                                                                {{--@csrf--}}
                                                                                                {{--<input name="_method" type="hidden" value="DELETE">--}}
                                                                                            <p class="trash_style pull-right" style="    width: 27px; height: 26px;">
                                                                                                <a href="{{url('company-admin')}}/{{$company_admin->id}}" style=" margin-right: 8px;margin-top: 7px;" class="sure-to-delete fa fa-trash pull-right admin_delete"></a>
                                                                                            </p>
                                                                                            {{--<a href="{{url('company-admin')}}/{{$company_admin->id}}" class="sure-to-delete fa fa-trash pull-right admin_delete"></a>--}}
                                                                                            {{--</form>--}}
                                                                                                <div class="timeline-body-head-caption">
                                                                                                <a href="#" class="timeline-body-title font-blue-madison">  {{@$company_admin->user->first_name}} {{@$company_admin->user->last_name}}</a>
                                                                                                {{--<span class="timeline-body-time font-grey-cascade"><b>Admin</b> <!--Replied at 17:45 PM--></span>--}}
                                                                                            </div>
                                                                                            <div class="timeline-body-head-actions">
                                                                                                {{--<div class="btn-group">--}}
                                                                                                {{--<button class="btn btn-circle green btn-outline btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> Actions--}}
                                                                                                {{--<i class="fa fa-angle-down"></i>--}}
                                                                                                {{--</button>--}}
                                                                                                {{--<ul class="dropdown-menu pull-right" role="menu">--}}
                                                                                                {{--<li>--}}
                                                                                                {{--<a href="javascript:;">Action </a>--}}
                                                                                                {{--</li>--}}
                                                                                                {{--<li>--}}
                                                                                                {{--<a href="javascript:;">Another action </a>--}}
                                                                                                {{--</li>--}}
                                                                                                {{--<li>--}}
                                                                                                {{--<a href="javascript:;">Something else here </a>--}}
                                                                                                {{--</li>--}}
                                                                                                {{--<li class="divider"> </li>--}}
                                                                                                {{--<li>--}}
                                                                                                {{--<a href="javascript:;">Separated link </a>--}}
                                                                                                {{--</li>--}}
                                                                                                {{--</ul>--}}
                                                                                                {{--</div>--}}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="timeline-body-content">
                                                                                            <span class="font-grey-cascade"> {{@$company_admin->user->email}} </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>


                                                                        @endforeach
                                                                    @endif






                                                                </div>


                                                        </div>
                                                        <!-- END PORTLET -->
                                                    </div>

                                                </div>
                                        </div>

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