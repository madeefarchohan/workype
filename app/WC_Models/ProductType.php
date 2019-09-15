<?php

namespace App\WC_Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Http\Testing\MimeType;


class ProductType extends Model
{
    protected $table = 'wc_product_types';
    protected $guarded = [];
    public $timestamps = false;
}