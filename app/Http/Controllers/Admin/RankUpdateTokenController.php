<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RankUpdateToken;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RankUpdateTokenController extends Controller
{


    public function index(){
        $rank_tokens=RankUpdateToken::get();
        return view('webend.rank_gift_token.index',compact('rank_tokens'));
    }

    public function update(Request $request){
        $token=RankUpdateToken::find($request->token_id);
        $this->validate($request,[
            'title'=>'unique:rank_update_tokens,title,'.$token->id
        ]);

        if ($request->isMethod('POST'))
        {
            DB::beginTransaction();
            try{
                $token->title=$request->title;
                $token->gift_token = $request->gift_token;
                $token->save();


                DB::commit();
                return \response()->json([
                    'message' => 'Successfully updated',
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

}
