<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Category;
use App\Models\Ecommerce\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use RealRashid\SweetAlert\Toaster;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('status',1)->latest()->get();
        $subCategories = SubCategory::latest()->get();
        return view('webend.ecommerce.subCategory',compact('categories', 'subCategories'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'priority' => 'required',
            'category_id' => 'required',
        ],
            [
                'name.required'=>'Subcategory Name is required',
                'name.max'=>'Subcategory Name Maximum Limit 255 Characters',
                'category_id.required'=>'Category is required for create Subcategory',
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            DB::beginTransaction();
            $priority_exist =  SubCategory::where('category_id',$request->category_id)->where('priority',$request->priority)->first();
            if($priority_exist == null){
                $subcategory = new SubCategory();
                $subcategory->name = $request->name;
                $subcategory->slug = Str::slug($request->name).'_'.rand(100,999);
                $subcategory->priority = $request->priority;
                $subcategory->category_id = $request->category_id;
                $subcategory->save();
                if ($subcategory){
                    DB::commit();
                    Alert::success('Subcategory Created Successfully');
                    return back();
                }else{
                    Alert::warning('Subcategory Created Failed');
                    return back();
                }

            }else{
                toast('Given Priority is already exist in this category!, try another','warning');
                return back();
            }
        }catch (\Exception $ex)
        {
            DB::rollBack();
            return  $ex->getMessage();
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
//        return $slug;
        $categories = Category::where('status',1)->latest()->get();
        $subCategory = SubCategory::where('slug',$slug)->firstorfail();
        return view('webend.ecommerce.subCategory',compact('categories','subCategory'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'priority' => 'required',
            'category_id' => 'required',
        ],
            [
                'name.required'=>'Subcategory Name is required',
                'name.max'=>'Subcategory Name Maximum Limit 255 Characters',
                'category_id.required'=>'Category is required for create Subcategory',
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            $subcategory = SubCategory::findOrFail($id);
            DB::beginTransaction();

            $priority_exist =  SubCategory::where('id','!=',$id)->where('category_id',$request->category_id)->get();
            foreach ($priority_exist as $serial)
            {
                if ( $serial->priority >= $request->priority){
                    SubCategory::find($serial->id)->update(['priority'=>$serial->priority+1]);
                }

            }
                $subcategory->name = $request->name;
                $subcategory->slug = Str::slug($request->name).'_'.rand(100,999);
                $subcategory->priority = $request->priority;

                $subcategory->category_id = $request->category_id;
                $subcategory->save();
                DB::commit();
                Alert::success('Subcategory Updated Successfully');
                return redirect()->route('sub-category.all');

        }catch (\Exception $ex)
        {
            DB::rollBack();
            return  $ex->getMessage();
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
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();
        Alert::success('SubCategory Deleted successfully');
        return back();
    }
}
