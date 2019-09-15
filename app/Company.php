<?php

namespace App;

use App\WC_Models\CompanyAdmin;
use App\WC_Models\CompanySize;
use App\WC_Models\CompanyType;
use App\WC_Models\PivotCompanyProduct;
use App\WC_Models\PivotUserCompanyRole;
use App\WC_Models\CompanySpeciality;
use Illuminate\Support\Facades\Auth;
use App\WC_Models\CompanyProduct;

use Illuminate\Database\Eloquent\Model;
use App\WC_Models\Media;
use App\WC_Models\CompanyPost;

class Company extends Model
{
    protected $table = "wc_companies";
    protected $fillable = ["fk_user_id","name","description","fk_company_type","established_year","fk_company_size","fk_user_help","fk_user_primary","technology","convention","verified"];
    public $timestamps = true;
    public  static $company_product;


    public function verifyCompany()
    {
        return $this->hasOne('App\VerifyCompany');
    }

    public function contact(){
        return $this->hasOne(Contact::class,'fk_id')->where('wc_contacts.fk_db_key', '=', 'company');
    }

    public function address_details(){
        return $this->hasOne(Address::class,'fk_id')->where('wc_addresses.fk_db_key', '=', 'company');
    }

    public function address(){
        return $this->hasOne(Address::class,'fk_id')->where('wc_addresses.fk_db_key', '=', 'company');
    }


    public function user_company_role(){
        // return $this->hasOne(PivotUserCompanyRole::class,'fk_company_id');
        $user_id = Auth::id();
        return $this->hasOne(PivotUserCompanyRole::class,'fk_company_id')->where('wc_pivot_user_company_roles.fk_user_id', '=', "$user_id");
    }


    public function company_specialities()
    {
        return $this->hasMany(CompanySpeciality::class, 'fk_company_id');
    }

    public function company_admins()
    {
        return $this->hasMany(CompanyAdmin::class, 'fk_company_id','id');
    }


    public function company_product_details()
    {
        return $this->hasOne(PivotCompanyProduct::class,'fk_company_id');
    }


    public function company_admins_arr(){
        $arr = array();
        if($this->company_admins){
            foreach($this->company_admins as $company_admin) {
                $arr[] =$company_admin->fk_user_id;
            }
        }

        return $arr;

    }


    public function company_admins_user_obj(){
        $arr = array();
        if($this->company_admins){
            foreach($this->company_admins as $company_admin) {
                $arr[] = User::find($company_admin->fk_user_id);
            }
        }

        return $arr;

    }


    public function products(){
        return $this->hasMany(CompanyProduct::class,'fk_company_id','id');
    }
// by developer: Mohsin
    public function posts()
    {
        return $this->hasMany(CompanyPost::class,'fk_company_id','id');
    }


    public function company_size_details()
    {
        return $this->belongsTo(CompanySize::class, 'fk_company_size','id');
    }
    public function company_type_details()
    {
        return $this->belongsTo(CompanyType::class, 'fk_company_type','id');
    }
    //changing
    public function company_primary_actor()
    {
        return $this->belongsTo(User::class,'fk_user_primary','id');
    }
    public function company_help_contact()
    {
        return $this->belongsTo(User::class,'fk_user_help','id');
    }

    /*Tauqeer */

    public function company_image(){
        return $this->hasOne(Media::class,'fk_id')->where('wc_media.fk_db_key', '=', 'company_logo_image');
    }

/*Mohsin*/
    public function created_by()
    {
        return $this->belongsTo(User::class, 'fk_user_id','id');
    }



}