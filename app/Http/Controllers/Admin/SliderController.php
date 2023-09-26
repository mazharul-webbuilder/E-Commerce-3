<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Str;
class SliderController extends Controller
{


    public function index(){

        $sliders=DB::table('sliders')->latest()->get();
        return view('webend.ecommerce.slider.index',compact('sliders'));
    }

    public function create(){
        return view('webend.ecommerce.slider.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'nullable|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'priority'=>'required|unique:sliders,priority'
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{
                $slider = new Slider();
                $slider->title = $request->title;
                $slider->priority = $request->priority;
                $slider->slug=Str::slug($request->title.Str::random(5));

                if($request->hasFile('image')){
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();

                    $original_image_path = public_path().'/uploads/slider/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/slider/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(400,200)->save($resize_image_path);
                    $slider->image = $image_name;
                }
                $slider->save();
                if ($slider){
                    DB::commit();
                    Alert::success('Slider Created Successfully!.');
                    return back();
                }else
                {
                    DB::rollBack();
                    Alert::warning('Slider Created Failed!.');
                    return back();
                }

            }catch (QueryException $ex){
                DB::rollBack();
                return $ex->getMessage();
            }
        }
    }


    public function edit($slug){
        $slider =Slider::where('slug',$slug)->first();
        return view('webend.ecommerce.slider.edit',compact('slider'));
    }

    public function update(Request $request){
        $slider=Slider::find($request->id);
        $request->validate([
            'title' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'priority'=>'required|unique:sliders,priority,'.$slider->id
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $slider->title = $request->title;
                $slider->priority = $request->priority;
                if($request->hasFile('image')){
                    if (File::exists(public_path('/uploads/slider/original/'.$slider->image)))
                    {
                        File::delete(public_path('/uploads/slider/original/'.$slider->image));
                    }
                    if (File::exists(public_path('/uploads/slider/original/'.$slider->image)))
                    {
                        File::delete(public_path('/uploads/slider/original/'.$slider->image));
                    }
                    $image=$request->image;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $original_image_path = public_path().'/uploads/slider/original/'.$image_name;
                    $resize_image_path = public_path().'/uploads/slider/resize/'.$image_name;
                    //Resize Image
                    Image::make($image)->save($original_image_path);
                    Image::make($image)->resize(400,200)->save($resize_image_path);
                    $slider->image = $image_name;
                }
                $slider->save();
                if ($slider){
                    DB::commit();
                    Alert::success('Slider updated Successfully!.');
                    return back();
                }else
                {
                    DB::rollBack();
                    Alert::warning('Slider updation Failed!.');
                    return back();
                }
            }catch (QueryException $ex){
                DB::rollBack();
                return $ex->getMessage();
            }
        }
    }

    public function delete(Request $request){
        $data=Slider::findOrFail($request->item_id);

        if (File::exists(public_path('/uploads/slider/original/'.$data->image)))
        {
            File::delete(public_path('/uploads/slider/original/'.$data->image));
        }
        if (File::exists(public_path('/uploads/slider/resize/'.$data->image)))
        {
            File::delete(public_path('/uploads/slider/resize/'.$data->image));
        }
        $data->delete();
        return \response()->json([
            'message' => 'Slider Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }

}
