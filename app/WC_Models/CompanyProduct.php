<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Testing\MimeType;


class CompanyProduct extends Model
{
    protected $table = 'wc_company_products';
    protected $guarded = [];
    protected  $fillable = ['fk_company_id','title','overview','features','benefits'];

    protected $casts = [
        'features' => 'array',
        'benefits' => 'array',

    ];

    public function product_image(){
        return $this->hasOne(Media::class,'fk_id')->where('wc_media.fk_db_key', '=', 'product_logo_image');
    }

    public function product_gallery(){
        return $this->hasMany(Media::class,'fk_id')->where('wc_media.fk_db_key', '=', 'company_product_gallery_images');
    }
}