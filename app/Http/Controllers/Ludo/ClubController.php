<?php

namespace App\Http\Controllers\Ludo;

use App\Http\Controllers\Controller;
use App\Http\Resources\TournamentResource;
use App\Models\Club;
use App\Models\ShareHolderFundHistory;
use App\Models\Tournament;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    public function search_club(Request $request){
         $user=auth()->user();
        $validator=Validator::make($request->all(),[
            'club_name'=>'required'
        ]);
        if ($request->isMethod("POST")){

            if (!$validator->fails()){
                try {
                    $datas=Club::where('club_name','LIKE','%'.$request->club_name.'%')
                        ->where('id','!=',$user->club_join_id)
                        ->where('status',0)
                        ->get();

                    return response()->json([
                        'data'=>$datas,
                        'type'=>'success',
                        'club_join_cost'=>club_setting()->club_join_cost,
                        'status'=>Response::HTTP_OK,
                    ],Response::HTTP_OK);


                }catch (QueryException $exception){
                    return response()->json([
                        'data'=>$validator->getMessageBag(),
                        'type'=>'error',
                        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }else{
                return response()->json([
                    'data'=>$validator->getMessageBag(),
                    'type'=>'error',
                    'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_UNPROCESSABLE_ENTITY);

            }
        }

    }

    public function join_club(Request $request){
        $user=auth()->user();
        $validator=Validator::make($request->all(),[
            'club_id'=>'required'
        ]);

        if ($request->isMethod("POST")){

            if (!$validator->fails()){
                try {
                    if ($user->paid_coin>=club_setting()->club_join_cost){

                        DB::beginTransaction();
                        $user->club_join_id=$request->club_id;
                        $user->club_member=1;
                        $user->paid_coin=$user->paid_coin-club_setting()->club_join_cost;
                        $user->save();
                        DB::commit();

                        $my_club_owner=$user->club_join->owner->origin->id;
                        $this->club_owner_commission_when_join_club($my_club_owner);
                        $this->user_parent_club_join_commission($user);
                        $share_holder_fund_commission=(club_setting()->club_join_share_fund_commission*club_setting()->club_join_cost)/100;

                        share_holder_fund_history(SHARE_HOLDER_INCOME_SOURCE['club_registration'],$share_holder_fund_commission);

                     //DB::commit();

                        return response()->json([
                            'data'=>"Successfully joined",
                            'type'=>'success',
                            'status'=>Response::HTTP_OK,
                        ],Response::HTTP_OK);
                    }else{
                        return response()->json([
                            'data'=>"You have no enough coin",
                            'type'=>'error',
                            'status'=>Response::HTTP_FORBIDDEN,
                        ],Response::HTTP_OK);
                    }
                }catch (QueryException $exception){
                    DB::rollBack();
                    return response()->json([
                        'data'=>$validator->getMessageBag(),
                        'type'=>'error',
                        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                    ],Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }else{
                return response()->json([
                    'data'=>$validator->getMessageBag(),
                    'type'=>'error',
                    'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_UNPROCESSABLE_ENTITY);

            }
        }
    }

    public function club_tournament(){
        $user=auth()->user();
       if ($user->club_join !=null){
            $my_club_owner=$user->club_join->owner->id;
            $tournaments=Tournament::where('tournament_owner','club_owner')
                ->where('club_owner_id',$my_club_owner)
                ->where('status',1)->latest()->get();
            $tournaments=TournamentResource::collection($tournaments);
           return response()->json([
               'data'=>$tournaments,
               'type'=>'success',
               'status'=>Response::HTTP_OK
           ],Response::HTTP_OK);
       }else{
           return response()->json([
               'data'=>"Please Join a club first",
               'type'=>'error',
               'status'=>Response::HTTP_BAD_REQUEST
           ],Response::HTTP_OK);
       }
    }

    public function club_owner_commission_when_join_club($my_club_owner){
        $club_owner_commission=(club_setting()->club_join_cost*club_setting()->club_join_club_owner_commission)/100;
        $club_owner=User::find($my_club_owner);
        $club_owner->marketing_balance=$club_owner->marketing_balance+$club_owner_commission;
        $club_owner->save();
        coin_earning_history($club_owner->id,$club_owner_commission,COIN_EARNING_SOURCE['club_registration_owner_commission'],BALANCE_TYPE['marketing']);
    }

    public function user_parent_club_join_commission($user){
        $club_join_share_holder_commission=club_setting()->club_join_referral_commission;
        $club_join_cost=club_setting()->club_join_cost;
        $parent=User::where('id',$user->parent_id)->first();

        if (!empty($parent)){
            $parent_commission=($club_join_cost*$club_join_share_holder_commission)/100;
            $parent->marketing_balance=$parent->marketing_balance+$parent_commission;
            $parent->save();
            coin_earning_history($parent->id,$parent_commission,COIN_EARNING_SOURCE['club_registration_parent_commission'],BALANCE_TYPE['marketing']);
        }
    }

}
