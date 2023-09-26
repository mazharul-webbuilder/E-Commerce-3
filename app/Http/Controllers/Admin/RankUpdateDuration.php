<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Product;
use App\Models\RankUpdateDay;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RankUpdateDuration extends Controller
{


    public function index(){
        $rank_durations=RankUpdateDay::get();
        return view('webend.rank_duration.index',compact('rank_durations'));
    }

    public function update(Request $request)
    {
        $duration=RankUpdateDay::find($request->duration_id);
        $this->validate($request,[
            'title'=>'unique:rank_update_days,title,'.$duration->id
        ]);

        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{

                $duration->title=$request->title;
                $duration->duration=$request->duration;
                $duration->save();

                DB::commit();
                return \response()->json([
                    'message' => 'Successfully updated',
                    'status_code' => 200,
                    'type'=>'success',
                ], Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();
                $error = $e->getMessage();
                return \response()->json([
                    'error' => $error,
                    'status_code' => 500,
                    'type'=>'error',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

    }

}
