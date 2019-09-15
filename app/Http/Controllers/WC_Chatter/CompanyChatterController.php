<?php

namespace App\Http\Controllers\WC_Chatter;

use App\Company;
use App\WC_Models\Conversation;
use App\WC_Models\ConversationUser;
use App\WC_Models\Message;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveUserMessage as LeaveUserMessageNotification;
use App\Notifications\ChatterMessageSent as ChatterMessageSentNotification;
use DB;

class CompanyChatterController extends Controller
{

    public  function  chatter(){

        $conversations = $this->cur_user_conversations();

        return view('WC_Chatter.chatter_list' , compact('conversations'));
    }
    //leave chat
    public function leave_chat(Request $request)
    {
        //return 'hello'.$request->leave_user_id;exit;
        $leave_user_id = $request->leave_user_id;
        $conversation_id = $request->conversation_id;
        $conversation_create_user_id = $request->conversation_create_user_id;
        $user_create_obj = User::find($conversation_create_user_id);
        $user_obj = User::find($leave_user_id);
        $user_object = User::find(Auth::id());
        $status = [];
            $conversation_user_obj = ConversationUser::where(['fk_user_id'=>$leave_user_id,'fk_conversation_id'=>$conversation_id])->delete();
           if($conversation_user_obj) {

               $message_array = array();
               $message_array['deleted_from_id'] = $leave_user_id;
               $message_array['conversation_id'] =  $conversation_id;
               $msg = json_encode($message_array);
               $message = Message::create([
                   "type" => 'user_deleted',
                   "fk_conversation_id" => $conversation_id,
                   "fk_user_id" => $conversation_create_user_id,
                   'body' => $msg]);
               $conversation_obj = Conversation::find($conversation_id);
              // dd($conversation_obj);
               foreach ($conversation_obj->conversation_users as $conversation_user_obj) {

                   if ($conversation_user_obj->user->id != Auth::id()) {
                       Notification::send($conversation_user_obj->user, new LeaveUserMessageNotification($user_object, $conversation_id));
                   }
               }

               $status['success'] = 'User has been deleted successfully';

               return $status;

              // $status['deleted'] = "$user_obj->first_name is been deleted to chat from $user_create_obj->first_name";
              // return $status;
               exit;
           }
           else{
               $status['failure'] = 'Sorry user cannot exit.';
               return $status;
               exit;
           }


    }
   //show all chat logged in user
    public function user_chats()
    {

        $id = Auth::id();
        $conversations_users = ConversationUser::Where('fk_user_id', '=', $id)->get();
        $conversations = '';
        if ($conversations_users->count()) {
            $conversation_ids = array();
            foreach (@$conversations_users as $obj) {
                $conversation_ids[] = $obj->fk_conversation_id;
            }
            $ids_list =  implode(',', $conversation_ids);
            $conversations = DB::select("select * From wc_conversations where id IN ($ids_list)  ");
//            foreach ($results as $result)
//            {
//                echo $result->subject; exit;
//            }


//            $results = DB::select('SELECT * FROM wc_conversations m JOIN wc_conversations c ON c.id = m.fk_conversation_id
//                               WHERE m.ID IN ( SELECT MAX(ID) FROM wc_messages GROUP BY fk_conversation_id )
//                               GROUP BY m.fk_conversation_id HAVING c.id in('.$ids_list.')  order by m.id DESC');

            return view('WC_Chatter.user_all_chat', compact('conversations'));

        }

        else
            {
                flash('No any conversation found.')->error()->important();
                return view('WC_Chatter.user_all_chat');
            }
    }


