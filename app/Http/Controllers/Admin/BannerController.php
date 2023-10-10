<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSliderStoreRequest;
use App\Http\Requests\AdminSliderUpdateRequest;
use App\Models\Ecommerce\Banner;
use App\Models\Ecommerce\Slider;
use App\Models\Settings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class BannerController extends Controller
{


    public function index(): View
    {
        $banners = DB::table('banners')->latest()->get();

        return view('webend.ecommerce.banner.index',compact('banners'));
    }

    public function create(){
        return view('webend.ecommerce.banner.create');
    }

    public function store(Request $request){
        $request->validate([
           'title_1' => 'nullable',
           'title_2' => 'nullable',
           'button_title' => 'nullable',
           'button_link' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        try{
            DB::beginTransaction();
            Banner::create([
                'title_1' => $request->title_1,
                'title_2' => $request->title_2,
                'button_title' => $request->button_title,
                'button_link' => $request->button_link,
                'image' => $this->getImageName($request),
            ]);
            DB::commit();
            return \response()->json([
                'response' => Response::HTTP_OK,
                'type' => 'success',
                'message' => 'Banner Created Successfully'
            ]);

        } catch (QueryException $e){
            DB::rollBack();
            return \response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'type' => 'error',
                'message' => $e->getMessage()
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
            $original_image_path = public_path().'/uploads/banner/original/'.$image_name;
            $resize_banner_path = public_path().'/uploads/banner/resize/'.$image_name;


            //Resize Image
            Image::make($image)->save($original_image_path);
            Image::make($image)->resize(Settings::RESIZE_BANNER_WIDTH,Settings::RESIZE_BANNER_HEIGHT)->save($resize_banner_path);

            return $image_name;
        }
    }


    /**
     * Edit Slider
     */
    public function edit($id): View
    {
        $banner = Banner::find($id);

        return view('webend.ecommerce.banner.edit',compact('banner'));
    }

    public function update(AdminSliderUpdateRequest $request, $id)
    {
        $banner = Banner::find($id);

        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $banner->title_1 = $request->title_1;
                $banner->title_2 = $request->title_2;
                $banner->button_title = $request->button_title;
                $banner->button_link = $request->button_link;
                if($request->hasFile('image')){
                    $this->deleteIfBannerImageExist($banner);
                    $banner->image = $this->getImageName($request);
                }
                $banner->save();
                DB::commit();
                return redirect()->back()->with('success', 'Banner Updated Successfully');

            }catch (QueryException $ex){
                DB::rollBack();
                return redirect()->back()->with('error', 'Something Went Wrong');
            }
        }
    }

    public function delete(Request $request)
    {
        $banner = Banner::find($request->item_id);
        $this->deleteIfBannerImageExist($banner);
        $banner->delete();
        return \response()->json([
            'message' => 'Banner Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }

    public function deleteIfBannerImageExist($banner): void
    {
        if (File::exists(public_path('/uploads/slider/original/'.$banner->image)))
        {
            File::delete(public_path('/uploads/slider/original/'.$banner->image));
        }
        if (File::exists(public_path('/uploads/resize/large/'.$banner->image)))
        {
            File::delete(public_path('/uploads/resize/large/'.$banner->image));
        }
    }

    public function updateStatus(Request $request)
    {
        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $banner = Banner::find($request->id);
                $banner->status = $banner->status == 1 ? 0 : 1;
                $banner->save();
                DB::commit();
                return \response()->json([
                    'type' => 'success',
                    'response' => Response::HTTP_OK,
                    'message' => 'Status Updated Successfully'
                ]);

            } catch (QueryException $e) {
                DB::rollBack();
                return \response()->json([
                   'type' => 'error',
                   'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                   'message' => $e->getMessage()
                ]);
            }
        }
    }




}
