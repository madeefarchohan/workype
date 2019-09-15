<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "wc_contacts";
    protected $fillable = ["phone" , "email","website","skype","fk_db_key","fk_id"];
    public $timestamps = true;
}
