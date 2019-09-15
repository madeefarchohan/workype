@extends('layouts.backend')
@section('content')

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
                        <div class="">


                            <div class="wrapper">
                                <div class="wrapper-container">
                                    {{--<div class="left"></div>--}}
                                    </div>
                                @if(!empty($conversations))
                                    <div class="center bg-white col-md-9 pre-scrollable chatter_container" style="">

                                            @foreach($conversations as $conversation)
                                        <div class="note note-info">
                                            <div class="top"><h4 style="float: left; "><b>Subject: </b></h4> <span class="name" style="color:#01a5c8; margin-left: 10px; ">{{@$conversation->subject}}</span></div>
                                                 {{--<form action="{{url('company')}}/{{$result->fk_company_id}}/chatter?conversation_id={{$result->id}}">--}}
                                                    <center><button class="btn btn-lg  fa fa-caret-down" onclick='window.location.href="{{url('company')}}/{{$conversation->fk_company_id}}/chatter?conversation_id={{$conversation->id}}"' style="margin-top: 10px;">  Show more</button></center>
                                                 {{--</form>--}}
                                        </div>
                                            @endforeach
                                        </div>
                                @else
                                    <div class="note note-info col-md-9" style="margin-left: 100px;">
                                        @include('flash::message')
                                    </div>
                                @endif
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
    </div>




@endsection
