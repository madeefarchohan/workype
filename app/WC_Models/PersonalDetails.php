<?php

namespace App\WC_Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PersonalDetails extends Model
{
    protected $table = 'wc_personal_details';
    protected $fillable = ['gender','date_of_birth','nationality','fk_user_id'];

    public function user(){
        return $this->belongsTo(User::class,'fk_user_id','id');
    }
    /*public function getFullNameAttribute($value){
        return ucfirst($this->first_name)." ".ucfirst($this->last_name);
    }*/

   /* public function setDateOfBirthAttribute($value)
    {
        if($value!=null) {
            return $this->attributes['date_of_birth'] = date(config('constants.default_date_php'), strtotime($value));
        }else{
            return null;
        }
    }

    public function getDateOfBirthAttribute($value)
    {
        if($value != null)
            return \Carbon\Carbon::parse($value)->format(config('constants.date_format'));
        else
            return null;
    }*/
}
