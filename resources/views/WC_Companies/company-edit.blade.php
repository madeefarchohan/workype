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

                                        <form role="form" class=""  method="post" action="{{url('/company/'.$company_obj->id)}}" enctype="multipart/form-data">

                                            @csrf
                                            <div class="col-md-9 col-sm-9 col-xs-9">
                                                <div class="tab-content">

                                                    <div class=""><h5 class="bold">About Company</h5><hr/>
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

                                                    <div class="tab-pane fade active in" id="tab_1_1">

                                                        <input type="hidden" name="_method" value="PUT">

                                                        <div class="clearfix">
                                                            <div class="company-logo col-md-3">
                                                                <div class="row form-group">
                                                                    <div class="fileinput fileinput-@if(isset($company_obj->company_image->filename)){{trim('exists')}}@else{{trim('new')}}@endif text-center" data-provides="fileinput" style="max-width:320px">
                                                                        <div class="fileinput-new thumbnail" style=" ">
                                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/> </div>
                                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                                            <img src="@if (isset($company_obj->company_image->filename)) {{config('constants.base_url')."/".config('constants.company_logo_large').$company_obj->company_image->filename}}@endif" alt="" />
                                                                        </div>
                                                                        <div>
                                                                            <span class="btn default btn-file">
                                                                                <span class="fileinput-new"> Select image </span>
                                                                                <span class="fileinput-exists"> Change </span>
                                                                                <input type="file" name="company_logo_image" accept="image/*" class="wt-image">
                                                                            </span>
                                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput" onclick="return removeCompanyLogoPic(this)"> Remove </a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="margin-top-20">
                                                                    <input type="hidden" name="existCompanyLogoPic" id="existCompanyLogoPic" value="0">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label>Company Name</label>
                                                                    <input type="text" pattern="^[A-Za-z\s]{1,191}$" title="Characters only" class="form-control" name="name" value="{{$company_obj->name}}" required>
                                                                </div>
                                                                <div class="orm-group">

                                                                    <label>Company Description</label>

                                                                    <textarea class="form-control placeholder-no-fix" name="description" placeholder="Company Description" >{{$company_obj->description}}</textarea>

                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="row">


                                                            <div class="col-sm-6 form-group">
                                                                <label>Company Type</label>
                                                                @if($company_types)
                                                                    <select name="fk_company_type" class="form-control select2-multiples" data-placeholder="Please Select" multiples>
                                                                        <option value="">Please choose</option>
                                                                        @foreach($company_types as $type)
                                                                            <option value="{{$type->id}}" {{ ( $company_obj->fk_company_type == $type->id ? "selected":"") }} >{{$type->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                                <input type="hidden" name="create_company" value="1">
                                                            </div>


                                                            <div class="col-sm-6 form-group">
                                                                <label>Product Type</label>
                                                                @if($product_types)
                                                                    <select name="fk_product_type_id" class="form-control select2-multiple" data-placeholder="Please Select" multiples>
                                                                        <option value="">Please choose</option>
                                                                        @foreach($product_types as $type)
                                                                            <option value="{{$type->id}}" {{ @( $company_obj->company_product_details->fk_product_type_id == $type->id ? "selected":"") }}>{{$type->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-sm-12 form-group">
                                                                <label title="Add more">Specialties</label>

                                                                <div wt-paste="field">
                                                                    @if(is_null(Input::old('specialities')))
                                                                    @foreach($company_specialities as $company_speciality)
                                                                        <div wt-duplicate="field" class="margin-top-20">
                                                                            <input  type="text" class="form-control col-md-10"  style="width:91%;" value="{{$company_speciality->name}}" placeholder="Name" name="specialities[]" />
                                                                            <p class="trash_style">
                                                                                <a href="javascript:;" wt-delete="field"><i class=" trash_inner margin-top-10  fa fa-trash fa-lg" ></i></a>
                                                                            </p>
                                                                        </div>
                                                                    @endforeach
                                                                    @endif

                                                                        @if(!is_null(Input::old('specialities')))

                                                                            @foreach(Input::old('specialities') as $n => $value)
                                                                                {{--{{dd(Input::old('specialities'))}}--}}
                                                                                <div wt-duplicate="field" class="margin-top-20">
                                                                                    {{--@if($n > 0)--}}
                                                                                        @if($value != "")
                                                                                            <input type="text" class="form-control col-md-10" style="width:91%;" value="{{$value}}" name="specialities[]">
                                                                                        <p class="trash_style">
                                                                                            <a href="javascript:;" wt-delete="field"><i class=" trash_inner margin-top-10  fa fa-trash fa-lg" ></i></a>
                                                                                        </p>
                                                                                    @endif
                                                                                    {{--@endif--}}
                                                                                </div>
                                                                            @endforeach
                                                                            @endif

                                                                </div>
                                                                <div class="col-md-2 pull-right" style=" padding-top: 6px;  margin-right: 16px;">
                                                                    <a href="javascript:void(0)" wt-more="field" class=" btn btn-primary " >+Add More</a>
                                                                {{--<a href="javascript:void(0)" wt-more="field"><i class="fa fa-plus fa-lg"></i></a>--}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6 form-group">
                                                                <label>Company size</label>

                                                                @if($company_size)
                                                                    <select name="fk_company_size" class="form-control select2-multiples" data-placeholder="Please Select" multiples>
                                                                        <option value="">Please choose</option>
                                                                        @foreach($company_size as $size)
                                                                            <option value="{{$size->id}}" {{ ($company_obj->fk_company_size == $size->id ? "selected":"") }} >{{$size->from}}{{$size->to}} employees</option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </div>
                                                            <div class="col-sm-6 form-group">
                                                                <label>Job title</label>

                                                                @if(@$job_titles)
                                                                    <select name="fk_job_title_id" class="form-control select2-multiples" data-placeholder="Please Select" multiples>
                                                                        <option value="">Please choose</option>
                                                                        @foreach(@$job_titles as $job_title)

                                                                            <option value="{{$job_title->id}}"{{ (@$user_company_role->fk_job_title_id== @$job_title->id ? "selected":"") }}>{{@$job_title->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </div>



                                                        </div>


                                                        <div class="row">
                                                            <div class="col-sm-6 form-group">

                                                                <label>Your detail roles</label>

                                                                <textarea class="form-control placeholder-no-fix" name="details" placeholder="Your detail roles" >{{@$user_company_role->details}}</textarea>

                                                            </div>
                                                            <div class="col-sm-6 form-group">
                                                                <label>Established Year</label>
                                                                <input name="established_year" value="{{@$company_obj->established_year}}" type="text" class="form-control date-picker" size="16" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd">
                                                            </div>

                                                        </div>



                                                        <hr/>
                                                        <div class="form-actions pull-left">

                                                            <input  type="submit" name="btn_company_info" value="submit" class="btn btn-success uppercase ">
                                                            <a href="{{url('company')}}"  class="btn btn-default uppercase ">Cancel</a>
                                                        </div>



                                                        <div wt-copy="field" style="display:none; ">
                                                            <div wt-duplicate="field" class="margin-top-20">

                                                                <input  type="text" class="form-control col-md-10"  style="width:91%;" name="specialities[]">

                                                                <p class="trash_style">
                                                                    <a href="javascript:;" wt-delete="field"><i class=" trash_inner margin-top-10  fa fa-trash fa-lg" ></i></a>
                                                                </p>
                                                            </div>
                                                        </div>


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