<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'wc_addresses';
    protected $fillable = array('fk_db_key','fk_id','address','zip_code','city','province','country');
}