<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyCompany extends Model
{
    protected $guarded = ["id"];
    public $timestamps=true;

    
    
    public function Company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }
}