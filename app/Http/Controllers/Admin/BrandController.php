<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Settings;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    /**
     * Show Brand Page
    */
    public function index(): View
    {
        $brands = DB::table('brands')->latest()->get();

        return \view('webend.ecommerce.brand.index', compact('brands'));
    }

    /**
     * Store Brand
    */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'brand_name' => 'required|string|unique:brands,brand_name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        try {
            DB::beginTransaction();
            Brand::create([
                'brand_name' => $request->brand_name,
                'image' => $this->getImageName($request),
            ]);
            DB::commit();
            return response()->json([
                'type' => 'success',
                'response' => Response::HTTP_OK,
                'message' => 'Created Successfully'
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'type' => 'error',
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

    }

    /**
     * Return Image Name
     */
    public function getImageName($request)
    {
        if($request->hasFile('image')){
            $image = $request->image;

            /*Make Unique Image Name*/
            $image_name = strtolower(Str::random(10)).time() .".". $image->getClientOriginalExtension();

            /*Make 4 different Size Path*/
            $original_image_path = public_path().'/uploads/brand/original/'.$image_name;
            $resize_brand_path = public_path().'/uploads/brand/resize/'.$image_name;


            //Resize Image
            Image::make($image)->save($original_image_path);
            Image::make($image)->resize(256, 200)->save($resize_brand_path);

            return $image_name;
        }
    }
}
