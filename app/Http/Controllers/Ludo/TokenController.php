<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Http\Resources\Gifttokenhistory;
use App\Http\Resources\Greentoken;
use App\Http\Resources\Mygifttoken;
use App\Http\Resources\Transfertoken;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserToken;
use App\Models\User;
use App\Models\TokenInstance;
use App\Models\TokenTransferHistory;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Token;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function my_gift_token()
    {

        $tokens_from_user_tokens = UserToken::where('user_id',Auth::user()->id)->where('type','gift')->where('status',1)->latest()->get();
        $tokens_from_user_tokens = Mygifttoken::collection($tokens_from_user_tokens);
        return api_response('success','All Of my Gift token.',$tokens_from_user_tokens,Response::HTTP_OK);

    }

    public function my_transfer_token()
    {
        $tokens_from_instance = TokenInstance::where('user_id',Auth::user()->id)->latest()->get();
        $tokens_from_instance = Transfertoken::collection($tokens_from_instance);
        return api_response('success','All Of my Transfer token.',$tokens_from_instance,Response::HTTP_OK);
    }

    public function user_token($id)
    {
        $user = User::find($id);
        $user_tokens = UserToken::where('user_id',$id)->latest()->get();
        return view('webend.user_token',compact('user_tokens','user'));
    }

    public function green_token()
    {
        $green_token = UserToken::where('user_id',Auth::user()->id)->where('type','green')->latest()->get();
        $green_token = Greentoken::collection($green_token);
        return api_response('success','All Of my Green token.',$green_token,Response::HTTP_OK);
    }

    public function gift_token_history($type)
    {

        if($type == 'transfer')
        {
         $token =   TokenTransferHistory::where('provider_id',Auth::user()->id)->with(['user_token' => function($q){
            $q->where(['type' => 'gift'])->get();
            }])->get();
         $token = Gifttokenhistory::collection($token);
         return api_response('success','All of my Gift token transfer History.',$token,Response::HTTP_OK);
        }elseif ($type == 'receive'){
            $token =   TokenTransferHistory::where('receiver_id',Auth::user()->id)->with(['user_token' => function($q){
                $q->where(['type' => 'gift'])->get();
            }])->get();
            $token = Gifttokenhistory::collection($token);
            return api_response('success','All of my Gift token receive History.',$token,Response::HTTP_OK);
        }


    }

    public function transfer_token(Request $request)
    {
        $request->validate([
            'receiver_playerid'=>'required',
            'user_token_id'=>'required',
        ]);

        try {
            DB::beginTransaction();
            $token = UserToken::where('id',$request->user_token_id)->where('getting_source','!=','transfer')->where('type','gift')->where('status',1)->first();
            if ($token != null)
            {
                $user = User::where('playerid',$request->receiver_playerid)->first();
                if ($user != null)
                {
                    $token_instance = TokenInstance::create([
                        'user_id' => $token->user_id,
                        'previous_rank_id' => $token->previous_rank_id,
                        'current_rank_id' => $token->current_rank_id,
                        'withdrawal_id' => $token->withdrawal_id,
                        'token_number' => $token->token_number,
                        'getting_source' => $token->getting_source,
                        'type' => $token->type,
                        'status' => $token->status,
                    ]);
                    $token->user_id = $user->id;
                    $token->getting_source = UserToken::getting_source[2];
                    $token->previous_rank_id = null;
                    $token->current_rank_id = null;
                    $token->withdrawal_id = null;
                    $token->created_at = Carbon::now();
                    $token->save();

                    TokenTransferHistory::create([
                        'provider_id' => Auth::user()->id,
                        'receiver_id' => $user->id,
                        'user_token_id' =>$request->user_token_id,
                    ]);

                    DB::commit();
                    return api_response('success','Token Transfer Successfully Done',null,Response::HTTP_OK);

                }else{
                    return api_response('warning','User Not Found of this playerid',null,Response::HTTP_OK);
                }



            }else{
                return api_response('warning','Token Not Found ',null,Response::HTTP_OK);
            }
        }catch (\Exception $ex)
        {
            DB::rollBack();
            $ex->getMessage();

        }

    }

    public function token_transfer_history()
    {
        $all_transfer = TokenTransferHistory::latest()->get();
        return view('webend.token_transfer_history',compact('all_transfer'));

    }
   public function user_token_uses()
   {
        $tokens=UserToken::where(['user_id'=>auth()->user()->id,'status'=>0])->get();
        $tokens=Mygifttoken::collection($tokens);
        return response()->json([
            'data'=>$tokens,
            'type'=>'success',
            'status'=>Response::HTTP_OK,
        ],Response::HTTP_OK);
   }

   public function user_token_convert(Request $request){

        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $user=auth()->user();

                $needed_token=$request->token_amount*setting()->gift_to_green_convert_cost;

                $gift_tokens=UserToken::where(['user_id'=>$user->id,'type'=>'gift'])->get();

                if (count($gift_tokens)>=$needed_token){

                    $consumed_tokens=UserToken::where(['user_id'=>$user->id,'type'=>'gift'])->take($needed_token)->get();

                    for ($i=0;$i<$request->token_amount;$i++){
                        UserToken::create([
                            'user_id' => $user->id,
                            'token_number' => strtoupper(uniqid("GT")),
                            'getting_source' => UserToken::getting_source[4],
                            'type' => UserToken::token_type[1]
                        ]);
                    }
                    foreach ($consumed_tokens as $data){
                        UserToken::where('id',$data->id)->delete();
                    }

                    return response()->json([
                        'message'=>'Token Convert successfully',
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ],Response::HTTP_OK);


                }else{
                    return response()->json([
                        'message'=>'You have no enough gift token',
                        'type'=>'warning',
                        'status'=>Response::HTTP_NO_CONTENT
                    ],Response::HTTP_OK);
                }


            }catch (QueryException $exception){

            }
        }
   }
}
