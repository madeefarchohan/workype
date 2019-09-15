<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ConversationUser extends Model
{
    protected $table = 'wc_conversation_users';
    protected $fillable = array('fk_user_id','fk_conversation_id','created_at','updated_at');
    public $timestamps = true;

     public function user(){
        return $this->belongsTo(User::class,'fk_user_id','id');
    }

    public function conversation(){
        return $this->belongsTo(Conversation::class,'fk_conversation_id','id');
    }

}