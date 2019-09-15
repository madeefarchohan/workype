
    <form role="form" class="workype-search" method="get" action="{{url('business-agents')}}">
        <input type="hidden" id="search_fk_company_type" name="fk_compnay_type" value="{{@$_GET['fk_company_type'] ?? 0}}" />
        <input type="hidden" name="fk_company_size" value="0" />


        <div class="row">
            <div class="col-md-12">
                <div class="input-group input-group-lg">
                    <div class="input-group-btn">
                        <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown">Action
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu">


                            @foreach(@get_company_types() as $company_type)
                                <li class="company-type-list" data-company_type="{{$company_type->id}}"><a href="javascript:;">{{$company_type->name}}</a></li>
                            @endforeach

                            <li class="divider"> </li>
                            <li class="reset company-type-list" data-company_type="0"><a href="javascript:;"> Reset Action </a></li>
                        </ul>
                    </div>
                    <!-- /btn-group -->

                    <input type="text" class="form-control" name="name" value="{{@$_GET['name']}}">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <!-- /btn-group -->
                </div>
                <!-- /input-group -->
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <div class="workype-search-append margin-top-10"></div>
    </form>