    public function cur_user_conversations()
    {

        $id = Auth::id();
        $conversations_users = ConversationUser::Where('fk_user_id', '=',$id )->get();

        $conversations = '';
        if($conversations_users->count()) {
            $conversation_ids = array();
            foreach(@$conversations_users as $obj){
                $conversation_ids[] = $obj->fk_conversation_id;
            }

            $ids_list =  implode(',', $conversation_ids);

            $results = DB::select('SELECT * FROM wc_messages m JOIN wc_conversations c ON c.id = m.fk_conversation_id
                               WHERE m.ID IN ( SELECT MAX(ID) FROM wc_messages GROUP BY fk_conversation_id )
                               GROUP BY m.fk_conversation_id HAVING c.id in('.$ids_list.')  order by m.id DESC');



            // just to show proper sequence of messages
            unset($conversation_ids);
            $conversation_ids = array();
            foreach($results as $result){
                $conversation_ids[] = $result->id;
            }

            // dd($conversation_ids);

            $conversations = '';
            if(@$conversation_ids){
                $ids = implode(',', $conversation_ids);

                $conversations = Conversation::whereIn('id', $conversation_ids)->orderByRaw(DB::raw("FIELD(id, $ids)"))->get();
            }
        }




        return $conversations;

    }



//    public function cur_user_conversations()
//    {
//
//        $id = Auth::id();
//        $conversations_users = ConversationUser::Where('fk_user_id', '=',$id )->get();
//
//        $conversations = '';
//        if($conversations_users->count()) {
//            $conversation_ids = array();
//            foreach(@$conversations_users as $obj){
//                $conversation_ids[] = $obj->fk_conversation_id;
//            }
//
//            $ids_list =  implode(',', $conversation_ids);
//
//            $results = DB::select('SELECT * FROM wc_messages m JOIN wc_conversations c ON c.id = m.fk_conversation_id
//                               WHERE m.ID IN ( SELECT MAX(ID) FROM wc_messages GROUP BY fk_conversation_id )
//                               GROUP BY m.fk_conversation_id HAVING c.id in('.$ids_list.')  order by m.id DESC');
//
//
//
//            // just to show proper sequence of messages
//            unset($conversation_ids);
//            $conversation_ids = array();
//            foreach($results as $result){
//                $conversation_ids[] = $result->id;
//            }
//
//            // dd($conversation_ids);
//
//            $conversations = '';
//            if(@$conversation_ids){
//                $ids = implode(',', $conversation_ids);
//
//                $conversations = Conversation::whereIn('id', $conversation_ids)->orderByRaw(DB::raw("FIELD(id, $ids)"))->get();
//            }
//        }
//
//
//
//
//        return $conversations;
//
//    }
    public function user_exists_in_conversation($conversation_id, $user_id) {
        $conversation_obj = @Conversation::find($conversation_id);
        $user = User::find($user_id);
        $flag = 0;
        foreach($conversation_obj->conversation_users as $pivot_conversation_user_obj){
            if($pivot_conversation_user_obj->fk_user_id == $user->id) {
                $flag = 1;
                break;
            }
        }

        return $flag;

    }
    public  function send_message(Request $request){

        $response = array();
        // $response['msg'] = print_r($request->all(),1);
        $message_body = htmlspecialchars($request->body);
        $message = Message::create(["type"=>'text',"fk_conversation_id"=>$request->fk_conversation_id, "fk_user_id"=>Auth::id(),  'body'=>$message_body, ]);

        $user_obj = User::find(Auth::id());
        $conversation_obj = Conversation::find($request->fk_conversation_id);

        foreach($conversation_obj->conversation_users as $conversation_user_obj){

            if($conversation_user_obj->user->id !=Auth::id()){
                Notification::send($conversation_user_obj->user, new ChatterMessageSentNotification($user_obj, $request->fk_conversation_id, $message->id));
            }

        }

        return json_encode($response);
        exit;
    }
    public  function retrieve_messages(Request $request){

        $response = array();
        ob_start();

        $conversation_obj = Conversation::find($request->fk_conversation_id);
        $messages = Message::where('fk_conversation_id',$conversation_obj->id)->get();
        $total_messages_count = 0;
        if($messages){
            $total_messages_count = $messages->count();
            foreach($messages as $message) {

                if($message->type =='text') {

                    if($message->fk_user_id == Auth::id()) {
                        ?>
                        <div class="bubble me <?php if($message->type=='user_invited') echo 'user_invited'; ?> ">

                            <?php if(@Auth::user()->avatar->filename) {?>
                            <img class="chatter_pic img-circle img-responsive" width="30" height="30" title="<?php echo @Auth::user()->first_name. @Auth::user()->last_name. @Auth::user()->last_name ." ".$message->created_at->diffForHumans(); ?>" src="<?php echo config('constants.base_url').'/'.config('constants.user_avatar_large').@Auth::user()->avatar->filename?>" class="img-circle img-responsive" alt="">
                            <?php }else{?>
                            <span class="icon_i img-circle " title="<?php echo @Auth::user()->first_name. @Auth::user()->last_name. @Auth::user()->last_name ." ".$message->created_at->diffForHumans(); ?>"><i class="fa fa-user img-circle " width="30" height="30"></i></span>
                            <?php } ?>
                            <?php  echo ($message->type=='user_invited') ?  format_invited_user_message($message->body) :$message->body;  ?>
                        </div>
                        <?php
                    } else { ?>

                        <div class="bubble you <?php if($message->type=='user_invited') echo 'user_invited'; ?> ">

                            <?php if(@($message->user)->avatar->filename){?>
                            <img class="chatter_pic img-circle img-responsive" width="30" title="<?php echo @($message->user)->first_name." ".@($message->user)->last_name." "."(".$message->created_at->diffForHumans().")"; ?>" height="30" src="<?php echo config('constants.base_url').'/'.config('constants.user_avatar_large').($message->user)->avatar->filename?>" class="img-circle img-responsive" alt="">
                           <?php }else{?>
                            <span class="img-circle icon_img" title="<?php echo @($message->user)->first_name." ".@($message->user)->last_name." "."(".$message->created_at->diffForHumans().")"; ?>"><i class="fa fa-user " width="30" height="30"></i></span>
                            <?php }?>

                            <?php  echo ($message->type=='user_invited') ?  format_invited_user_message($message->body) :$message->body;  ?>
                        </div>

                        <?php
                    }



                }


                if($message->type =='user_invited') {

                    if($message->fk_user_id == Auth::id()) {
                        ?>
                        <div class="bubble me <?php if($message->type=='user_invited') echo 'user_invited'; ?> ">
                            <?php  echo ($message->type=='user_invited') ?  format_invited_user_message($message->body) :$message->body;  ?>
                        </div>
                        <?php
                    } else { ?>

                        <div class="bubble you <?php if($message->type=='user_invited') echo 'user_invited'; ?> ">
                            <?php  echo ($message->type=='user_invited') ?  format_invited_user_message($message->body) :$message->body;  ?>
                        </div>

                        <?php
                    }


                }



                if($message->type =='user_deleted') {
                    ?>

                    <div class="bubble you <?php if($message->type=='user_deleted') {echo "user_deleted"; }?>">
                    <?php echo remove_user($message->body); ?>
                    </div>
                    <?php

                }

            }
        }

        $response['html'] = ob_get_clean();
        $response['total_messages_count'] = $total_messages_count;


        return json_encode($response);
        exit;
    }





    public function add_user_in_conversation(Request $request) {

        $conversation_id = $request->fk_conversation_id;
        $user_id = $request->fk_user_id;



        $response = array();
        $exists =  $this->user_exists_in_conversation($conversation_id, $user_id);
        if($exists) {
            $response['flag'] = 'failure';
            $response['message'] = 'User already exists in conversation';

        } else {
            $user_added = ConversationUser::create(['fk_user_id' => $user_id, 'fk_conversation_id' => $conversation_id]);


            $conversation = Conversation::find($conversation_id);

            $invited_user_obj = User::find($user_id);
            $logged_user_obj = User::find(Auth::id());

            $message_array = array();
            $message_array['invited_from_id'] = $logged_user_obj->id;
            $message_array['invited_to_id'] = $invited_user_obj->id;
            $message_array['conversation_id'] = $conversation->id;
            $msg = json_encode($message_array);


            $message = Message::create([
                "type" => 'user_invited',
                "fk_conversation_id" => $conversation_id,
                "fk_user_id" => $user_id, 'body' => $msg]);

            $user_obj = User::find(Auth::id());
            $conversation_obj = Conversation::find($conversation_id);

            foreach ($conversation_obj->conversation_users as $conversation_user_obj) {

                if ($conversation_user_obj->user->id != Auth::id()) {
                    Notification::send($conversation_user_obj->user, new ChatterMessageSentNotification($user_obj, $conversation_id, $message->id));
                }
            }

            $response['flag'] = 'success';
            $response['message'] = 'A new user has been invited to chat.';

            ob_start(); ?>


            <li>
                <a href="javascript:;">
                <?php if (@$invited_user_obj->avatar->filename) { ?>
                    <img src ="<?php echo config('constants.base_url')."/".config('constants.user_avatar_large').@$invited_user_obj->avatar->filename?>">
                <?php } else { ?>
                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" class="" alt="">
                <?php }  ?>

                    <span class="name"> <?php echo @$invited_user_obj->first_name.' '.$invited_user_obj->last_name; ?></span>
                </a>

            </li>
            <?php
            $response['html'] = ob_get_clean();


        }
        return $response;
        exit;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company_id)
    {

        $conversation_id = @$_GET['conversation_id'];
        /* if($conversation_id) {


        } else {
           return redirect(url('chatter'));
        }
        */

        if($conversation_id) {
            $user_exists_in_conversation = $this->user_exists_in_conversation($conversation_id, Auth::id());
            if(!$user_exists_in_conversation) {
                echo "Sorry! you don't have permission to view this chat";exit;
            }

        }


        $conversation_obj = @Conversation::find($conversation_id);
        $messages = @Message::where('fk_conversation_id',$conversation_id)->get();
        $conversations = $this->cur_user_conversations();


        $company_obj = Company::find($company_id);
        $users_obj = User::all();



        return view('WC_Chatter.chatter' , compact('users_obj','conversations','conversation_obj','company_id','company_obj','messages'));


        /* if($request->invite_person)
         {
             $user_obj = User::all();
             //dd($user_obj->avatar);exit;
             //return view('WC_Chatters.chatter' , compact('user_obj'));
             $add_user = User::where('id',$request->invite_person)->first();
            // return view('WC_Chatters.chatter' , compact('add_user', 'user_obj'));
         }
         $user_obj = User::all();
     */
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $company_id)
    {


        $company_obj = Company::find($company_id);
        if(isset($request->btn_send_message) ){


           //mohsin some changing sir tauqeer work
            $body = strip_tags($request->body);
            Message::create([
                'body'=>$body,
                'fk_user_id'=>Auth::id(),
                'fk_conversation_id'=>$request->fk_conversation_id,
                'type'=>"text"
            ]);
            return back();

        }

        if(isset($request->btn_add_chat_subject) ) {

            $request->merge(['fk_company_id'=> $company_id]);
            $request->merge(['fk_user_id'=> Auth::id()]);
            $conversation_obj = new Conversation($request->all());
            $conversation_obj->save();



            // send message from primary contact of company

            if($company_obj->fk_user_primary){
                $primary_person = User::find($company_obj->fk_user_primary);
            } else{
                $primary_person = User::find($company_obj->fk_user_id);
            }

            // assign users to chat

            $converation_user_1 =  ConversationUser::create(['fk_user_id'=>Auth::id(), 'fk_conversation_id'=>$conversation_obj->id ]);
            $converation_user_2 = ConversationUser::create(['fk_user_id'=>$primary_person->id, 'fk_conversation_id'=>$conversation_obj->id ]);

            $message = Message::create([
                'body' => "Hello, i am primary contact of $company_obj->name, How may i help you?",
                'fk_user_id'=>$primary_person->id,
                'fk_conversation_id'=>$conversation_obj->id,
                'type'=>"text",

            ]);




            $user_obj = User::find(Auth::id());
            Notification::send($primary_person, new ChatterMessageSentNotification($user_obj,$conversation_obj->id, $message->id));

            return redirect(url('company').'/'.$company_id.'/chatter?conversation_id='.$conversation_obj->id);

        }




        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}