<?php

namespace App\Http\Controllers\WC_Posts;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use App\Company;
use App\WC_Models\CompanyPost;
use App\WC_Models\Media;

class companyPostsController extends Controller
{

    public function __construct()
    {

        $this->middleware('manage_company_posts', ['only' => ['create','edit','update']]);
        // $this->middleware('admin', ['only' => ['store','index']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company_id)
    {
        $company_obj = Company::find($company_id);
        $post_obj = $company_obj->posts()->orderBy('id','desc')->paginate(20);

        return view('WC_Posts.list-posts', compact('post_obj', 'company_obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_id)
    {

        $company_obj = Company::find($company_id);
        return view('WC_Posts.create-post' , compact('company_obj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company_post_validation = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

       // dd(config('constants.post_logo_image').'small');
        $user_id = Auth::id();
        $request->merge(["fk_by" => $user_id]);
        $company_post_obj = new CompanyPost($request->all());
        $is_saved = $company_post_obj->save();
        if ($is_saved) {
            if ( @$request->file( 'post_logo_image' )) {
                    $post_logo_image_obj = new Media();
                    $media_file = $request->file("post_logo_image");
                    $file_name_original = pathinfo($media_file->getClientOriginalName(), PATHINFO_FILENAME);
                    $file_extention = pathinfo($media_file->getClientOriginalName(), PATHINFO_EXTENSION);
                    $file_size = $media_file->getClientSize();
                    $file_unique_name = $file_name_original . '-' . time() . '-' . date("Ymdhis") . rand(0, 999) . Auth::user()->id . '.' . $file_extention;

                    $post_logo_image_obj->fk_db_key = "post_logo_image";
                    $post_logo_image_obj->fk_by_id = $user_id;
                    $post_logo_image_obj->fk_id = $company_post_obj->id;
                    $post_logo_image_obj->filename = $file_unique_name;
                    $post_logo_image_obj->type = $file_extention;
                    $post_logo_image_obj->size = $file_size;
                    $media_saved = $post_logo_image_obj->save();
                    if ($media_saved) {
                        $ImageManager = new ImageManager();
                        $file_moved = $request->file("post_logo_image")->move(config('constants.post_logo_image'), $file_unique_name);
                        if ($file_moved) {
                            $ImageManager->make(config('constants.post_logo_image') . $file_unique_name)->resize(45, 45)->save(config('constants.post_logo_image_small') . $file_unique_name);
                            $ImageManager->make(config('constants.post_logo_image') . $file_unique_name)->resize(65, 65)->save(config('constants.post_logo_image_medium') . $file_unique_name);
                            $ImageManager->make(config('constants.post_logo_image') . $file_unique_name)->resize(200, 200)->save(config('constants.post_logo_image_large') . $file_unique_name);
                        }
                    }
                }

            $this->upload_company_posts_gallery_images($request,$company_post_obj->id);
            $to = 'company/'.$request->fk_company_id.'/posts';
            return redirect($to)->with('status','Post has been created successfully.');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($company_id, $post_id)
    {
        return redirect('company/'.$company_id.'?post_id='.$post_id);
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($company_id,$post_id)
    {
        //echo $post_id;exit;
        //echo $company_id
        $company_obj = Company::find($company_id);
        $company_post_obj = CompanyPost::find($post_id);
       // dd($company_post_obj->post_image);
       // dd($company_post_obj->post_gallary_image);
        return view('WC_Posts.edit-post' , compact('company_obj','company_post_obj'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $company_id, $company_post_id)
    {

        $company_post_validation = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

//
        //dd($request->all());
        //$company_post_obj = CompanyPost::find($company_post_id);
        //$company_post_obj->post_gallary_image->fk_db_key;
        //echo "<pre>";print_r($company_post_obj->post_gallary_image);echo "</pre>";exit;
        $user_id = Auth::id();
        $request->merge(['fk_company_id' => $company_id, 'fk_by' => $user_id]);
        $company_post_obj = CompanyPost::find($company_post_id);
        $company_post_obj->update($request->all());



        $unique = time();
        $manager = new ImageManager();

        //Checking if he wants to remove then remove School Logo
        if ($request->existCompanyPostPic == 1) {

            if ($company_post_obj->post_image) {
                @unlink(config('constants.post_logo_image'). $company_post_obj->post_image->filename);
                @unlink(config('constants.post_logo_image_small'). $company_post_obj->post_image->filename);
                @unlink(config('constants.post_logo_image_medium') . $company_post_obj->post_image->filename);
                @unlink(config('constants.post_logo_image_large').$company_post_obj->post_image->filename);
                $company_post_obj->post_image->delete();
            }
        }

        
        if ($request->file('post_logo_image')) {



            $nameCompanyPostPic = $request->file('post_logo_image')->getClientOriginalName();
            $nameCompanyPostPic = $unique . '-' . $nameCompanyPostPic;
            //  Moving Image
            $request->file('post_logo_image')->move(config('constants.post_logo_image'), $nameCompanyPostPic);

            //Generating Thumbnail
            $manager->make(config('constants.post_logo_image').  $nameCompanyPostPic)->resize(45, 45)->save(config('constants.post_logo_image_small').$nameCompanyPostPic);
            $manager->make(config('constants.post_logo_image'). $nameCompanyPostPic)->resize(65, 65)->save(config('constants.post_logo_image_medium'). $nameCompanyPostPic);
            $manager->make(config('constants.post_logo_image'). $nameCompanyPostPic)->resize(200, 200)->save(config('constants.post_logo_image_large'). $nameCompanyPostPic);

            //saving to database

            if ($company_post_obj->post_image) {


                @unlink(config('constants.post_logo_image'). $company_post_obj->post_image->filename);
                @unlink(config('constants.post_logo_image_small'). $company_post_obj->post_image->filename);
                @unlink(config('constants.post_logo_image_medium') . $company_post_obj->post_image->filename);
                @unlink(config('constants.post_logo_image_large').$company_post_obj->post_image->filename);



                $company_post_obj->post_image->filename = $nameCompanyPostPic;
                $company_post_obj->post_image->type = $request->file('post_logo_image')->getClientOriginalExtension();
                $company_post_obj->post_image->size = $request->file('post_logo_image')->getClientSize();
                $company_post_obj->post_image->save();

            } else {

                $post_logo_image_obj = new Media();
                $post_logo_image_obj->fk_db_key = "post_logo_image";
                $post_logo_image_obj->fk_by_id  = Auth::id();
                $post_logo_image_obj->fk_id     = $company_post_obj->id; ////// THIS SHOULD BE PRODUCT ID
                $post_logo_image_obj->filename  = $nameCompanyPostPic; // $request->file('post_logo_image')->getClientOriginalName();
                $post_logo_image_obj->type      = $request->file('post_logo_image')->getClientOriginalExtension();
                $post_logo_image_obj->size      = $request->file('post_logo_image')->getClientSize();

                $post_logo_image_obj->save();
            }
        }

        

        $this->upload_company_posts_gallery_images($request,$company_post_id);

        return redirect('company/'.$request->fk_company_id.'/posts/'.$company_post_id.'/edit')->with('status','Post information has been updated successfully.');
        //return back();

    }

    private function upload_company_posts_gallery_images($request,$company_post_id){

        if ( @$request->file( 'gallery_images' )) {
            $ImageManager = new ImageManager();
            $names_files = array();
            foreach ( $request->file( 'gallery_images' ) as $key => $media_file ) {
                //$media_file_name      = $media_file->getClientOriginalName();
                $media_file_name        = preg_replace('/[^ \w]+/', '', pathinfo($media_file->getClientOriginalName(), PATHINFO_FILENAME));
                $media_file_extension   = pathinfo($media_file->getClientOriginalName(), PATHINFO_EXTENSION);
                $media_file_name_unique = $media_file_name.'-'.date( "Ymdhis" ).rand( 0, 999 ). Auth::user()->id . '.'.$media_file_extension;
                $media_file_name_unique = str_replace( ' ', '-', $media_file_name_unique );

                $media            = new Media();
                $media->fk_db_key = "company_post_gallery_images";
                $media->fk_by_id  = Auth::user()->id;
                $media->fk_id     =  $company_post_id;
                $media->filename  = $media_file_name_unique;
                $media->type      = $media_file->getClientOriginalExtension();
                $media->size      = $media_file->getClientSize();
                // $media->preview_name = $media_file->getClientOriginalName();;
                if ( $media->save() ) {
                    //  Moving Image
                    $media_file->move( config('constants.post_gallary_image'), $media_file_name_unique );
                    if(substr($media_file->getClientMimeType(), 0, 5) == 'image') {
                        // this is an image
                        //Generating Thumbnail
                        $ImageManager->make( config('constants.post_gallary_image') . $media_file_name_unique )->resize( 45, 45 )->save( config('constants.post_gallary_image_small') . $media_file_name_unique );
                        $ImageManager->make( config('constants.post_gallary_image') . $media_file_name_unique )->resize( 65, 65 )->save( config('constants.post_gallary_image_medium') . $media_file_name_unique );
                        $ImageManager->make( config('constants.post_gallary_image') . $media_file_name_unique )->resize( 200, 200 )->save( config('constants.post_gallary_image_large') . $media_file_name_unique );
                    }
                    $names_files[] = $media_file_name_unique;
                }
            }

            return true;
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_id, $post_id)
    {
       // echo 'exit';exit;
        $company = Company::find($company_id);
        $post = CompanyPost::find($post_id);
        //dd($post->post_gallary_image);
        //echo config('constants.post_gallary_image');exit;
        if(($company) && ($post)){

            if ($post->fk_company_id == $company->id) {
                if ($company->fk_user_id == Auth::id()) {
                    //$post->delete();
                    if($post->delete()) {
                        $gallery_media_name = [];
                        foreach ($post->post_gallary_image as $gallery_image)
                        {
                            //echo $gallery_image->filename;exit;
                            $gallery_media_name[] = $gallery_image->filename;
                        }
                        //dd($gallery_media_name);
                       // echo config('constants.post_gallary_image').$gallery_media_name[0];exit;
                        $total_img = count($gallery_media_name);
                       // dd($total_img);
                        $gallery_media_deleted = $post->post_gallary_image()->delete();
                        if($gallery_media_deleted)
                        {

                            for($i=0; $i<$total_img; $i++)
                            {

                                @unlink((config('constants.post_gallary_image').$gallery_media_name[$i]));
                                @unlink((config('constants.post_gallary_image_small') . $gallery_media_name[$i]));
                                @unlink((config('constants.post_gallary_image_medium') . $gallery_media_name[$i]));
                                @unlink((config('constants.post_gallary_image_large') . $gallery_media_name[$i]));
                            }

                        }
                        if($post->post_image)
                        {
                            @unlink((config('constants.post_logo_image').$post->post_image->filename));
                            @unlink((config('constants.post_logo_image_small') . $post->post_image->filename));
                            @unlink((config('constants.post_logo_image_medium') . $post->post_image->filename));
                            @unlink((config('constants.post_logo_image_large') . $post->post_image->filename));
                        }
                    }
                    // remove product images as well.
                    flash('Post has been deleted successfully.')->success()->important();
                    return back();
                }
                flash('You are not allowed to delete this post.')->error()->important();
                return back();
            }
        }

        flash('You are not allowed to delete this post.')->error()->important();
        return back();
    }

    public function delete_media($company_id, $post_id, $media_id)
    {

        $company = Company::find($company_id);
        $post = CompanyPost::find($post_id);
        $media = Media::find($media_id);

        if(($company) && ($post)){

            if ($post->fk_company_id == $company->id) {
                if ($post->id == $media->fk_id) {
                    if($media->delete())
                    {
                        @unlink((config('constants.post_gallary_image').$media->filename));
                        @unlink((config('constants.post_gallary_image_small') . $media->filename));
                        @unlink((config('constants.post_gallary_image_medium') . $media->filename));
                        @unlink((config('constants.post_gallary_image_large') . $media->filename));
                    }
                    // remove product images as well.
                    flash('Image has been deleted successfully.')->success()->important();
                    return back();
                }
                flash('You are not allowed to delete this image.')->error()->important();
                return back();
            }
        }

        flash('You are not allowed to delete this image.')->error()->important();
        return back();
    }



}
