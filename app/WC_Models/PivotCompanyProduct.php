<?php

namespace App\WC_Models;

use App\Company;
use Illuminate\Database\Eloquent\Model;

class PivotCompanyProduct extends Model
{
    protected $table = 'wc_pivot_company_products';
    protected $fillable = ['fk_company_id','fk_product_type_id'];
    protected $guarded = [];
    public $timestamps = true;

//    public function product()
//    {
//        return $this->belongsTo(ProductType::class);
//    }
}
