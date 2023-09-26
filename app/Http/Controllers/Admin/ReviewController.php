<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Review;
use App\Models\Ecommerce\Review_coin;
use App\Models\Ecommerce\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewController extends Controller
{

    public function index(){

        $reviews=Review::latest()->get();
        return view('webend.ecommerce.review.index',compact('reviews'));
    }

    public function create(){
        return view('webend.ecommerce.size.create');
    }



    public function update(Request $request){


        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{

                $review=Review::find($request->review_id);
                $review->status = $request->status;

               // return $review;
                if ($review->coin_added==0){
                        $reward=Review_coin::where('ratting',$review->ratting)->first();
                        $user=User::find($review->user_id);
                        //return $reward;
                        $user->paid_coin=$user->paid_coin+$reward->reward_coin;
                        $user->save();
                }
                $review->coin_added=1;
                $review->save();

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
        $data=Review::findOrFail($request->item_id);
        $data->delete();
        return \response()->json([
            'message' => 'Review Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }
}
