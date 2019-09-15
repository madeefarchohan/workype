<?php

namespace App\Http\Controllers;

use App\WC_Models\CompanyAdmin;
use App\WC_Models\CompanyProduct;
use App\WC_Models\CompanySize;
use App\WC_Models\CompanySpeciality;
use App\WC_Models\CompanyType;
use App\WC_Models\PivotCompanyProduct;
use App\WC_Models\ProductType;
use App\WC_Models\JobTitle;
use App\WC_Models\PivotUserCompanyRole;
use Illuminate\Http\Request;
use App\Mail\CompanyVerifyMail;
use Illuminate\Support\Facades\Mail;
use App\Company;
use App\Address;
use App\Contact;
use App\VerifyCompany;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\WC_Models\Media;
use Intervention\Image\ImageManager;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('company_verified', ['only' => ['show', 'destroy', 'edit', 'update']]);

        $this->middleware('manage_company', ['only' => ['edit', 'update']]);
        // $this->middleware('admin', ['only' => ['store','index']]);
    }

    public function delete_company_admin($id, Request $request)
    {
        $company_admin = CompanyAdmin::find($id);
        if($company_admin) {
            $company_admin->delete();
            return back()->with('status', 'Infomation deleted successfully');
        }
        else{
            return back()->with('error', 'Some thing not right');
        }
    }


    public function admins(Request $request, $id)
    {

        $company_obj = Company::find($id);
        if ($company_obj) {
            if ($company_obj->fk_user_id == Auth::id()) {


                $request->merge(['fk_user_id' => Auth::id()]);

                if ($company_obj->company_admins()) {
                    $company_obj->company_admins()->delete();
                }
                if (@$request->admins) {
                    foreach ($request->admins as $admin) {
                        if ($admin) {
                            $company_obj->company_admins()->create(['fk_user_id' => $admin, 'fk_company_id' => $company_obj->id]);
                        }

                    }

                }


                return back()->with('status', 'Infomation saved successfully');
            }
        }
    }


    public function register(Request $request)
    {
        $flag = 0;
        $user_id = Auth::id();
        $job_titles = JobTitle::all();

        //$request->session()->flush();
        //return view('register-company' , compact('user_id'))->with('email_verify','your email successfully verified');
        //$request->session()->flash('email_verify','Your email successfully verified');
        //session()->get('email_verify')
        // print_r(trans('auth.throttle'));
        return view('register-company', compact('user_id', 'job_titles'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $companies_obj = Company::where('fk_user_id', Auth::id())->where('verified', 1)->orderBy('id', 'DESC')->paginate(20);
        $companies_obj = Company::where('fk_user_id', Auth::id())->orderBy('id', 'DESC')->paginate(20);
        return view('WC_Companies.list-companies', compact('companies_obj'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $company_types = CompanyType::all();
        $product_types = ProductType::all();
        $company_size = CompanySize::all();
        $job_titles = JobTitle::all();

        return view('WC_Companies.create-company', compact('company_types', 'product_types', 'company_size', 'job_titles'));
        // return view('WC_Companies.create-company');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
//        $ilen = count($request->specialities);
//        dd($ilen);
        //dd($request->all());

        if (isset($request->create_company)) {
            $company_create_validation = $request->validate([
                'name' => 'required',
                'fk_company_type' => 'required',
                // 'fk_product_type_id' => 'required',
                'fk_company_size' => 'required',
                'website' => ['required', 'regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
                // 'fk_job_title_id' => 'required',
                // 'specialities' => 'required',
                'email' => 'required|email',
                'description' => 'required'
            ]);


        }
//        if($request->own_product)
//        {
//
//        }


        $logged_user_id = Auth::id();
        $request->merge(['fk_user_id' => $logged_user_id]);


        if (isset($request->reg_company) || $request->create_company) {
            $valid = [
                'name' => 'required|string|unique:wc_companies',
                'email' => 'required|email',
                'website' => ['required', 'regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
                //'fk_job_title_id' => 'required',

            ];
            if ($request->reg_company) {
                $valid["tnc"] = "required";
            }

            $company_validate_data = $request->validate($valid);


            $company_obj = new Company($request->all());

            $company_obj_saved = $company_obj->save();
            if ($company_obj_saved) {
                $request->merge(['fk_db_key' => 'company']);
                $request->merge(['fk_id' => $company_obj->id]);
                if ($request->email) {

                    $ph_countrycode = $request->ph_countrycode;
                    $ph_areacode = $request->ph_areacode;
                    $ph_number = $request->ph_number;

                    if ($ph_countrycode && $ph_areacode && $ph_number) {
                        $phone = $ph_countrycode . $ph_areacode . $ph_number;
                        $request->merge(['phone' => $phone]);
                    }

                    $contact_obj = new Contact($request->all());
                    $contact_obj->save();
                }
                if ($request->country || $request->city) {
                    $address_obj = new Address($request->all());
                    $address_obj_saved = $address_obj->save();
                }

                if ($request->own_job) {
                    $own_job_type = $request->own_job;
                    //dd($own_product_type);
                    $job_type_obj = JobTitle::where('name', $own_job_type)->get();
                    //dd($product_type_obj);
                    if ($job_type_obj->count() > 0) {
                    } else {

                        $Job_type = new JobTitle();
                        $Job_type->fk_by = Auth::id();
                        $Job_type->name = $own_job_type;
                        $Job_type->save();

//                            $request->merge(['fk_company_id' => $company_obj->id]);
//                            $request->merge(['fk_user_id',Auth::id()]);
//                            $request->merge(['fk_job_title_id',$Job_type->id]);
                        $pivot_user_company_role_obj = new PivotUserCompanyRole();
                        $pivot_user_company_role_obj->fk_company_id = $company_obj->id;
                        $pivot_user_company_role_obj->fk_user_id = Auth::id();
                        $pivot_user_company_role_obj->fk_job_title_id = $Job_type->id;
                        $pivot_user_company_role_obj->details = $request->details;
                        $is_saved = $pivot_user_company_role_obj->save();


                    }
                }


                if ($request->fk_job_title_id && empty($request->own_job)) {
                    $request->merge(['fk_company_id' => $company_obj->id]);
                    $pivot_user_company_role_obj = new PivotUserCompanyRole($request->all());
                    $is_saved = $pivot_user_company_role_obj->save();
                }
                if (isset($request->specialities)) {
                    if ($request->specialities) {
                        $specialities = $request->specialities;
                        foreach ($specialities as $speciality) {
                            if ($speciality) {

                                $speciality_obj = new CompanySpeciality();
                                $speciality_obj->name = $speciality;
                                $speciality_obj->fk_company_id = $company_obj->id;

                                $is_saved = $speciality_obj->save();
                            }

                        }
                    }
                }
                if ($request->own_product) {
                    $own_product_type = $request->own_product;
                    //dd($own_product_type);
                    $product_type_obj = ProductType::where('name', $own_product_type)->get();
                    //dd($product_type_obj);
                    if ($product_type_obj->count() > 0) {
                    } else {
                        $product_type = new ProductType();
                        $product_type->name = $own_product_type;
                        $product_type->fk_by = Auth::id();
                        $product_type->save();
                        //$request->merge([$product_type->id]);
                        $pivot_company_product_obj = new PivotCompanyProduct();
                        $pivot_company_product_obj->fk_company_id = $company_obj->id;
                        $pivot_company_product_obj->fk_product_type_id = $product_type->id;
                        // fk_product_type_id   is been set in request

                        $pivot_company_product_obj->save();
                    }
                }
                if (isset($request->fk_product_type_id) && !empty($request->fk_product_type_id) && empty($request->own_product)) {
                    $pivot_company_product_obj = new PivotCompanyProduct($request->all());
                    $pivot_company_product_obj->fk_company_id = $company_obj->id; // fk_product_type_id   is been set in request

                    $pivot_company_product_obj->save();
                }


                $company_logo_image_obj = new Media();
                if (@$request->file('company_logo_image')) {

                    if ($request->file('company_logo_image')->getClientSize()) {

                        $media_file = $request->file('company_logo_image');
                        $media_file_name = preg_replace('/[^ \w]+/', '', pathinfo($media_file->getClientOriginalName(), PATHINFO_FILENAME));
                        $media_file_extension = pathinfo($media_file->getClientOriginalName(), PATHINFO_EXTENSION);
                        $media_file_name_unique = $media_file_name . '-' . date("Ymdhis") . rand(0, 999) . Auth::user()->id . '.' . $media_file_extension;
                        $media_file_name_unique = str_replace(' ', '-', $media_file_name_unique);

                        $company_logo_image_obj->fk_db_key = "company_logo_image";
                        $company_logo_image_obj->fk_by_id = Auth::id();
                        $company_logo_image_obj->fk_id = $company_obj->id; ////// THIS SHOULD BE PRODUCT ID
                        $company_logo_image_obj->filename = $media_file_name_unique; // $request->file('company_logo_image')->getClientOriginalName();
                        $company_logo_image_obj->type = $request->file('company_logo_image')->getClientOriginalExtension();
                        $company_logo_image_obj->size = $request->file('company_logo_image')->getClientSize();

                        if ($company_logo_image_obj->save()) {

                            $ImageManager = new ImageManager();
                            //  Moving Image
                            $request->file('company_logo_image')->move(config('constants.company_logo_main'), $media_file_name_unique);
                            if (substr($request->file('company_logo_image')->getClientMimeType(), 0, 5) == 'image') {
                                // this is an image
                                //Generating Thumbnail
                                $ImageManager->make(config('constants.company_logo_main') . $media_file_name_unique)->resize(45, 45)->save(config('constants.company_logo_small') . $media_file_name_unique);
                                $ImageManager->make(config('constants.company_logo_main') . $media_file_name_unique)->resize(65, 65)->save(config('constants.company_logo_medium') . $media_file_name_unique);
                                $ImageManager->make(config('constants.company_logo_main') . $media_file_name_unique)->resize(200, 200)->save(config('constants.company_logo_large') . $media_file_name_unique);
                            }
                        }
                    }

                }


                //for email
                $_token = $company_obj->id . str_random(40);
                $verify_company_obj = new VerifyCompany();
                $verify_company_obj->token = $_token;
                $verify_company_obj->company_id = $company_obj->id;
                $is_saved = $verify_company_obj->save();

                if ($is_saved) {
                    // company_email isn't a database field, email is kept in contact table
                    // make relation to do it better
                    $company_obj->email = $request->email;
                    Mail::to($company_obj->email)->send(new CompanyVerifyMail($company_obj));
                    $status = "We have sent activation link on your email address " . $company_obj->contact->email . " , please verify. Thanks.";
                    if ($request->reg_company) {
                        return redirect('company-register')->with(['status' => $status, 'flag' => 'please_verify_email']);
                    } else {
                        return back()->with(['status' => $status, 'flag' => 'please_verify_email']);
                    }
                }
            }
        }


    }
    public function send_email_again($id,Request $request)
    {

        $company_obj = Company::find($id);
       // dd($company_obj);
        if($company_obj)
        {
           // $company_obj->email = $request->email;
            Mail::to($company_obj->contact->email)->send(new CompanyVerifyMail($company_obj));
            flash("We have sent activation link on your email address " . $company_obj->contact->email . " , please verify. Thanks.")->success()->important();
            return back();
        }
        else
        {
            exit;
        }


    }

    public function verifyCompany($token)
    {
        $flag = 0;
        //print_r($token);exit;

        $verifyCompany = VerifyCompany::where('token', $token)->first();

        //echo '<pre>';print_r($verifyCompany);echo '</pre>';exit;
        if (isset($verifyCompany)) {
            $company = $verifyCompany->Company;
            // echo '<pre>';print_r($company);echo '</pre>';exit;
            // echo $company->verified;exit;
            if (!$company->verified) {
                $verifyCompany->Company->verified = 1;
                $verifyCompany->Company->save();
                // echo $company->verified;exit;
                $flag = 1;
                $status = "Your e-mail is verified.";

            } else {
                $flag = 1;
                $status = "Your e-mail is already verified.";
            }
        } else {
            return redirect('/')->with('warning', "Sorry your email cannot be identified.");

        }
        if ($flag == 1) {

            // $status = "Company email ".$company->email." has been verified.";
            $status = $company->email;
            // return redirect('/verify-company')->with('status', $status);


            return redirect("company/" . $company->id . "/edit")->with('status', 'your email ' . $status . ' is verified');


        } else {
            return redirect('/')->with('status', $status);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company_obj = Company::find($id);

        return view('WC_Companies.view-company', compact('company_obj'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $company_types = CompanyType::all();
        $product_types = ProductType::all();
        $company_size = CompanySize::all();
        $users = User::all();
        $company_admins = CompanyAdmin::where('fk_company_id', $id)->get();
        $job_titles = JobTitle::all();
        $company_obj = Company::find($id);
        $job_types_detail = $company_obj->job_titles;
        $user_company_role = $company_obj->user_company_role;
        $company_specialities = $company_obj->company_specialities;
        // $company_product_details = $company_obj->company_product_details;
        //$name = PivotCompanyProduct::find(1)->product;
        //dd($name);
        if ($company_obj) {
            if (isset($_GET['tab']) && $_GET['tab'] == "contact") {
                return view('WC_Companies.company-contact-edit', compact('company_types', 'product_types', 'company_size', 'job_titles', 'company_obj', 'job_types_detail', 'user_company_role', 'company_specialities', 'company_product_details', 'users', 'company_admins'));

            }
            if (isset($_GET['tab']) && $_GET['tab'] == "convention") {
                return view('WC_Companies.company-convention-edit', compact('company_types', 'product_types', 'company_size', 'job_titles', 'company_obj', 'job_types_detail', 'user_company_role', 'company_specialities', 'company_product_details', 'users'));

            }
            if (isset($_GET['tab']) && $_GET['tab'] == "technology") {
                return view('WC_Companies.company-technology-edit', compact('company_types', 'product_types', 'company_size', 'job_titles', 'company_obj', 'job_types_detail', 'user_company_role', 'company_specialities', 'company_product_details', 'users'));

            }
            if (isset($_GET['tab']) && $_GET['tab'] == "settings") {
                return view('WC_Companies.company-setting', compact('company_types', 'product_types', 'company_size', 'job_titles', 'company_obj', 'job_types_detail', 'user_company_role', 'company_specialities', 'company_product_details', 'users'));
            }


            return view('WC_Companies.company-edit', compact('company_types', 'product_types', 'company_size', 'job_titles', 'company_obj', 'job_types_detail', 'user_company_role', 'company_specialities', 'company_product_details', 'users'));


        } else {
            echo "Company do not exists.";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $logged_user_id = Auth::id();
        // dd($request->all());
        if (isset($request->btn_company_info)) {

            $company_create_validation = $request->validate([
                'name' => 'required',
                'fk_company_type' => 'required',
                'fk_product_type_id' => 'required',
                'fk_company_size' => 'required',
                'fk_job_title_id' => 'required',
                'description' => 'required'
            ]);


            $company_obj = Company::find($id);

            $company_obj->name = $request->name;
            $company_obj->description = $request->description;
            $company_obj->established_year = $request->established_year;
            $company_obj->fk_company_size = $request->fk_company_size;
            $company_obj->fk_company_type = $request->fk_company_type;

            $company_obj->save();


            /*$contact_obj = @Contact::where("fk_db_key","company")->where("fk_id",$company_obj->id)->first();

            if($contact_obj){
                $contact_obj->email = $request->email;
                $contact_obj->website = $request->website;
                $contact_obj->save();
               // $to = 'company/'.$company_obj->id.'/edit';
               // return redirect($to)->with('status','Conatct successfully Update');
            } else {
                $contact_obj = new contact();
                $contact_obj->fk_db_key = "company";
                $contact_obj->email = $request->email;
                $contact_obj->website = $request->website;
                $contact_obj->save();

            }*/

            $PivotUserCompanyRole = PivotUserCompanyRole::where("fk_user_id", $logged_user_id)->where("fk_company_id", $company_obj->id)->first();
            //dd($PivotUserCompanyRole->get());

            if ($PivotUserCompanyRole) {
                $PivotUserCompanyRole->fk_job_title_id = $request->fk_job_title_id;
                $PivotUserCompanyRole->details = $request->details;
                $is_saved = $PivotUserCompanyRole->save();
            } else {
                $request->merge(['fk_company_id' => $company_obj->id]);
                $pivot_user_company_role_obj = new PivotUserCompanyRole($request->all());
                $is_saved = $pivot_user_company_role_obj->save();
            }


            $request->merge(['fk_company_id' => $id]);
            $company_obj->company_specialities()->delete();

            if (isset($request->specialities)) {
                if ($request->specialities) {
                    $specialities = $request->specialities;
                    foreach ($specialities as $speciality) {
                        if ($speciality) {
                            $speciality_obj = new CompanySpeciality();
                            $speciality_obj->name = $speciality;
                            $speciality_obj->fk_company_id = $company_obj->id;
                            $speciality_obj->save();
                        }
                    }
                }
            }


            $pivot_company_product_obj = @PivotCompanyProduct::where("fk_company_id", $id)->first();

            if ($pivot_company_product_obj) {
                $pivot_company_product_obj->fk_product_type_id = $request->fk_product_type_id;
                $pivot_company_product_obj->save();
            } else {
                $pivot_company_product_obj = new PivotCompanyProduct($request->all());
                $pivot_company_product_obj->fk_company_id = $id;

                $pivot_company_product_obj->save();

            }
            //Checking if he wants to remove then remove   Logo
            if ($request->existCompanyLogoPic == 1) {

                if ($company_obj->company_image) {
                    @unlink(config('constants.company_logo_main') . $company_obj->company_image->filename);
                    @unlink(config('constants.company_logo_small') . $company_obj->company_image->filename);
                    @unlink(config('constants.company_logo_medium') . $company_obj->company_image->filename);
                    @unlink(config('constants.company_logo_large') . $company_obj->company_image->filename);
                    $company_obj->company_image->delete();
                }
            }
            if ($request->file('company_logo_image')) {


                $unique = time();
                $manager = new ImageManager();
                $nameCompanyLogoPic = $request->file('company_logo_image')->getClientOriginalName();
                $nameCompanyLogoPic = $unique . '-' . $nameCompanyLogoPic;
                //  Moving Image
                $request->file('company_logo_image')->move(config('constants.company_logo_main'), $nameCompanyLogoPic);

                //Generating Thumbnail
                $manager->make(config('constants.company_logo_main') . $nameCompanyLogoPic)->resize(45, 45)->save(config('constants.company_logo_small') . $nameCompanyLogoPic);
                $manager->make(config('constants.company_logo_main') . $nameCompanyLogoPic)->resize(65, 65)->save(config('constants.company_logo_medium') . $nameCompanyLogoPic);
                $manager->make(config('constants.company_logo_main') . $nameCompanyLogoPic)->resize(200, 200)->save(config('constants.company_logo_large') . $nameCompanyLogoPic);

                //saving to database

                if ($company_obj->company_image) {

                    @unlink((config('constants.company_logo_main') . $company_obj->company_image->filename));
                    @unlink((config('constants.company_logo_small') . $company_obj->company_image->filename));
                    @unlink((config('constants.company_logo_medium') . $company_obj->company_image->filename));
                    @unlink((config('constants.company_logo_large') . $company_obj->company_image->filename));

                    $company_obj->company_image->filename = $nameCompanyLogoPic;
                    $company_obj->company_image->type = $request->file('company_logo_image')->getClientOriginalExtension();
                    $company_obj->company_image->size = $request->file('company_logo_image')->getClientSize();
                    $company_obj->company_image->save();

                } else {

                    $company_logo_image_obj = new Media();
                    $company_logo_image_obj->fk_db_key = "company_logo_image";
                    $company_logo_image_obj->fk_by_id = Auth::id();
                    $company_logo_image_obj->fk_id = $company_obj->id; ////// THIS SHOULD BE PRODUCT ID
                    $company_logo_image_obj->filename = $nameCompanyLogoPic; // $request->file('company_logo_image')->getClientOriginalName();
                    $company_logo_image_obj->type = $request->file('company_logo_image')->getClientOriginalExtension();
                    $company_logo_image_obj->size = $request->file('company_logo_image')->getClientSize();

                    $company_logo_image_obj->save();
                }
            }

            return back()->with('status', 'Information saved successfully.');
        }


        if (isset($request->btn_company_contact)) {


            $company_create_validation = $request->validate([
                'website' => ['required', 'regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            ]);
            // Address
            $company_obj = Company::find($id);
            // @$company_obj->address_details->delete();


            if (@$company_obj->address_details) {
                $company_obj->address_details->update($request->all());
            } else {
                $request->merge(['fk_db_key' => "company"]);
                $request->merge(['fk_id' => $id]);

                $address_obj = new Address($request->all());
                $company_obj->address_details()->save($address_obj);
            }


            // contact

            $company_obj->fk_user_help = $request->fk_user_help;
            $company_obj->fk_user_primary = $request->fk_user_primary;
            $company_obj->save();

            $contact_obj = @Contact::where("fk_db_key", "company")->where("fk_id", $company_obj->id)->first();

            if ($contact_obj) {

                $contact_obj->update($request->all());

            } else {
                $contact_obj = new contact($request->all());
                $contact_obj->fk_db_key = "company";

                $contact_obj->save();

            }
            $to = 'company/' . $company_obj->id . '/edit?tab=contact';
            return redirect($to)->with('status', 'Contact information has been updated successfully.');


        }
        if (isset($request->btn_company_technology)) {
            $company_obj = Company::find($id);
            $company_obj->update($request->all());

            $to = 'company/' . $company_obj->id . '/edit?tab=technology';
            return redirect($to)->with('status', 'Technology information has been updated successfully.');
        }

        if (isset($request->btn_company_convention)) {
            $company_obj = Company::find($id);
            $company_obj->update($request->all());

            $to = 'company/' . $company_obj->id . '/edit?tab=convention';
            return redirect($to)->with('status', 'Convention information has been updated successfully.');


        }

    }

    public function delete($id, Request $request)
    {
        $company_obj = Company::find($id);
        $check = $company_obj->verifyCompany;
        if($check)
        {
            $company_obj->verifyCompany->delete();
        }
        if($company_obj)
        {
            $is_delete = $company_obj->delete();
            if($is_delete)
            {
                flash()->success('Company has been deleted successfully.')->important();
                return redirect('company');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        echo 'hello';exit;
    }
}
