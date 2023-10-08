<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Ecommerce\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('webend.ecommerce.category',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

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
           'name' => 'required|max:255',
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
       ],[
               'name.required'=>'Category Title filed is required',
               'name.max'=>'Category Name Maximum Limit 255 Characters',
           ]
       );
        try {
            DB::beginTransaction();
            if ($request->image != null )
            {
                $image = $request->file('image');
                $name =  rand(10000,99999).'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/uploads/category');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath);
                }
                $img =Image::make($image->getRealPath());
                $img->resize(90, 90, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$name);
                $destinationPath ='uploads/category/'.$name;
            }else{
                $destinationPath =null;
            }

            $create = Category::create([
               'name'=>$request->name,
               'image'=> $destinationPath,
               'slug'=>str_replace(' ','_',$request->name),
               'digital_asset'=>$request->digital_asset,
            ]);
            if ($create){
                DB::commit();
                Alert::success('Category Created Successfully!.');
                return back();
            }else
            {
                DB::rollBack();
                Alert::warning('Category Created Failed!.');
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
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('webend.ecommerce.category',compact('category'));

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
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ],[
                'name.required'=>'Category Title filed is required',
                'name.max'=>'Category Name Maximum Limit 255 Characters',
            ]
        );

        try {
            $category = Category::findOrFail($id);

            DB::beginTransaction();
            if ($request->file('image'))
            {
                if($category->image != null){
                    unlink(public_path($category->image));
                }
                $image = $request->file('image');
                $name =  rand(10000,99999).'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/uploads/category');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath);
                }
                $img =Image::make($image->getRealPath());
                $img->resize(90, 90, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$name);
                $destinationPath ='uploads/category/'.$name;
                $category->image = $destinationPath;
            }

            $category->name = $request->name;
            $category->slug = str_replace(' ','_',$request->name);
            $category->digital_asset = $request->digital_asset;
            $category->save();
            DB::commit();
            Alert::success('Category Updated Successfully!.');
            return redirect()->route('category.all');

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
        $category = Category::findOrFail($id);
        if($category->image != null){
            unlink(public_path($category->image));
        }
        $category->delete();
        Alert::success('Category Deleted successfully');
        return back();
    }
}
