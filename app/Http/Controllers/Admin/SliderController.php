<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSliderStoreRequest;
use App\Models\Ecommerce\Slider;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
class SliderController extends Controller
{


    public function index(){

        $sliders=DB::table('sliders')->latest()->get();
        return view('webend.ecommerce.slider.index',compact('sliders'));
    }

    public function create(){
        return view('webend.ecommerce.slider.create');
    }

    public function store(AdminSliderStoreRequest $request){
        {
            try{
                DB::beginTransaction();
                Slider::create([
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
                    'message' => 'Slider Created Successfully'
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
            $original_image_path = public_path().'/uploads/slider/original/'.$image_name;
            $resize_large_path = public_path().'/uploads/slider/large/'.$image_name;
            $resize_medium_path = public_path().'/uploads/slider/medium/'.$image_name;
            $resize_small_path = public_path().'/uploads/slider/small/'.$image_name;

            //Resize Image
            Image::make($image)->save($original_image_path);
            Image::make($image)->resize(Settings::LARGE_IMAGE_WIDTH,Settings::LARGE_IMAGE_HEIGHT)->save($resize_large_path);
            Image::make($image)->resize(Settings::MEDIUM_IMAGE_WIDTH,Settings::MEDIUM_IMAGE_HEIGHT)->save($resize_medium_path);
            Image::make($image)->resize(Settings::SMALL_IMAGE_WIDTH,Settings::SMALL_IMAGE_HEIGHT)->save($resize_small_path);

            return $image_name;
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
