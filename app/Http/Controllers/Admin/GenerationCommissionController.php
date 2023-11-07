<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Generation_commission;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class GenerationCommissionController extends Controller
{


    public function index()
    {
        $generations=DB::table('generation_commissions')->get();
        return view('webend.generation.index',compact('generations'));
    }

    public function update_commission(Request $request)
    {
        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $generation=Generation_commission::find($request->id);
                if ($request->type=="user"){
                    $generation->commission=$request->commission;
                }else{
                    $generation->seller_commission=$request->commission;
                }

                $generation->save();
                DB::commit();
                return response()->json([
                    'message'=>'Saving',
                    'status_code'=>200,
                    'type'=>'success'
                ],Response::HTTP_OK);
            }catch (QueryException $e){
                $error=$e->getMessage();
                return \response()->json([
                    'error' => $error,
                    'type'=>'error',
                    'status_code' => 500
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
