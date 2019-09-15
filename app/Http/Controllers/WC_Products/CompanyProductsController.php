<?php

namespace App\Http\Controllers\WC_Products;


use App\Company;
use App\WC_Models\CompanyProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\WC_Models\Media;
use Intervention\Image\ImageManager;

class CompanyProductsController extends Controller
{

    public function __construct()
    {

        $this->middleware('manage_company_products', ['only' => ['create','edit','update']]);
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

        $company_products_obj = $company_obj->products()->orderBy('id','desc')->paginate(20);
        return view('WC_Products.list-products', compact('company_obj','company_products_obj'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_id)
    {

        // change this id

        $company_obj = Company::find($company_id);
        return view('WC_Products.create-product' , compact('company_obj'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $company_product_validation = $request->validate([
            'title' => 'required',
            'overview' => 'required'
        ]);

        $request->merge(['features'=>json_encode($request->features)]);
        $request->merge(['benefits'=>json_encode($request->benefits)]);

        $company_product_obj = new CompanyProduct($request->all());
        $isSaved = $company_product_obj->save();
        if($isSaved){
            $product_logo_image_obj = new Media();
            if(@$request->file('product_logo_image')){
                if($request->file('product_logo_image')->getClientSize()){

                    $media_file = $request->file('product_logo_image');
                    $media_file_name        = preg_replace('/[^ \w]+/', '', pathinfo($media_file->getClientOriginalName(), PATHINFO_FILENAME));
                    $media_file_extension   = pathinfo($media_file->getClientOriginalName(), PATHINFO_EXTENSION);
                    $media_file_name_unique = $media_file_name.'-'.date( "Ymdhis" ).rand( 0, 999 ). Auth::user()->id . '.'.$media_file_extension;
                    $media_file_name_unique = str_replace( ' ', '-', $media_file_name_unique );



                    $product_logo_image_obj->fk_db_key = "product_logo_image";
                    $product_logo_image_obj->fk_by_id  = Auth::id();
                    $product_logo_image_obj->fk_id     = $company_product_obj->id; ////// THIS SHOULD BE PRODUCT ID
                    $product_logo_image_obj->filename  = $media_file_name_unique; // $request->file('product_logo_image')->getClientOriginalName();
                    $product_logo_image_obj->type      = $request->file('product_logo_image')->getClientOriginalExtension();
                    $product_logo_image_obj->size      = $request->file('product_logo_image')->getClientSize();

                    if($product_logo_image_obj->save()){
                        $ImageManager = new ImageManager();
                        //  Moving Image
                        $request->file('product_logo_image')->move( 'uploads/company-products/product-image/', $media_file_name_unique  );
                        if(substr($request->file('product_logo_image')->getClientMimeType(), 0, 5) == 'image') {
                            // this is an image
                            //Generating Thumbnail
                            $ImageManager->make( 'uploads/company-products/product-image/' . $media_file_name_unique )->resize( 45, 45 )->save( 'uploads/company-products/product-image/small/' . $media_file_name_unique );
                            $ImageManager->make( 'uploads/company-products/product-image/' . $media_file_name_unique )->resize( 65, 65 )->save( 'uploads/company-products/product-image/medium/' . $media_file_name_unique );
                            $ImageManager->make( 'uploads/company-products/product-image/' . $media_file_name_unique )->resize( 200, 200 )->save( 'uploads/company-products/product-image/large/' . $media_file_name_unique );
                        }
                    }
                }

            }

            $this->upload_company_products_gallery_images($request,$company_product_obj->id);

            return redirect('company/'.$request->fk_company_id.'/products')->with('status','Product added successfully.');
        }


    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $company_id, $company_product_id)
    {
        $company_product_validation = $request->validate([
            'title' => 'required',
            'overview' => 'required'
        ]);

        $request->merge(['features'=>json_encode($request->features)]);
        $request->merge(['benefits'=>json_encode($request->benefits)]);
         $company_product_obj = CompanyProduct::find($company_product_id);
        $saved =  $company_product_obj->update($request->all());

            $unique = time();
            $manager = new ImageManager();

            //Checking if he wants to remove then remove   Logo
            if ($request->existCompanyProductPic == 1) {

                if ($company_product_obj->product_image) {
                    @unlink(('uploads/company-products/product-image/' . $company_product_obj->product_image->filename));
                    @unlink(('uploads/company-products/product-image/small/' . $company_product_obj->product_image->filename));
                    @unlink(('uploads/company-products/product-image/medium/' . $company_product_obj->product_image->filename));
                    @unlink(('uploads/company-products/product-image/large/' . $company_product_obj->product_image->filename));
                    $company_product_obj->product_image->delete();
                }
            }



            if ($request->file('product_logo_image')) {



                $nameCompanyProductPic = $request->file('product_logo_image')->getClientOriginalName();
                $nameCompanyProductPic = $unique . '-' . $nameCompanyProductPic;
                //  Moving Image
                $request->file('product_logo_image')->move('uploads/company-products/product-image/', $nameCompanyProductPic);

                //Generating Thumbnail
                $manager->make('uploads/company-products/product-image/' . $nameCompanyProductPic)->resize(45, 45)->save('uploads/company-products/product-image/small/' . $nameCompanyProductPic);
                $manager->make('uploads/company-products/product-image/' . $nameCompanyProductPic)->resize(65, 65)->save('uploads/company-products/product-image/medium/' . $nameCompanyProductPic);
                $manager->make('uploads/company-products/product-image/' . $nameCompanyProductPic)->resize(200, 200)->save('uploads/company-products/product-image/large/' . $nameCompanyProductPic);

                //saving to database

                if ($company_product_obj->product_image) {

                    @unlink(('uploads/company-products/product-image/' . $company_product_obj->product_image->filename));
                    @unlink(('uploads/company-products/product-image/small/' . $company_product_obj->product_image->filename));
                    @unlink(('uploads/company-products/product-image/medium/' . $company_product_obj->product_image->filename));
                    @unlink(('uploads/company-products/product-image/large/' . $company_product_obj->product_image->filename));

                    $company_product_obj->product_image->filename = $nameCompanyProductPic;
                    $company_product_obj->product_image->type = $request->file('product_logo_image')->getClientOriginalExtension();
                    $company_product_obj->product_image->size = $request->file('product_logo_image')->getClientSize();
                    $company_product_obj->product_image->save();

                } else {

                    $product_logo_image_obj = new Media();
                    $product_logo_image_obj->fk_db_key = "product_logo_image";
                    $product_logo_image_obj->fk_by_id  = Auth::id();
                    $product_logo_image_obj->fk_id     = $company_product_obj->id; ////// THIS SHOULD BE PRODUCT ID
                    $product_logo_image_obj->filename  = $nameCompanyProductPic; // $request->file('product_logo_image')->getClientOriginalName();
                    $product_logo_image_obj->type      = $request->file('product_logo_image')->getClientOriginalExtension();
                    $product_logo_image_obj->size      = $request->file('product_logo_image')->getClientSize();

                    $product_logo_image_obj->save();
                }
            }



        $this->upload_company_products_gallery_images($request,$company_product_id);

       return back()->with('status','Information updated successfully.');
    }


    private function upload_company_products_gallery_images($request,$company_product_id){

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
                $media->fk_db_key = "company_product_gallery_images";
                $media->fk_by_id  = Auth::user()->id;
                $media->fk_id     =  $company_product_id;
                $media->filename  = $media_file_name_unique;
                $media->type      = $media_file->getClientOriginalExtension();
                $media->size      = $media_file->getClientSize();
                // $media->preview_name = $media_file->getClientOriginalName();;
                if ( $media->save() ) {
                    //  Moving Image
                    $media_file->move( 'uploads/company-products/gallery/', $media_file_name_unique );
                    if(substr($media_file->getClientMimeType(), 0, 5) == 'image') {
                        // this is an image
                        //Generating Thumbnail
                        $ImageManager->make( 'uploads/company-products/gallery/' . $media_file_name_unique )->resize( 45, 45 )->save( 'uploads/company-products/gallery/small/' . $media_file_name_unique );
                        $ImageManager->make( 'uploads/company-products/gallery/' . $media_file_name_unique )->resize( 65, 65 )->save( 'uploads/company-products/gallery/medium/' . $media_file_name_unique );
                        $ImageManager->make( 'uploads/company-products/gallery/' . $media_file_name_unique )->resize( 200, 200 )->save( 'uploads/company-products/gallery/large/' . $media_file_name_unique );
                    }
                    $names_files[] = $media_file_name_unique;
                }
            }

            return true;
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($company_id, $product_id)
    {

        return redirect('company/'.$company_id.'?product_id='.$product_id);
        exit;

        $company_obj = Company::find($company_id);
        $company_product_obj = CompanyProduct::find($product_id);
        return view('WC_Products.view-product' , compact('company_obj','company_product_obj'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($company_id,$product_id)
    {

        $company_obj = Company::find($company_id);
        $company_product_obj = CompanyProduct::find($product_id);
        return view('WC_Products.edit-product' , compact('company_obj','company_product_obj'));


    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_id, $product_id)
    {


        $company = Company::find($company_id);
        $product = CompanyProduct::find($product_id);


        if(($company) && ($product)){

        if ($product->fk_company_id == $company->id) {
            if ($company->fk_user_id == Auth::id()) {
                if($product->delete()) {
                    $gallery_media_name = [];
                    foreach ($product->product_gallery as $gallery_image)
                    {
                        //echo $gallery_image->filename;exit;
                        $gallery_media_name[] = $gallery_image->filename;
                    }
                    $total_img = count($gallery_media_name);
                    $gallery_media_deleted = $product->product_gallery()->delete();
                    if($gallery_media_deleted)
                    {

                        for($i=0; $i<$total_img; $i++)
                        {
                            @unlink(('uploads/company-products/gallery/' . $gallery_media_name[$i]));
                            @unlink(('uploads/company-products/gallery/small/' . $gallery_media_name[$i]));
                            @unlink(('uploads/company-products/gallery/medium/' . $gallery_media_name[$i]));
                            @unlink(('uploads/company-products/gallery/large/' . $gallery_media_name[$i]));
                        }
                    }
                    if($product->product_image)
                    {
                        @unlink(('uploads/company-products/product-image/' . $product->product_image->filename));
                        @unlink(('uploads/company-products/product-image/small/' . $product->product_image->filename));
                        @unlink(('uploads/company-products/product-image/medium/' . $product->product_image->filename));
                        @unlink(('uploads/company-products/product-image/large/' . $product->product_image->filename));
                    }
                }
                // remove product images as well.
                flash('Product has been deleted successfully.')->success()->important();
                return back();
            }
            flash('You are not allowed to delete this product.')->error()->important();
            return back();
        }
    }

        flash('You are not allowed to delete this product.')->error()->important();
        return back();
    }

    public function delete_media($company_id, $product_id, $media_id)
    {

        $company = Company::find($company_id);
        $product = CompanyProduct::find($product_id);
        $media = Media::find($media_id);
//        dd($media);


        if(($company) && ($product) && ($media)){

            if ($product->fk_company_id == $company->id) {
                if ($product->id == $media->fk_id) {
                    if($media->delete()){
                        @unlink(('uploads/company-products/gallery/' . $media->filename));
                        @unlink(('uploads/company-products/gallery/small/' . $media->filename));
                        @unlink(('uploads/company-products/gallery/medium/' . $media->filename));
                        @unlink(('uploads/company-products/gallery/large/' . $media->filename));
                    }

                    // remove   images as well.
                    flash('Image has been deleted successfully.')->success()->important();
                    return back();
                }
                flash('You are not allowed to delete this Image.')->error()->important();
                return back();
            }
        }

        flash('You are not allowed to delete this Image.')->error()->important();
        return back();
    }
}
