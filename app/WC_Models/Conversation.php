<?php

namespace App\WC_Models;

use App\Company;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\WC_Models\Message;

class Conversation extends Model
{
    protected $table = 'wc_conversations';
    protected $fillable = array('id','subject','fk_company_id','fk_user_id','created_at','updated_at');
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class,'fk_user_id','id');
    }
    public function company(){
        return $this->belongsTo(Company::class,'fk_company_id','id');
    }
    public function conversation_users(){
        return $this->hasMany(ConversationUser::class,'fk_conversation_id','id');
    }
    public function last_message(){
         $message =  Message::where('fk_conversation_id',$this->id)->orderBy('id', 'desc')->first();
         if($message){
             if($message->type=='user_invited') {
                 format_invited_user_message($message->body);
             }
             elseif($message->type=='user_deleted')
             {
                 remove_user($message->body);
             }
             else
             {
                // echo $message->body;
                 return $message->body;
             }
         } else {
           //  echo '';
             return '';
         }
    }
}