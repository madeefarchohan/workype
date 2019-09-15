<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class CompanyAdmin extends Model
{
    protected $table = 'wc_company_admins';
    protected $fillable = array('fk_company_id','fk_user_id');
    public  $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user_id','id');
    }

}