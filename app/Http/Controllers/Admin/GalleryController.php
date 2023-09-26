<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Gallery;
use App\Models\Ecommerce\Product;
use App\Models\Ecommerce\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class GalleryController extends Controller
{

    public function index($product_id){

        $galleries=Gallery::where('product_id',$product_id)->latest()->get();
        $product=Product::find($product_id);
        return view('webend.ecommerce.gallery.index',compact('galleries','product'));
    }

    public function create(){
        return view('webend.ecommerce.slider.create');
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
                    $original=null;
                    $resize=null;
                    if (!file_exists(public_path().'/uploads/gallery/original/')){
                        $original=File::makeDirectory(public_path().'/uploads/gallery/original/',0777,true);
                    }
                    if (!file_exists(public_path().'/uploads/gallery/resize/')){
                        $resize=File::makeDirectory(public_path().'/uploads/gallery/resize/',0777,true);
                    }
                    $original_image_path = public_path().'/uploads/gallery/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/gallery/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(500,300)->save($resize_image_path);
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
        return view('webend.ecommerce.gallery.edit',compact('gallery'));
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
                    if (File::exists(public_path('/uploads/gallery/resize/'.$gallery->image)))
                    {
                        File::delete(public_path('/uploads/gallery/resize/'.$gallery->image));
                    }
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original_image_path = public_path().'/uploads/gallery/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/gallery/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(400,200)->save($resize_image_path);
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

    public function delete(Request $request){
        $data=Gallery::findOrFail($request->item_id);

        if (File::exists(public_path('/uploads/gallery/original/'.$data->image)))
        {
            File::delete(public_path('/uploads/gallery/original/'.$data->image));
        }
        if (File::exists(public_path('/uploads/gallery/resize/'.$data->image)))
        {
            File::delete(public_path('/uploads/gallery/resize/'.$data->image));
        }
        $data->delete();
        return \response()->json([
            'message' => 'Gallery Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }
}
