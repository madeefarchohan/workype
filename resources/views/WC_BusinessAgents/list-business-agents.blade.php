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

                        {{--<form role="form" class="workype-search sm-form">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-12">--}}
                                    {{--<div class="input-group input-group-lg">--}}
                                        {{--<div class="input-group-btn">--}}
                                            {{--<button type="button" class="btn green dropdown-toggle" data-toggle="dropdown">Action--}}
                                                {{--<i class="fa fa-angle-down"></i>--}}
                                            {{--</button>--}}
                                            {{--<ul class="dropdown-menu">--}}
                                                {{--<li><a href="javascript:;">Products</a></li>--}}
                                                {{--<li><a href="javascript:;">Supply and Manufacturer</a></li>--}}
                                                {{--<li><a href="javascript:;">Buyer</a></li>--}}
                                                {{--<li><a href="javascript:;">Supply & Buyer</a></li>--}}
                                                {{--<li><a href="javascript:;">Distribution and wholesale</a></li>--}}
                                                {{--<li><a href="javascript:;">Business Developer</a></li>--}}
                                                {{--<li><a href="javascript:;">Startup</a></li>--}}
                                                {{--<li><a href="javascript:;">Investment & Incubation</a></li>--}}
                                                {{--<li><a href="javascript:;">Government Division</a></li>--}}
                                                {{--<li class="divider"> </li>--}}
                                                {{--<li class="reset"><a href="javascript:;"> Reset Action </a></li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                        {{--<!-- /btn-group -->--}}
                                        {{--<input type="text" class="form-control">--}}
                                        {{--<div class="input-group-btn">--}}
                                            {{--<button type="button" class="btn btn-default">--}}
                                                {{--<i class="fa fa-search"></i>--}}
                                            {{--</button>--}}
                                        {{--</div>--}}
                                        {{--<!-- /btn-group -->--}}
                                    {{--</div>--}}
                                    {{--<!-- /input-group -->--}}
                                {{--</div>--}}
                                {{--<!-- /.col-md-6 -->--}}
                            {{--</div>--}}
                            {{--<!-- /.row -->--}}
                            {{--<div class="workype-search-append margin-top-10"></div>--}}
                        {{--</form>--}}





                        <div class="col-md-12">
                            <div class="row">

                                <form role="form" method="GET" action="{{url('business-agents')}}">
                                    <div class="company-details">
                                        <div class="clearfix filter">
                                            <div class="col-xs-6 col-sm-3 col-md-3">
                                                <label class="control-label">Company name</label>
                                                <input type="text" name="name" pattern="^[A-Za-z\s]{1,191}$" title="Characters only"  class="form-control" value="{{@Input::get('name')}}">
                                            </div>

                                            <div class="col-xs-6 col-sm-3 col-md-3">
                                                <label class="control-label">By Company Type</label>
                                                <select name="fk_company_type" class="form-control select2">
                                                    <option value="0">All</option>
                                                    @if(@$company_type_obj)
                                                        @foreach($company_type_obj as $company_type)
                                                            <option value="{{@$company_type->id}}" <?php @selected(Input::get('fk_company_type'), $company_type->id)?> >{{@$company_type->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            {{--<div class="col-xs-6 col-sm-3 col-md-3">--}}
                                            {{--<label class="control-label">By Product Type</label>--}}
                                            {{--<select name="fk_product_type_id" class="form-control select2">--}}
                                            {{--<option value="0">Please choose</option>--}}
                                            {{--@if(@$company_product_type)--}}
                                            {{--@foreach($company_product_type as $product_type)--}}
                                            {{--<option value="{{@$product_type->id}}">{{@$product_type->name}}</option>--}}
                                            {{--@endforeach--}}
                                            {{--@endif--}}
                                            {{--</select>--}}
                                            {{--</div>--}}
                                            <div class="col-xs-6 col-sm-3 col-md-3">
                                                <label class="control-label">By Size</label>
                                                <select name="fk_company_size" class="form-control select2">
                                                    <option value="0">All</option>
                                                    @if(@$company_size_obj)
                                                        @foreach($company_size_obj as $size)
                                                            <option value="{{@$size->id}}"  <?php @selected(Input::get('fk_company_size'), $size->id)?>>{{@$size->from}}-{{@$size->to}} employees</option>
                                                        @endforeach

                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-xs-6 col-sm-3 col-md-3 ">
                                                <label class="control-label"><span>Country</span></label>
                                                <select class="form-control" name="country">
                                                    <option value="">Please choose </option>
                                                    @foreach(get_countries_list() as $key => $val)
                                                        <option value="{{$key}}" @php @selected(@($_GET['country']), $key); @endphp >{{$val}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-6 col-sm-3 col-md-3">
                                                <label class="control-label" style="margin-top: 5px;"><span>State</span></label>
                                                <input type="text" name="province" pattern="^[A-Za-z\s]{1,191}$" title="Characters only" class="form-control" value="<?php echo @$_GET['province']; ?>">
                                            </div>

                                            <div class="col-xs-6 col-sm-3 col-md-3">
                                                <label class="control-label"style="margin-top: 5px;"><span>City</span></label>
                                                <input type="text" name="city" pattern="^[A-Za-z\s]{1,191}$" title="Characters only" class="form-control" value="<?php echo @$_GET['city']; ?>">
                                            </div>

                                            {{--<div class="col-xs-6 col-sm-3 col-md-2">--}}
                                            {{--<label class="control-label">By Country</label>--}}
                                            {{--<select class="form-control" name="country">--}}
                                            {{--<option value="0">Please choose</option>--}}
                                            {{--@foreach($countries as $key => $val)--}}
                                            {{--<option value="{{$key}}" >{{$val}}</option>--}}
                                            {{--@endforeach--}}
                                            {{--</select>--}}
                                            {{--</div>--}}

                                            <div class="col-xs-6 col-sm-3 col-md-3 ">
                                                <button type="submit" class="btn btn-default green margin-top-20 form-control" style="position: relative; top:8px;">
                                                    Filter Results <i class="fa fa-search"> </i>
                                                </button>
                                            </div>


                                        </div>
                                    </div>
                                </form>



                                <!-- TABLE -->
                                <table class="table table-responsive wt-bar-items border border-white" wt-sorting-table>
                                    <thead>
                                    <tr>
                                        <th width="3%" class="sorted"> # </th>
                                        <th> Logo </th>
                                        <th> Company name </th>
                                        <th> Agent name </th>
                                        <th> Industry Category </th>
                                        <th> Company Type </th>
                                        <th> Country </th>
                                        {{--<th> City </th>--}}
                                        {{--<th> Specialties </th>--}}
                                        {{--<th class="text-center not-sorted"> Action </th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(@!$companies_obj->isEmpty())

                                        @foreach(@$companies_obj as $key => $company_obj)
                                            <tr>
                                                <td>{{$count = (($key + 1)+($companies_obj->perPage()*($companies_obj->currentPage()-1)))}}</td>
                                                <td>
                                                    @if(@$company_obj->company_image->filename)
                                                    <img src="{{config('constants.base_url')}}/{{config('constants.company_logo_small')}}{{@$company_obj->company_image->filename}}" width="40">
                                                    @else
                                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"   width="40" />
                                                    @endif

                                                </td>
                                                <td><a href="{{url('company')}}/{{$company_obj->id}}" target="_blank">{{@$company_obj->name}}</a></td>
                                                <td><a href="{{url('users')}}/{{@$company_obj->created_by->id}}" target="_blank"> {{@$company_obj->created_by->first_name}} {{@$company_obj->created_by->last_name}}</a></td>
                                                <td>{{@\App\WC_Models\ProductType::find($company_obj->company_product_details->fk_product_type_id)->name}}</td>
                                                <td>{{@$company_obj->company_type_details->name}}</td>
                                                <td>{{@$countries[$company_obj->address_details->country]}}</td>
                                                {{--<td>{{@$company_obj->address_details->city}}</td>--}}
                                                {{--<td>--}}
                                                    {{--@if(@$company_obj->company_specialities)--}}
                                                        {{--@php $company_names = ''; @endphp--}}
                                                        {{--@foreach($company_obj->company_specialities as $company_speciality)--}}
                                                            {{--@php--}}
                                                                {{--$company_names .= $company_speciality->name.', ';--}}
                                                            {{--@endphp--}}
                                                        {{--@endforeach--}}

                                                        {{--{{rtrim($company_names,', ')}}--}}
                                                    {{--@else--}}
                                                        {{--<center>-</center>--}}
                                                    {{--@endif--}}

                                                {{--</td>--}}
                                                {{--<td class="text-center">--}}
                                                    {{--<a class="btn btn-icon-only btn-circle green" href="{{url('company')}}/{{$company_obj->id}}"><i class="fa fa-eye"></i></a>--}}
                                                {{--</td>--}}
                                            </tr>

                                            @endforeach
                                        @else
                                        <tr><td colspan="9">No any record found.</td></tr>
                                    @endif

                                    </tbody>
                                </table>
                                <!-- END TABLE -->
                                <center>
                                    {{@$companies_obj->render()}}
                                </center>
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