<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSliderStoreRequest;
use App\Http\Requests\AdminSliderUpdateRequest;
use App\Models\Ecommerce\Slider;
use App\Models\Settings;
use Illuminate\Contracts\View\View;
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


    public function index(): View
    {
        $sliders = DB::table('sliders')->latest()->get();

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


    /**
     * Edit Slider
    */
    public function edit($id): View
    {
        $slider =Slider::find($id);

        return view('webend.ecommerce.slider.edit',compact('slider'));
    }

    public function update(AdminSliderUpdateRequest $request, $id)
    {
        $slider = Slider::find($id);

        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $slider->title_1 = $request->title_1;
                $slider->title_2 = $request->title_2;
                $slider->button_title = $request->button_title;
                $slider->button_link = $request->button_link;
                if($request->hasFile('image')){
                    $this->deleteIfSliderImageExist($slider);
                    $slider->image = $this->getImageName($request);
                }
                $slider->save();
                DB::commit();
                return redirect()->back()->with('success', 'Slider Updated Successfully');

            }catch (QueryException $ex){
                DB::rollBack();
                return redirect()->back()->with('error', 'Something Went Wrong');
            }
        }
    }

    public function delete(Request $request){
        $slider = Slider::findOrFail($request->item_id);
        $this->deleteIfSliderImageExist($slider);
        $slider->delete();
        return \response()->json([
            'message' => 'Slider Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }

    public function deleteIfSliderImageExist($slider): void
    {
        if (File::exists(public_path('/uploads/slider/original/'.$slider->image)))
        {
            File::delete(public_path('/uploads/slider/original/'.$slider->image));
        }
        if (File::exists(public_path('/uploads/slider/large/'.$slider->image)))
        {
            File::delete(public_path('/uploads/slider/large/'.$slider->image));
        }
        if (File::exists(public_path('/uploads/slider/medium/'.$slider->image)))
        {
            File::delete(public_path('/uploads/slider/medium/'.$slider->image));
        }
        if (File::exists(public_path('/uploads/slider/small/'.$slider->image)))
        {
            File::delete(public_path('/uploads/slider/small/'.$slider->image));
        }
    }

    public function updateStatus(Request $request)
    {
        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $slider = Slider::find($request->id);
                $slider->status = $slider->status == 1 ? 0 : 1;
                $slider->save();
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
