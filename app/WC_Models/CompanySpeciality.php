<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Testing\MimeType;


class CompanySpeciality extends Model
{
    protected $table = 'wc_company_specialities';
    protected $fillable = ['name','fk_company_id'];
    protected $guarded = [];
    public $timestamps = true;
}