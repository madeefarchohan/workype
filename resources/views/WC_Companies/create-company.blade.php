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
                                        <span class="caption-subject font-purple-soft bold uppercase">Add Your Company</span>
                                    </div>


                                    <!-- Help icon -->
                                    {{--<div class="actions">--}}
                                        {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                                            {{--<i class="fa fa-question"></i>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}


                                </div>
                                <div class="portlet-body margin-bottom-20">
                                    <div class="row">
                                        {{--@include('layouts.backend.left-sidebar')--}}
                                        <form role="form" class=""  method="post" action="{{url("/company")}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-3 col-sm-3 col-xs-3 margin-top-10">

                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="max-width:320px">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                            <img src="" alt="">
                                                        </div>
                                                        <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> Select image </span>
                                                        <span class="fileinput-exists"> Change </span>
                                                        <input type="file" name="company_logo_image" accept="image/*" class="wt-image">
                                                    </span>
                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"  > Remove </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-sm-9 col-xs-9">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade active in" id="tab_1_1">

                                                        <div class="row">


                                                            <div class="col-sm-12"><h5 class="bold">About Company</h5><hr/>
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



                                                            <div class="col-sm-6 form-group">

                                                                <div class="col-sm-12 form-group">
                                                                    <label>Company Name</label><span class="required_field_asterik"> *</span>
                                                                    <input type="text" class="form-control" name="name" pattern="^[A-Za-z\s]{1,191}$" title="Characters only" value="{{old('name')}}" required>
                                                                </div>
                                                                <div class="col-sm-12 form-group">
                                                                    <label>Company Type</label><span class="required_field_asterik"> *</span>
                                                                    @if($company_types)
                                                                        <select required name="fk_company_type" class="form-control select2-multiples" data-placeholder="Please Select" multiples>
                                                                            <option value="">Please choose</option>
                                                                            @foreach($company_types as $type)
                                                                                <option value="{{$type->id}}" {{ (Input::old("fk_company_type") == $type->id ? "selected":"") }} >{{$type->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                    <input type="hidden" name="create_company" value="1">
                                                                </div>
                                                                <div class="col-sm-12 form-group">
                                                                    <label>Company size</label><span class="required_field_asterik"> *</span>
                                                                    @if($company_size)
                                                                        <select required name="fk_company_size" class="form-control select2-multiples" data-placeholder="Please Select" multiples>
                                                                            <option value="">Please choose</option>
                                                                            @foreach($company_size as $size)
                                                                                <option value="{{$size->id}}" {{ (Input::old("fk_company_size") == $size->id ? "selected":"") }} >{{$size->from}}{{$size->to}} employees</option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                </div>
                                                                <div class="col-sm-12 form-group">
                                                                    <label>Website</label><span class="required_field_asterik"> *</span>

                                                                    <input name="website" value="{{old('website')}}" type="text" data-type="url"   class="form-control" required >
                                                                </div>
                                                                <div class="col-sm-12 form-group">
                                                                    <label>Job title</label><span class="required_field_asterik"> *</span>
                                                                    <a href="javascript:void(0)" id="btn_add_job_title" class="pull-right">+Add Your Own</a>
                                                                    <a href="javascript:void(0)" id="btn_back_job_title" class="pull-right">+Choose from list</a>
                                                                    @if($job_titles)
                                                                        <select name="fk_job_title_id" id="fk_job_title_id" class="form-control select2-multiples" data-placeholder="Please Select" multiples required>
                                                                            <option value="">Please choose</option>
                                                                            @foreach($job_titles as $job_title)
                                                                                <option value="{{$job_title->id}}" {{ (Input::old("fk_job_title_id") == $job_title->id ? "selected":"") }} >{{$job_title->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                    <div>
                                                                        <input type="text" class="form-control col-md-12" placeholder="Write your job title type here..." style="width:100%;display:none !important;" id="own_job_field" name="own_job"></a>

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 form-group">
                                                                    <label>Email</label><span class="required_field_asterik"> *</span>

                                                                    <input name="email" value="{{old('email')}}" type="email" class="form-control" required >
                                                                </div>
                                                                <div class="col-sm-12 form-group">

                                                                    <label>Your detail roles</label><span class="required_field_asterik"> *</span>

                                                                    <textarea class="form-control placeholder-no-fix" name="details" placeholder="Your detail roles" required>{{old('details')}}</textarea>

                                                                </div>
                                                                <div class="col-sm-12 form-group">
                                                                    <label>Established Year</label><span class="required_field_asterik"> *</span>
                                                                    <input name="established_year" value="{{old('established_year')}}" type="text" class="form-control date-picker" size="16" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" required>
                                                                </div>
                                                                <div class="col-sm-12 form-group">

                                                                    <label>Company Description</label><span class="required_field_asterik"> *</span>

                                                                    <textarea class="form-control placeholder-no-fix" name="description" placeholder="Company Description"  required>{{old('description')}}</textarea>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 form-group">
                                                                <div class="col-sm-12 form-group">
                                                                    <label>Product Type</label><span class="required_field_asterik"> *</span>
                                                                    <a href="javascript:void(0)" id="btn_add_field_product_type" class="pull-right">+Add Your Own</a>
                                                                    <a href="javascript:void(0)" id="btn_back" class="pull-right">+Choose from list</a>
                                                                    @if($product_types)
                                                                        <select required name="fk_product_type_id" id="fk_product_type_id" class="form-control select2-multiples" data-placeholder="Please Select" multiples>
                                                                            <option value="">Please choose</option>
                                                                            @foreach($product_types as $type)
                                                                                <option value="{{$type->id}}"  {{ (Input::old("fk_product_type_id") == $type->id ? "selected":"") }}>{{$type->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                    <div>
                                                                        <input type="text" class="form-control col-md-12" placeholder="Write your product type here..." style="width:100%;display:none !important;" id="own_product_field" name="own_product"></a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 form-group">
                                                                    {{--<a href="javascript:void(0)" wt-more="field">+Add More</a>--}}
                                                                    <label>Specialties </label><span class="required_field_asterik"> *</span>

                                                                    <div wt-paste="field">
                                                                        <input type="text" class="form-control" placeholder="Name" name="specialities[]" value="{{Input::old('specialities')[0]}}" required/>
                                                                    </div>

                                                                    @if(!is_null(Input::old('specialities')))

                                                                        @foreach(Input::old('specialities') as $n => $value)
                                                                            {{--{{dd(Input::old('specialities'))}}--}}
                                                                            <div wt-duplicate="field" class="margin-top-20">
                                                                                @if($n > 0)
                                                                                    @if($value != "")
                                                                                        <input type="text" class="form-control col-md-10" style="width:95%;" value="{{$value}}" name="specialities[]">
                                                                                        <a href="javascript:;" wt-delete="field"><i class="margin-top-10 fa fa-trash fa-lg" style="margin-left: 3px;"></i></a>

                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                    <div class="pull-right" style="padding-top: 5px;" >
                                                                        <a href="javascript:void(0)" wt-more="field" class="btn btn-primary">+Add More</a>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <!--
                                                            <div class="col-sm-6 form-group">
                                                                <label>Company Type</label><span class="required_field_asterik"> *</span>
                                                                @if($company_types)
                                                                    <select required name="fk_company_type" class="form-control select2-multiples" data-placeholder="Please Select" multiples>
                                                                        <option value="">Please choose</option>
                                                                        @foreach($company_types as $type)
                                                                            <option value="{{$type->id}}" {{ (Input::old("fk_company_type") == $type->id ? "selected":"") }} >{{$type->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                                <input type="hidden" name="create_company" value="1">
                                                            </div>

                                                        -->
                                                        </div>







                                                        <hr/>
                                                        <div class="form-actions pull-left">
                                                            <button type="submit" class="btn btn-success uppercase ">Submit</button>
                                                            <button type="reset" class="btn btn-default uppercase ">Reset</button>
                                                        </div>



                                                        <div wt-copy="field" style="display:none; ">
                                                            <div wt-duplicate="field" class="margin-top-20">
                                                                <input  type="text" class="form-control col-md-10" style="width:90%;" name="specialities[]">
                                                               <p class="trash_style">
                                                                <a href="javascript:;" wt-delete="field"><i class=" trash_inner margin-top-10  fa fa-trash fa-lg" ></i></a>
                                                                </p>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="tab-pane fade" id="tab_1_2">
                                                        <form role="form" class="" method="post" action="">
                                                            @csrf

                                                            <div class="row">
                                                                <div class="col-sm-12"><h5 class="bold">Headquarter</h5><hr/></div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group clearfix">
                                                                            <label class="control-label col-md-4">Address</label>
                                                                            <div class="col-md-8">
                                                                                <textarea name="address" class="form-control address-field">{{old('address')}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group clearfix">
                                                                            <label class="control-label col-md-4">Zip Code</label>
                                                                            <div class="col-md-8">
                                                                                <input type="text" name="zip_code" class="form-control" value="{{old('zip_code')}}" placeholder="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group clearfix">
                                                                            <label class="control-label col-md-4">City</label>
                                                                            <div class="col-md-8">
                                                                                <input type="text" name="city" class="form-control" placeholder="" value="{{old('city')}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group clearfix">
                                                                            <label class="control-label col-md-4">Province</label>
                                                                            <div class="col-md-8">
                                                                                <input type="text" name="province" class="form-control" placeholder="" value="{{old('province')}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group clearfix">
                                                                            <label class="control-label col-md-4">Country</label>
                                                                            <div class="col-md-8">
                                                                                <div class="wtSelect">
                                                                                    <select class="form-control" name="country">
                                                                                        <option value="">Please choose country</option>
                                                                                        @foreach(get_countries_list() as $key => $val)
                                                                                            <option value="{{$key}}">{{$val}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab_1_3">
                                                        <form role="form" class="">
                                                            <div class="row">
                                                                <div class="col-sm-12"><h5 class="bold">Assign a primary contact person of your company:</h5><hr/></div>
                                                                <div class="col-sm-6 form-group">
                                                                    <select class="form-control select2">
                                                                        <option selected>Please choose</option>
                                                                        <optgroup label="Alaskan">
                                                                            <option value="AK">Alaska</option>
                                                                            <option value="HI" disabled="disabled">Hawaii</option>
                                                                        </optgroup>
                                                                        <optgroup label="Pacific Time Zone">
                                                                            <option value="CA">California</option>
                                                                            <option value="NV">Nevada</option>
                                                                            <option value="OR">Oregon</option>
                                                                            <option value="WA">Washington</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label>This person will be a communication channel when other companies & users contact your company & employees</label>
                                                                </div>
                                                            </div>
                                                            <div class="row margin-top-10">
                                                                <div class="col-sm-6 form-group">
                                                                    <select class="form-control select2">
                                                                        <option selected>Please choose</option>
                                                                        <optgroup label="Alaskan">
                                                                            <option value="AK">Alaska</option>
                                                                            <option value="HI" disabled="disabled">Hawaii</option>
                                                                        </optgroup>
                                                                        <optgroup label="Pacific Time Zone">
                                                                            <option value="CA">California</option>
                                                                            <option value="NV">Nevada</option>
                                                                            <option value="OR">Oregon</option>
                                                                            <option value="WA">Washington</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label>This person will help other companies & users on finding right employees in your company</label>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="tab-pane fade" id="tab_1_4">
                                                        <div class="row">
                                                            <div class="col-sm-12"><h5 class="bold">Upload Your Photos or Videos:</h5><hr/></div>
                                                            <form action="assets/global/plugins/dropzone/upload.php" class="dropzone dropzone-file-area" id="my-dropzone" style="width:90%; margin-top: 80px;">
                                                                <h3 class="sbold">Drop files here or click to upload</h3>
                                                                <p> This is just a demo dropzone. Selected files are not actually uploaded. </p>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab_1_5">
                                                        <div class="row">
                                                            <div class="col-sm-12"><h5 class="bold">Post:</h5><hr/></div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Subject</label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Description</label>
                                                                    <textarea class="form-control address-field"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <ul class="margin-top-20">
                                                                    <li>Post what your company is looking for (ex, We are looking for a business development company for 3D printer in USA)</li>
                                                                    <li>Post products, services you want to sell or buy</li>
                                                                    <li>Post any topics to public for your company</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!--
                                                    <hr/>
                                                    <div class="form-actions text-center">
                                                        <button type="button" class="btn btn-default uppercase ">Cancel</button>
                                                        <button type="submit" class="btn btn-success uppercase ">Submit</button>
                                                    </div>
                                                    -->


                                                </div>
                                            </div>
                                        </form>
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