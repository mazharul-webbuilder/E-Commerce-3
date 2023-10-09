<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Gallery;
use App\Models\Ecommerce\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{

    /**
     * Get Product Gallery Page
    */
    public function index($product_id): View
    {
        $product=Product::find($product_id);

        $galleries=Gallery::where('product_id',$product_id)->latest()->get();

        return view('merchant.gallery.index',compact('galleries','product'));
    }

    public function create(){
        return view('merchant.slider.create');
    }

    public function store(Request $request){
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $gallery = new Gallery();
                $gallery->product_id=$request->product_id;

                if($request->hasFile('image')){
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();

                    $original_image_path = public_path().'/uploads/gallery/original/'.$image_name;
                    $resize_large_path = public_path().'/uploads/gallery/large/'.$image_name;
//                    $resize_medium_path = public_path().'/uploads/gallery/medium/'.$image_name;
                    $resize_small_path = public_path().'/uploads/gallery/small/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(1080,675)->save($resize_large_path);
//                    Image::make($image)->resize(512,320)->save($resize_medium_path);
                    Image::make($image)->resize(256,200)->save($resize_small_path);
                    $gallery->image = $image_name;
                }
                $gallery->save();
                DB::commit();
                return \response()->json([
                    'message' => 'Successfully added',
                    'status_code' => 200,
                    'type'=>'success',
                ], Response::HTTP_OK);

            }catch (QueryException $ex){
                DB::rollBack();
                $error = $ex->getMessage();
                return \response()->json([
                    'error' => $error,
                    'type'=>'error',
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit($id){
        $gallery =Gallery::find($id);
        return view('merchant.gallery.edit',compact('gallery'));
    }
    public function update(Request $request){
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $gallery=Gallery::find($request->id);
                if($request->hasFile('image')){
                    if (File::exists(public_path('/uploads/gallery/original/'.$gallery->image)))
                    {
                        File::delete(public_path('/uploads/gallery/original/'.$gallery->image));
                    }
                    if (File::exists(public_path('/uploads/gallery/large/'.$gallery->image)))
                    {
                        File::delete(public_path('/uploads/gallery/large/'.$gallery->image));
                    }
//                    if (File::exists(public_path('/uploads/gallery/medium/'.$gallery->image)))
//                    {
//                        File::delete(public_path('/uploads/gallery/medium/'.$gallery->image));
//                    }
                    if (File::exists(public_path('/uploads/gallery/small/'.$gallery->image)))
                    {
                        File::delete(public_path('/uploads/gallery/small/'.$gallery->image));
                    }
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original_image_path = public_path().'/uploads/gallery/original/'.$image_name;
                    $resize_large_path = public_path().'/uploads/gallery/large/'.$image_name;
//                    $resize_medium_path = public_path().'/uploads/gallery/medium/'.$image_name;
                    $resize_small_path = public_path().'/uploads/gallery/small/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(1080,675)->save($resize_large_path);
//                    Image::make($image)->resize(512,320)->save($resize_medium_path);
                    Image::make($image)->resize(256,200)->save($resize_small_path);
                    $gallery->image = $image_name;
                }
                $gallery->save();
                DB::commit();
                return \response()->json([
                    'message' => 'Successfully added',
                    'status_code' => 200,
                    'type'=>'success',
                ], Response::HTTP_OK);
            }catch (QueryException $ex){
                DB::rollBack();
                $error = $ex->getMessage();
                return \response()->json([
                    'error' => $error,
                    'type'=>'error',
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * Delete Gallery Image
    */
    public function delete(Request $request): JsonResponse
    {
        $data = Gallery::findOrFail($request->item_id);

        if (File::exists(public_path('/uploads/gallery/original/'.$data->image)))
        {
            File::delete(public_path('/uploads/gallery/original/'.$data->image));
        }
        if (File::exists(public_path('/uploads/gallery/large/'.$data->image)))
        {
            File::delete(public_path('/uploads/gallery/large/'.$data->image));
        }
//        if (File::exists(public_path('/uploads/gallery/medium/'.$data->image)))
//        {
//            File::delete(public_path('/uploads/gallery/medium/'.$data->image));
//        }
        if (File::exists(public_path('/uploads/gallery/small/'.$data->image)))
        {
            File::delete(public_path('/uploads/gallery/small/'.$data->image));
        }
        $data->delete();

        return \response()->json([
            'message' => 'Gallery Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }
}
