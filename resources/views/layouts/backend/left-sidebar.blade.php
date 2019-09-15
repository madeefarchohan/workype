
<div class="col-md-3 col-sm-3 col-xs-3">
    <ul class="nav nav-tabs tabs-left">



        {{--{{@Route::currentRouteName() }}--}}
        {{--{{@Route::currentRouteAction()}}--}}




        <?php
         $action = request()->route()->getAction();
        $name_method  = class_basename($action['controller']);
        $name_method_arr = explode('@',$name_method);
            $current_controller_name = $name_method_arr[0];
           $current_controller_method = $name_method_arr[1];

        ?>



        <li class="@if($current_controller_name == "CompanyController" && !isset($_GET['tab'])) active @endif">
            <a href="{{url('company')}}/{{$company_obj->id}}/edit" dummy-data-toggle="tab"> Company </a>
        </li>
        <li class="@if($current_controller_name == "CompanyProductsController") active @endif">
            <a href="{{url('company')}}/{{$company_obj->id}}/products"  > Products </a>
        </li >

        <li class="@if($current_controller_name == "companyPostsController") active @endif">
            <a href="{{url('company')}}/{{$company_obj->id}}/posts"  > Posts </a>
        </li >

        <li class="@if($name_method == "CompanyController@edit" && @$_GET['tab']=='technology') active @endif">
            <a href="{{url('company')}}/{{$company_obj->id}}/edit?tab=technology" > Technology </a>
        </li>
        <li class="@if($name_method == "CompanyController@edit" && @$_GET['tab']=='convention') active @endif">
            <a href="{{url('company')}}/{{$company_obj->id}}/edit?tab=convention" > Convention </a>
        </li>
        <li class="@if($name_method == "CompanyController@edit" && @$_GET['tab']=='contact') active @endif">
            <a href="{{url('company')}}/{{$company_obj->id}}/edit?tab=contact" > Contact Details </a>
        </li>


        <li class="@if($name_method == "CompanyController@edit" && @$_GET['tab']=='settings') active @endif">
            <a href="{{url('company')}}/{{$company_obj->id}}/edit?tab=settings" > Admins </a>
        </li>



        <!-- <li class="disabled" style="cursor: not-allowed;" >
            <a href="javascript:void(0)" data-toggle="tab" style="pointer-events: none;"> Address </a>
        </li>
        <li class="disabled" style=" cursor: not-allowed;">
            <a href="javascript:void(0)" data-toggle="tab" style="pointer-events: none;"> Contact </a>
        </li>-->

        <!--
        <li class="disabled">
            <a href="javascript:void(0)" data-toggle="tab"> Upload Media </a>
        </li>
        <li class="disabled">
            <a href="javascript:void(0)" data-toggle="tab"> Posts  </a>
        </li>
        -->

    </ul>
</div>