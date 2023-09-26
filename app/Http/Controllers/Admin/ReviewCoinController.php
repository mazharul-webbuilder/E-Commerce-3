<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Review_coin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewCoinController extends Controller
{
    public function index(){
        $reviewCoins = Review_coin::latest()->get();
        return view('webend.ecommerce.review_coin.index',compact('reviewCoins'));
    }

    public function create(){
        return view('webend.ecommerce.review_coin.create');
    }

    public function store(Request $request){
        $request->validate([
            'ratting' => 'required',
            'reward_coin' => 'required|min:1',
        ]);
        if ($request->isMethod('POST'))
        {
            DB::beginTransaction();
            try{
                $reviewCoin = new Review_coin();
                $reviewCoin->ratting = $request->ratting;
                $reviewCoin->reward_coin = $request->reward_coin;
                $reviewCoin->save();
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
        $reviewCoin = Review_coin::find($id);
        return view('webend.ecommerce.review_coin.edit', compact('reviewCoin'));
    }

    public function update(Request $request){
        $reviewCoin = Review_coin::find($request->id);
        $request->validate([
            'ratting' => 'required',
            'reward_coin' => 'required|min:1',
        ]);
        if ($request->isMethod('POST'))
        {
            DB::beginTransaction();
            try{
                $reviewCoin->ratting = $request->ratting;
                $reviewCoin->reward_coin = $request->reward_coin;
                $reviewCoin->save();
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
        $reviewCoin=Review_coin::findOrFail($request->item_id);
        $reviewCoin->delete();
        return \response()->json([
            'message' => 'Review Coin Delete Successfully',
            'status_code' => 200,
            'type'=>'success'
        ], Response::HTTP_OK);
    }




}
