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
                                            <form method="post" action="{{url('company')}}/{{$company_id}}/chatter">
                                                @csrf



                                                <div class="input-group">
                                                    <div class="input-icon">
                                                        {{--<a href="#deleteModal" data-toggle="modal" class="btn btn-icon-only btn-circle red show-delete-modal" data-url=""><i class="icon-trash"></i></a>--}}

                                                        <input type="text" name="subject" ws-search="ws-searchable" class="search_chatter" placeholder="Type for search" />
                                                    </div>
                                                        {{--<span class="input-group-btn">--}}
                                                           {{--<button type="submit" name="btn_add_chat_subject" value="btn_add_chat_subject" class="btn btn-success" >Go</button>--}}
                                                        {{--</span>--}}
                                                </div>

                                            </form>

                                        </div>
                                        <ul class="people list-unstyled" ws-searchable="person-dummy">


                                            @if(@$conversations)
                                                @foreach($conversations as $conversation)
                                                    @if(@$conversation)

                                                    <li class="person-dummy  <?php if(isset($_GET['conversation_id']) && $_GET['conversation_id'] == $conversation->id) echo 'active';?>" data-chat="person1" title="{{$conversation->created_at->diffForHumans()}}" style="display: inline-block;">
                                                        <a href="{{url('company')}}/{{$conversation->fk_company_id}}/chatter?conversation_id={{$conversation->id}}" style="display:block">

                                                            @if(@($conversation->company)->company_image->filename)

                                                            <img src="{{config('constants.base_url')."/".config('constants.company_logo_small')}}{{@($conversation->company)->company_image->filename}}" alt="" />
                                                            @else
                                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" width="45" height="45" />

                                                            @endif

                                                            <span class="name" style="text-decoration: none; position: absolute;"><b>{{ str_limit($conversation->subject, 20) }}</b></span>
                                                            {{--<span class="time">{{$conversation->created_at->diffForHumans()}}</span>--}}
                                                                <span class="preview last_sms" style=" ">{{$conversation->first_name}} {{$conversation->last_name}}</span>
                                                                <?php $temp = $conversation->last_message();

                                                                ?>

                                                                <span class="last_sms">{{str_limit($temp,20)}} </span>

                                                        </a>    <span class="pull-right">({{@$conversation->created_at->diffForHumans()}})</span>
                                                                <?php unset($temp);?>

                                                        </a>

                                                    </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                    <div class="alert alert-danger margin-top-10">No any chat found</div>
                                            @endif


                                        </ul>
                                    </div>
                                    <div class="center bg-white">

                                        @if(isset($_GET['conversation_id']))
                                        <div class="top"><span>Subject: <span class="name">{{@$conversation_obj->subject}}</span></span></div>
                                        @else
                                            <div class="top"><span> Click on the relevant chat to see details</span></div>
                                        @endif

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
                                            @if(isset($_GET['conversation_id']))
                                            <div class="conversation-start">
                                                <span>{{$company_obj->name}}</span>
                                            </div>
                                            @else
                                                <div class="conversation-start">
                                                    <span>{{$company_obj->name}}</span>
                                                </div>
                                            @endif


                                            <div id="messages_container">
                                                @if($messages)

                                                    @foreach($messages as $message)

                                                       @if($message->type =='text')

                                                            @if($message->fk_user_id == Auth::id())

                                                                <div class="bubble me">
                                                                    @if(@Auth::user()->avatar->filename)
                                                                        <img id="auth_imges"  title="{{@Auth::user()->first_name}} {{@Auth::user()->last_name}} {{@Auth::user()->last_name}} ({{$message->created_at->diffForHumans()}})" class="chatter_pic logged_user_img img-circle img-responsive"  width="30" height="30" src="{{config('constants.base_url')}}/{{config('constants.user_avatar_large')}}{{@Auth::user()->avatar->filename}}" class="img-circle img-responsive" alt="">

                                                                    @else
                                                                        <span class="icon_i img-circle " title="{{@Auth::user()->first_name}} {{@Auth::user()->last_name}} ({{$message->created_at->diffForHumans()}})"><i class="fa fa-user img-circle "    width="30" height="30"></i></span>

                                                                        {{--<img class="chatter_pic img-circle img-responsive" width="30" height="30" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" class="img-responsive img-circle" alt="">--}}
                                                                    @endif

                                                                    {{$message->body}}
                                                                </div>
                                                            @else
                                                                <div class="bubble you   ">
                                                                    @if(@($message->user)->avatar->filename)
                                                                        <img class="chatter_pic img-circle img-responsive" title="{{@($message->user)->first_name}} {{@($message->user)->last_name}}  ({{$message->created_at->diffForHumans()}})"  width="30" height="30" src="{{config('constants.base_url')}}/{{config('constants.user_avatar_large')}}{{($message->user)->avatar->filename}}" class="img-circle img-responsive" alt="">
                                                                    @else
                                                                        <span class="img-circle icon_img" title="{{@($message->user)->first_name}} {{@($message->user)->last_name}} ({{$message->created_at->diffForHumans()}})"><i class="fa fa-user "   width="30" height="30"></i></span>
                                                                        {{--<img class="chatter_pic img-circle img-responsive" width="30" height="30" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" class="img-responsive img-circle" alt="">--}}
                                                                    @endif

                                                                    {{$message->body}}
                                                                </div>
                                                            @endif

                                                       @elseif($message->type =='user_invited')

                                                            @if($message->fk_user_id == Auth::id())
                                                                <div class="bubble me @if($message->type=='user_invited') {{"user_invited"}} @endif ">
                                                                    {{format_invited_user_message($message->body)}}
                                                                </div>
                                                            @else
                                                                <div class="bubble you @if($message->type=='user_invited') {{"user_invited"}} @endif ">
                                                                    {{format_invited_user_message($message->body)}}
                                                                </div>
                                                            @endif

                                                        @elseif($message->type =='user_deleted')
                                                           <div class="bubble you @if($message->type=='user_deleted') {{"user_deleted"}}  @endif">
                                                                {{remove_user($message->body)}}
                                                            </div>
                                                           @endif




                                                    @endforeach
                                                @endif
                                            </div>








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


                                            <div class="write" style="padding:0px">

                                                @if(isset($_GET['conversation_id']))
                                                <!--<a href="javascript:;" class="write-link attach"></a>-->
                                                <input type="text" id="message_body" name="body" placeholder="Write your message here" />



                                                <!-- <a href="javascript:;" class="write-link smiley"></a>-->
                                                <button id="btn_send_message" name="btn_send_message" value="btn_send_message" data-fk_conversation_id="{{@$_GET['conversation_id']}}" data-action="{{url('company')}}/{{$company_id}}/send_message" class="write-link send pull-right" style="background: none; border: none; padding: 0px;">
                                                    <i class="fa fa-send-o" style="position: relative;left: -20px;top: 8px;"></i>
                                                </button>
                                                @endif
                                            </div>


                                    </div>



                                    <div  class="left right" <?php if(!isset($_GET['conversation_id'])) echo 'style="display:none"';?>>

                                        <div class="top">
                                            <h4>Involved Persons
                                                 <a href="javascript:;" class="add-people pull-right"><i class="icon-plus"></i></a>
                                            </h4>
                                        </div>



                                        <ul class="people list-unstyled">


                                            <form method="post" action="#" id="invite_user_form">
                                                @csrf
                                                @if(@$conversation_obj)
                                                @foreach(@$conversation_obj->conversation_users as $pivot_conversation_user)
                                                <li>


                                                        @if(@$pivot_conversation_user->user->avatar->filename)
                                                            <a href="{{url('users')}}/{{@$pivot_conversation_user->user->id}}" target="_blank"> <img src="{{config('constants.base_url')}}/{{config('constants.user_avatar_large')}}{{@$pivot_conversation_user->user->avatar->filename}}" class="" style="margin-right: 0px;" alt=""></a>
                                                        @else
                                                            <a href="{{url('users')}}/{{@$pivot_conversation_user->user->id}}" target="_blank"> <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" class="" style="margin-right: 0px;" alt=""></a>
                                                        @endif

                                                        <span class="name user_add_in_chat" ><a href="{{url('users')}}/{{@$pivot_conversation_user->user->id}}" target="_blank">{{@$pivot_conversation_user->user->first_name}} {{@$pivot_conversation_user->user->last_name}}</a> </span>


                                                    @if(Auth::id() == $pivot_conversation_user->fk_user_id)
                                                        <a class="glyphicon glyphicon-remove   leave_conversation" value="{{@$pivot_conversation_user->user->id}}" val="{{@$pivot_conversation_user->fk_conversation_id}}" userid="{{@$conversation_obj->fk_user_id}}" redirecturl="{{url('user/chats')}}" url="{{url('leave/chat')}}" title="leave conversation" id="leave_user_id" style=" "> </a>
                                                     @endif

                                                </li>
                                                @endforeach
                                                 @endif


                                            <li class="people-list" style="display: none; padding: 15px">
                                                <select name="invite_person" class="form-control select2" data-placeholder="Please Select">

                                                        @foreach($company_obj->company_admins_user_obj() as $user_obj)
                                                            <option value="{{$user_obj->id}}">{{$user_obj->first_name}} {{$user_obj->last_name}}</option>
                                                        @endforeach

                                                </select>
                                                <button type="submit" class="btn green pull-right margin-top-10">invite</button>
                                            </li>

                                            <li><a href="javascript:;">
                                                    <img src="{{config('constants.base_url')}}/{{config('constants.user_avatar_small')}}{{@$add_user->avatar->filename}}" alt="" />
                                                    <span class="name">{{@$add_user->first_name}}</span>
                                                </a>
                                            </li>

                                            {{--<li><a href="javascript:;">--}}
                                                    {{--<img src="https://s3.postimg.org/yf86x7z1r/img2.jpg" alt="" />--}}
                                                    {{--<span class="name">Dog Woofson</span>--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                            </form>
                                        </ul>
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






    <?php
    if(!isset($_GET['conversation_id'])) {

    ?>

    <div class="modal fade " id="deleteModal" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
        <div class="modal-dialog   " >
            <div class="modal-content  " >


                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Write New Subject</h4>
                </div>


                <div>
                    <form method="post" action="{{url('company')}}/{{$company_id}}/chatter">
                    <div class="">



                        {{--<input type="hidden" name="_method" value="DELETE">--}}
                        <div class="modal-body">

                                @csrf
                                        <div class="bar-item">
                                        <div class="form-group">
                                        <input type="text" class="form-control" name="subject" placeholder="Enter your subject here" />
                                    </div>
                                        </div>

                                    </div>



                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="btn_add_chat_subject" value="btn_add_chat_subject" class="btn green" >Go</button>
                        {{--<button type="submit" name="btn_edit_department" value="submit" class="btn green">Delete</button>--}}
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>

                    </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<?php } ?>

@endsection

@section('chatter-messages')
     <?php
    if(isset($_GET['conversation_id'])) {

    ?>
    <script>



        $(document).ready(function () {
            setInterval(function(){
                total_messages_count = $("#messages_container").children().length;
                $.ajax({
                    type: "GET",
                    url:  "<?php echo url('company')."/".$company_id."/retrieve_messages"; ?>",
                    dataType: "JSON",
                    //method:"post",
                    data: { 'total_messages_count': total_messages_count, 'fk_conversation_id' : "<?php echo $_GET['conversation_id'];?>" },
                    success: function (data) {
                       // alert(total_messages_count);
                       // alert(data.total_messages_count);

                        if(total_messages_count == data.total_messages_count) {
                        }else {
                            $("#messages_container").empty();
                            $("#messages_container").html(data.html);

                            $('.chat.active-chat').scrollTop(($('.chat.active-chat').height())+5000)
                        }
                    },
                    error: function (jqXHR, exception) {   // when return null
                        // $('.load-more-spinner').fadeOut('slow');
                        // $this.find('span').text('Error Occured!');
                        // processing = false;
                    }
                });


            }, 10000);


            $(document).on("submit", "form#invite_user_form", function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url:  "<?php echo url('company')."/".$company_id."/invite_user_in_chat"; ?>",
                    dataType: "JSON",
                    //method:"post",
                    data: {'fk_conversation_id' : "<?php echo $_GET['conversation_id'];?>", 'fk_user_id':$('[name=invite_person]').val()  },
                    success: function (response) {
                        if(response.flag == 'success') {
                            // alert('User has been invited to chat.');
                            $('.add-people').trigger('click');

                            // alert(response.html);
                            $('.people-list').before(response.html);

                        }

                        if(response.flag == 'failure') {
                            alert(response.message);
                            $('.add-people').trigger('click');
                        }

                    },
                    error: function (jqXHR, exception) {   // when return null
                        // $('.load-more-spinner').fadeOut('slow');
                        // $this.find('span').text('Error Occured!');
                        // processing = false;
                    }
                });

            });
        });





    </script>
    <?php
    }
    ?>
    @endsection