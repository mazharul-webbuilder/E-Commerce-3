<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Size;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SizeController extends Controller
{
    public function index(){

        $sizes=DB::table('sizes')->latest()->get();
        return view('webend.ecommerce.size.index',compact('sizes'));
    }

    public function create(){
        return view('webend.ecommerce.size.create');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:255|unique:sizes,name',
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $size = new Size();
                $size->name = $request->name;
                $size->slug=Str::slug($request->name.Str::random(5));
                $size->save();
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


    public function edit($id)
    {
        $size =Size::find($id);
        return view('webend.ecommerce.size.edit',compact('size'));
    }

    public function update(Request $request){
        $size=Size::find($request->id);
        $request->validate([
            'name' => 'required|max:255|unique:sizes,name,'.$size->id,
            'status' => 'required',
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $size->name = $request->name;
                $size->status = $request->status;
                $size->save();
                DB::commit();
                return \response()->json([
                    'message' => 'Successfully update',
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
        $data=Size::findOrFail($request->item_id);
        $data->delete();
        return \response()->json([
            'message' => 'Size Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }
}
