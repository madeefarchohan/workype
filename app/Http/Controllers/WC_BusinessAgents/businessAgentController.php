<?php

namespace App\Http\Controllers\WC_BusinessAgents;

use Illuminate\Http\Request;
use App\Company;
use App\WC_Models\CompanyType;
use App\WC_Models\CompanySize;
use App\WC_Models\ProductType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class businessAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $company_type_obj = CompanyType::all();
        $company_size_obj = CompanySize::all();
        $company_product_type = ProductType::all();

        $countries = get_countries_list();

        $perPage  = 20;

        $flag = 0;
        // if search filter is been set
        if($request->name || $request->fk_company_type || $request->fk_company_size ) {

            $flag =1;
            if($request->name !="0"  && $request->fk_company_type =="0" && $request->fk_company_size =="0" ) {
                
                $companies_obj = Company::where('name','like', '%' . $request->name . '%')->where('verified',1)->paginate($perPage);
            }
            
             
            if($request->name==""  && $request->fk_company_type !="0" && $request->fk_company_size =="0" ) {

                $companies_obj = Company::where('fk_company_type',$request->fk_company_type)->where('verified',1)->paginate($perPage);
            }

            if($request->name==""  && $request->fk_company_type =="0" && $request->fk_company_size !="0" ) {
                $companies_obj = Company::where('fk_company_size',$request->fk_company_size)->where('verified',1)->paginate($perPage);
            }

            if($request->name!=""  && $request->fk_company_type !="0" && $request->fk_company_size =="0" ) {
                $companies_obj = Company::where('name','like', '%' . $request->name . '%')
                                        ->where('fk_company_type',$request->fk_company_type)
                                        ->where('verified',1)->paginate($perPage);
            }

            if($request->name!=""  && $request->fk_company_type =="0" && $request->fk_company_size !="0" ) {
                $companies_obj = Company::where('name','like', '%' . $request->name . '%')
                    ->where('fk_company_size',$request->fk_company_size)
                    ->where('verified',1)->paginate($perPage);
            }

            if($request->name==""  && $request->fk_company_type !="0" && $request->fk_company_size !="0" ) {
                $companies_obj = Company::where('fk_company_type',$request->fk_company_type)
                    ->where('fk_company_size',$request->fk_company_size)
                    ->where('verified',1)->paginate($perPage);
            }

            if($request->name!=""  && $request->fk_company_type !="0" && $request->fk_company_size !="0" ) {
                $companies_obj = Company::where('fk_company_type',$request->fk_company_type)
                    ->where('fk_company_size',$request->fk_company_size)
                    ->where('name','like', '%' . $request->name . '%')
                    ->where('verified',1)->paginate($perPage);
            }


        } else {


        }

        if($request->country || $request->state || $request->city) {
            $flag = 1;

            $companies_obj =  Company::with('address')->whereHas('address', function($query)  use($request) {
               if($request->country) {
                   $query->whereCountry($request->country);
               }
                if($request->province) {
                    $query->whereProvince($request->province);

                }
                if($request->city) {
                    $query->whereCity($request->city);

                }

            })->paginate($perPage);


        }


        if($flag == 0) {
            $companies_obj = Company::latest()->where('verified',1)->paginate($perPage);
        }

        if($companies_obj) {
            // Append query string with pagination
             $companies_obj->appends(Input::except('page'));
        }




        return view('WC_BusinessAgents.list-business-agents', compact('countries','companies_obj','company_type_obj','company_size_obj','company_product_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
