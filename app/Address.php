<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'wc_addresses';
    protected $fillable = array('fk_db_key','fk_id','address','zip_code','city','province','country');
    public $timestamps = true;

   /* public function company() {

            return $this->belongsTo(Company::class,'fk_id','id');

    }
   */
}