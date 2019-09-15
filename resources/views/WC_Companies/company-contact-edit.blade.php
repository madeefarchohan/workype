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
                                    {{--<div class="actions">--}}

                                        {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                                            {{--<i class="fa fa-question"></i>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="portlet-body margin-bottom-20">
                                    <div class="row">


                                        @include('layouts.backend.left-sidebar')



                                        <form role="form" class=""  method="post" action="{{url('/company/'.$company_obj->id)}}" enctype="multipart/form-data">

                                            @csrf
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
                                                        <div class="col-sm-12"><h5 class="bold">Headquarter</h5><hr/></div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group clearfix">
                                                                    <label class="control-label col-md-4">Address</label>
                                                                    <div class="col-md-8">
                                                                        <textarea name="address" class="form-control address-field">{{@$company_obj->address_details->address}}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group clearfix">
                                                                    <label class="control-label col-md-4">Zip Code</label>
                                                                    <div class="col-md-8">
                                                                        <input type="number" title="Numbers only" name="zip_code" class="form-control" value="{{@$company_obj->address_details->zip_code}}" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group clearfix">
                                                                    <label class="control-label col-md-4">City</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="city" pattern="^[A-Za-z\s]{1,191}$" title="Characters only" class="form-control" placeholder="" value="{{@$company_obj->address_details->city}}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group clearfix">
                                                                    <label class="control-label col-md-4">Province</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="province" pattern="^[A-Za-z\s]{1,191}$" title="Characters only"  class="form-control" placeholder="" value="{{@$company_obj->address_details->province}}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group clearfix">
                                                                    <label class="control-label col-md-4">Country</label>
                                                                    <div class="col-md-8">
                                                                        <div class="wtSelect">
                                                                            <select class="form-control" name="country">
                                                                                <option value="">Please choose country</option>
                                                                                @foreach(get_countries_list() as $key => $val)
                                                                                    <option value="{{$key}}" @php @selected($company_obj->address_details->country, $key); @endphp >{{$val}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <input type="hidden" name="_method" value="PUT">
                                                    <div class="row">








                                                        <div class="col-sm-12"><h5 class="bold">Contact Information</h5><hr/></div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group clearfix">
                                                                <label class="control-label col-md-4">Primary Contact</label>
                                                                <div class="col-md-8">
                                                                    <select name="fk_user_primary" class="form-control select2">
                                                                        <option value="{{$company_obj->created_by->id}}">{{@$company_obj->created_by->first_name}} {{@$company_obj->created_by->last_name}}</option>
                                                                        @foreach($company_admins as $company_admin)


                                                                            <option value="{{$company_admin->user->id}}" {{ ( $company_admin->user->id == $company_obj->fk_user_primary ? "selected":"") }} >{{$company_admin->user->username}}</option>

                                                                        @endforeach
                                                                    </select>                                                                </div>
                                                            </div>
                                                            <div class="form-group clearfix">
                                                                <label class="control-label col-md-4">User Help</label>
                                                                <div class="col-md-8">
                                                                    <select  name="fk_user_help" class="form-control select2">
                                                                        <option value="{{$company_obj->created_by->id}}">{{@$company_obj->created_by->first_name}} {{@$company_obj->created_by->last_name}}</option>
                                                                        @foreach($company_admins as $company_admin)

                                                                            <option value="{{$company_admin->user->id}}" {{ ( $company_admin->user->id == $company_obj->fk_user_help ? "selected":"") }}  >{{$company_admin->user->username}}</option>
                                                                        @endforeach
                                                                    </select>                                                                </div>
                                                            </div>
                                                        </div>





                                                        {{--<div class="col-sm-6">--}}
                                                            {{--<label>This person will be a communication channel when other companies & users contact your company & employees</label>--}}
                                                        {{--</div>--}}

                                                    {{--</div>--}}








                                                        {{--<div class="col-sm-6">--}}
                                                            {{--<label>This person will help other companies & users on finding right employees in your company</label>--}}
                                                        {{--</div>--}}


                                                        <div class="col-sm-6">
                                                            <div class="form-group clearfix">
                                                                <label class="control-label col-md-4">Contact Number</label>
                                                                <div class="col-md-8">
                                                                    <label class="control-label visible-ie8 visible-ie9">Number</label>
                                                                    <input class="form-control placeholder-no-fix" name="phone" value="{{$company_obj->contact->phone}}" type="number" placeholder="Number .." />
                                                                </div>
                                                            </div>
                                                            <div class="form-group clearfix">
                                                                <label class="control-label col-md-4">Skype Id</label>
                                                                <div class="col-md-8">
                                                                    <label class="control-label visible-ie8 visible-ie9">Skype Id</label>
                                                                    <input class="form-control placeholder-no-fix" name="skype" value="{{$company_obj->contact->skype}}" type="text" placeholder="Skype Id .." />
                                                                </div>
                                                        </div>





                                                        {{--<div class="col-sm-6">--}}
                                                            {{--<label>Contact Number</label>--}}
                                                        {{--</div>--}}




                                                        {{--<div class="col-sm-6">--}}
                                                            {{--<label>Skype Id</label>--}}
                                                        {{--</div>--}}
                                                        </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group clearfix">
                                                                    <label class="control-label col-md-4">Website</label>
                                                                    <div class="col-md-8">
                                                                        <input name="website" value="{{$company_obj->contact->website}}" type="text" data-type="url" class="form-control" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <div class="col-sm-6">
                                                                <div class="form-group clearfix">
                                                                    <label class="control-label col-md-4">Email</label>
                                                                    <div class="col-md-8">
                                                                        <input name="email" value="{{$company_obj->contact->email}}" type="email" class="form-control" >
                                                                    </div>
                                                                </div>
                                                            </div>














                                                    </div>




                                                    <hr/>

                                                    <div class="form-actions pull-left">
                                                        <input  type="submit" name="btn_company_contact" value="submit" class="btn btn-success uppercase ">
                                                        <button type="reset" class="btn btn-default uppercase ">Reset</button>
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