<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Testing\MimeType;


class PivotUserCompanyRole extends Model
{
    protected $table = 'wc_pivot_user_company_roles';
    protected $fillable = ['fk_user_id','fk_company_id','fk_job_title_id','details'];
    protected $guarded = [];

//	public    function get_mime_from_extension(){
//
//
//		return $mime = MimeType::from($this->type);
//	}
}
