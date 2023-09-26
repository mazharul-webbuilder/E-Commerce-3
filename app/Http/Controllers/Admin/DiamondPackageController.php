<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiamondPackage;
use App\Models\DiamondSellHistory;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiamondPackageController extends Controller
{



    public function index()
    {
        $packages=DiamondPackage::latest()->get();
        return view('webend.diamond_package.index',compact('packages'));
    }

    public function create()
    {
        return view('webend.diamond_package.create');
    }

    public function store(Request $request)
    {

        if ($request->isMethod("POST")){
            DB::beginTransaction();
            try {
                $package=new DiamondPackage();
                $package->total_diamond=$request->total_diamond;
                $package->price=$request->price;
                $package->save();
                DB::commit();
                return response()->json([
                    'message'=>'Successfully Added',
                    'status_code'=>200,
                    'type'=>'success'
                ],Response::HTTP_OK);

            }catch (QueryException $e){
                $error=$e->getMessage();
                return response()->json([
                    'error'=>$error,
                    'status_code'=>500,
                    'type'=>'error'
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function update(Request $request)
    {

        if ($request->isMethod("POST")){
            DB::beginTransaction();
            try {
                $package=DiamondPackage::find($request->id);
                $package->total_diamond=$request->total_diamond;
                $package->price=$request->price;
                $package->save();
                DB::commit();
                return response()->json([
                    'message'=>'Successfully updated',
                    'status_code'=>200,
                    'type'=>'success'
                ],Response::HTTP_OK);

            }catch (QueryException $e){
                $error=$e->getMessage();
                return response()->json([
                    'error'=>$error,
                    'status_code'=>500,
                    'type'=>'error'
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit($id){
        $package=DiamondPackage::find($id);
        return view('webend.diamond_package.edit',compact('package'));
    }

    public function delete(Request $request)
    {
        DiamondPackage::find($request->item_id)->delete();

        return response()->json([
            'message'=>'Successfully deleted',
            'status_code'=>200,
            'type'=>'success'
        ],Response::HTTP_OK);
    }


    public function diamond_sell_history(){
        $datas=DiamondSellHistory::latest()->get();
        return view('webend.diamond_package.diamond_sell_history',compact('datas'));

    }


}
