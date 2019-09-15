<?php

namespace App\WC_Models;
use App\WC_Models\Media;

use Illuminate\Database\Eloquent\Model;

class CompanyPost extends Model
{
    protected $table = "wc_posts";
    protected $fillable = ['title','description','fk_company_id','fk_by'];
    public $timestamps = true;

    public function post_image(){
        return $this->hasOne(Media::class,'fk_id')->where('wc_media.fk_db_key', '=', 'post_logo_image');
    }
    public function post_gallary_image()
    {
        return $this->hasMany(Media::class,'fk_id')->where('wc_media.fk_db_key', '=', 'company_post_gallery_images');
    }


}
