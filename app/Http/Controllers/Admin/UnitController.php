<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Slider;
use App\Models\Ecommerce\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{

    public function index(){

        $units=DB::table('units')->latest()->get();
        return view('webend.ecommerce.unit.index',compact('units'));
    }

    public function create(){
        return view('webend.ecommerce.unit.create');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:units,name|max:255',
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $unit = new Unit();
                $unit->name = $request->name;
                $unit->save();
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
        $unit =Unit::find($id);
        return view('webend.ecommerce.unit.edit',compact('unit'));
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|max:255|unique:units,name,'.$request->id,
            'status' => 'required',
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $unit=Unit::find($request->id);
                $unit->name = $request->name;
                $unit->status = $request->status;
                $unit->save();
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
        $data=Unit::findOrFail($request->item_id);
        $data->delete();
        return \response()->json([
            'message' => 'Unit Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }
}
