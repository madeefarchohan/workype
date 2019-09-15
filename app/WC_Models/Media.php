<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Testing\MimeType;


class Media extends Model
{
    protected $table = 'wc_media';

    protected $guarded = [];

//	public    function get_mime_from_extension(){
//
//
//		return $mime = MimeType::from($this->type);
//	}
}
