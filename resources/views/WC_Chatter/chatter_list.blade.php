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
                                    <div class="left">
                                        <div class="top">
                                            {{--<form method="post" action="{{url('company')}}/{{$company_id}}/chatter">--}}
                                                {{--@csrf--}}

                                                {{--<input type="text" name="subject" placeholder="Write new subject" />--}}
                                                {{--<button type="submit" name="btn_add_chat_subject" value="btn_add_chat_subject" class="search"><i class="fa fa-search"></i></button>--}}
                                            {{--</form>--}}
                                            <p>Click on the chat section for details</p>

                                        </div>
                                        <ul class="people list-unstyled">


                                            @if(@$conversations)
                                                @foreach($conversations as $conversation)

                                                    <li class="person-dummy" data-chat="person1" title="{{$conversation->created_at->diffForHumans()}}">
                                                        <a href="{{url('company')}}/{{$conversation->fk_company_id}}/chatter?conversation_id={{$conversation->id}}">


                                                            <img src="{{config('constants.base_url')."/".config('constants.company_logo_small')}}{{($conversation->company)->company_image->filename}}" alt="" />
                                                            <span class="name">{{$conversation->subject}}</span>
                                                            {{--<span class="time">{{$conversation->created_at->diffForHumans()}}</span>--}}
                                                            <span class="preview">{{$conversation->first_name}} {{$conversation->last_name}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <div class=" margin-top-10 alert alert-danger">No any chat record found</div>
                                            @endif

                                        </ul>
                                    </div>
                                    <div class="center bg-white">

                                        {{--<div class="top"><span>Subject: <span class="name">{{$conversation_obj->subject}}</span></span></div>--}}


                                        <div class="chat" data-chat="person1">
                                            <div class="conversation-start">
                                                <span>Today, 6:48 AM</span>
                                            </div>
                                            <div class="bubble you">
                                                Hello,
                                            </div>
                                            <div class="bubble me">
                                                it's me.
                                            </div>
                                            <div class="bubble you">
                                                I was wondering...
                                            </div>
                                        </div>
                                        <div class="chat" data-chat="person2">
                                            {{--<div class="conversation-start">--}}
                                                {{--<span>Today, 5:38 PM</span>--}}
                                            {{--</div>--}}

                                            {{--<div id="messages_container">--}}
                                                {{--@if($messages)--}}
                                                    {{--@foreach($messages as $message)--}}
                                                        {{--@if($message->fk_user_id == Auth::id())--}}
                                                            {{--<div class="bubble me">--}}
                                                                {{--{{$message->body}}--}}
                                                            {{--</div>--}}
                                                        {{--@else--}}
                                                            {{--<div class="bubble you">--}}
                                                                {{--{{$message->body}}--}}
                                                            {{--</div>--}}
                                                        {{--@endif--}}
                                                    {{--@endforeach--}}
                                                {{--@endif--}}
                                            {{--</div>--}}








                                        </div>
                                        <div class="chat" data-chat="person3">
                                            <div class="conversation-start">
                                                <span>Today, 3:38 AM</span>
                                            </div>
                                            <div class="bubble you">
                                                Hey human!
                                            </div>
                                            <div class="bubble you">
                                                Umm... Someone took a shit in the hallway.
                                            </div>
                                            <div class="bubble me">
                                                ... what.
                                            </div>
                                            <div class="bubble me">
                                                Are you serious?
                                            </div>
                                            <div class="bubble you">
                                                I mean...
                                            </div>
                                            <div class="bubble you">
                                                It’s not that bad...
                                            </div>
                                            <div class="bubble you">
                                                But we’re probably gonna need a new carpet.
                                            </div>
                                        </div>
                                        <div class="chat" data-chat="person4">
                                            <div class="conversation-start">
                                                <span>Yesterday, 4:20 PM</span>
                                            </div>
                                            <div class="bubble me">
                                                Hey human!
                                            </div>
                                            <div class="bubble me">
                                                Umm... Someone took a shit in the hallway.
                                            </div>
                                            <div class="bubble you">
                                                ... what.
                                            </div>
                                            <div class="bubble you">
                                                Are you serious?
                                            </div>
                                            <div class="bubble me">
                                                I mean...
                                            </div>
                                            <div class="bubble me">
                                                It’s not that bad...
                                            </div>
                                        </div>
                                        <div class="chat" data-chat="person5">
                                            <div class="conversation-start">
                                                <span>Today, 6:28 AM</span>
                                            </div>
                                            <div class="bubble you">
                                                Wasup
                                            </div>
                                            <div class="bubble you">
                                                Wasup
                                            </div>
                                            <div class="bubble you">
                                                Wasup for the third time like is <br />you blind bitch
                                            </div>

                                        </div>
                                        <div class="chat" data-chat="person6">
                                            <div class="conversation-start">
                                                <span>Monday, 1:27 PM</span>
                                            </div>
                                            <div class="bubble you">
                                                So, how's your new phone?
                                            </div>
                                            <div class="bubble you">
                                                You finally have a smartphone :D
                                            </div>
                                            <div class="bubble me">
                                                Drake?
                                            </div>
                                            <div class="bubble me">
                                                Why aren't you answering?
                                            </div>
                                            <div class="bubble you">
                                                howdoyoudoaspace
                                            </div>
                                        </div>


                                            {{--<div class="write">--}}
                                                {{--<!--<a href="javascript:;" class="write-link attach"></a>-->--}}
                                                {{--<input type="text" id="message_body" name="body" placeholder="Write your message here" />--}}

                                                {{--<!-- <a href="javascript:;" class="write-link smiley"></a>-->--}}
                                                {{--<button name="btn_send_message" value="btn_send_message" data-fk_conversation_id="{{@$_GET['conversation_id']}}" data-action="{{url('company')}}/{{$company_id}}/send_message" class="write-link send" style="background: none; border: none;"></button>--}}

                                            {{--</div>--}}


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

@section('chatter-messages')

    @endsection