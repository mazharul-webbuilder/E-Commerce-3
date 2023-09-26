<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Banner;
use App\Models\Ecommerce\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('webend.ecommerce.banner',compact('banners'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'priority'=>'required|unique:banners,priority',
        ],[
                'title.max'=>'Banner Title Maximum Limit 255 Characters',
                'image.required'=>'Banner Image is Required',
                'priority.required'=>'Priority  filed is required',
                'priority.unique'=>'Priority is already Given,try another',
            ]
        );
        try {
            DB::beginTransaction();
            if ($request->image != null )
            {
                $image = $request->file('image');
                $name =  rand(10000,99999).'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/uploads/banner');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath);
                }
                $img =Image::make($image->getRealPath());
                $img->resize(400, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$name);
                $destinationPath ='uploads/banner/'.$name;
            }
            $create = Banner::create([
                'title'=>$request->title != null ? $request->title : null,
                'image'=> $destinationPath,
                'priority'=>$request->priority,
                'slug'=> Str::slug(Carbon::now()->format('Y-m-d')).'_'.rand(1000,9999),
                'status'=>1,
            ]);
            if ($create){
                DB::commit();
                Alert::success('Banner Created Successfully!.');
                return back();
            }else
            {
                DB::rollBack();
                Alert::warning('Banner Created Failed!.');
                return back();
            }

        }catch (\Exception $ex){
            DB::rollBack();
            return $ex->getMessage();
        }
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
    public function edit($slug)
    {
        $banner = Banner::where('slug',$slug)->firstorfail();
        return view('webend.ecommerce.banner',compact('banner'));
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
        $request->validate([
            'title' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'priority'=>'required|unique:banners,priority,'.$id,
        ],[
                'name.required'=>'Category Title filed is required',
                'name.max'=>'Category Name Maximum Limit 255 Characters',
                'priority.required'=>'Priority  filed is required',
                'priority.unique'=>'Priority  Should Be Unique',
            ]
        );

        try {
            $banner = Banner::findOrFail($id);

            DB::beginTransaction();
            if ($request->file('image'))
            {
                if($banner->image != null){
                    unlink(public_path($banner->image));
                }
                $image = $request->file('image');
                $name =  rand(10000,99999).'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/uploads/banner');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath);
                }
                $img =Image::make($image->getRealPath());
                $img->resize(400, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$name);
                $destinationPath ='uploads/banner/'.$name;
                $banner->image = $destinationPath;
            }

            $banner->title = $request->title;
            $banner->priority = $request->priority;
            $banner->status = $request->status;
            $banner->save();
            DB::commit();
            Alert::success('Banner Updated Successfully!.');
            return redirect()->route('banner.all');

        }catch (\Exception $ex){
            DB::rollBack();
            return $ex->getMessage();
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if($banner->image != null){
            unlink(public_path($banner->image));
        }
        $banner->delete();
        Alert::success('Banner Deleted successfully');
        return back();
    }
}
