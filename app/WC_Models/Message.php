<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    protected $table = 'wc_messages';
    protected $fillable = array('id','body','fk_conversation_id','fk_user_id','type','created_at','updated_at');
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class,'fk_user_id','id');
    }

    public function conversation(){
        return $this->belongsTo(Conversation::class,'fk_conversation_id','id');
    }
}