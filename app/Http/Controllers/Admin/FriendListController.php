<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApprovedFriendListResource;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Friendlist;
use App\Http\Resources\FriendlistResource;

class FriendListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



//  here is the function where we can send friend request its end of this function
    public function friendlist_add(Request $request)
    {
      //  return \auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            DB::beginTransaction();
            $is_exist = Friendlist::where(function ($query) use ($request){
                $query->where('user_id_one','=',auth()->user()->id);
                $query->where('user_id_two','=',$request->user_id);
            })->orWhere(function ($query) use ($request){
                $query->where('user_id_one','=',$request->user_id);
                $query->where('user_id_two','=',auth()->user()->id);
            })->first();

            if ($is_exist ==null){
                $create = Friendlist::create([
                    'user_id_one' =>  Auth::user()->id,
                    'user_id_two'=> $request->user_id,
                    'requested_by'=> Auth::user()->id,
                    'status'=> 0,
                ]);
                $datas = [
                    'user_id'=>$request->user_id,
                    'title' =>"<b>".Auth::user()->name."</b> sent you friend request.",
                    'type'=>'friend',
                    'status'=>0
                ];
                notification($datas);
                DB::commit();
                return api_response('success','Added request successfully done.',null,200);
            }else{
                return api_response('warning','Already Requested!.',null,200);
            }
        }catch (\Exception $ex){
            DB::rollBack();
            return api_response('error','Something went a wrong',$ex->getMessage(),200);
        }
    }

    public function friendList_pending_request()
    {
        $list=Friendlist::where(['user_id_two'=>auth()->user()->id,'status'=>0])->get();
        $list = FriendlistResource::collection($list);
        return api_response('success','All pending Request.',$list,200);
    }

    public function friendList_approved_request()
    {
        $list=Friendlist::where(function ($query){
            $query->where('user_id_one','=',auth()->user()->id);
            $query->where('status','=',1);
        })->orWhere(function ($query){
            $query->where('user_id_two','=',auth()->user()->id);
            $query->where('status','=',1);
        })->get();

        $list=ApprovedFriendListResource::collection($list);

        return response()->json([
            'message' => $list,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);


        return api_response('success','All Approved Request.',$list,200);
    }

    public function user_friend_list($id)
    {
        $user = User::find($id)->only(['name','playerid','id']);
        $lists=Friendlist::where(function ($query) use ($id){
                $query->where('user_id_one','=',$id);
                $query->where('status','=',1);
            })->orWhere(function ($query) use ($id){
                $query->where('user_id_two','=',$id);
                $query->where('status','=',1);
            })->get();
        return view('webend.user.friendlist',compact('lists','user'));
    }

    public function accept_request(Request $request){
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json([
                  'message' => $validator->errors()->first(),
                'type'=>'error',
                'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }else{
            $friend_request=Friendlist::find($request->request_id);
            $friend_request->update(['status'=>1]);
            $datas = [
                'user_id'=>$request->user_id,
                'title' =>"<strong>". Auth::user()->name."</strong> accepted your friend request.",
                'type'=>'friend',
                'status'=>0
            ];
            notification($datas);
            return response()->json([
                'message' => "Accepted",
                'type'=>'error',
                'status'=>Response::HTTP_OK
            ],Response::HTTP_OK);
        }
    }

    public function reject_delete_cancel_request(Request $request){
        $validator = Validator::make($request->all(), [
            'request_id' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'type'=>'error',
                'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            DB::beginTransaction();
            $friend_request=Friendlist::find($request->request_id);
            $friend_request->delete();
            DB::commit();
            return response()->json([
                'message' => "Successfully remove",
                'type'=>'success',
                'status'=>Response::HTTP_OK
            ],Response::HTTP_OK);
        }catch (QueryException $e){
            DB::rollBack();
            $error=$e->getMessage();
            return response()->json([
                'message' => $error,
                'type'=>'error',
                'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function request_by_my_friend_list(){

        $list=Friendlist::where(['user_id_one'=>auth()->user()->id,'status'=>0])->get()->map(function ($data){
           return [
                'id'=>$data->id,
               'created_at'=>$data->created_at,
              "requested_to"=> [
                   'id'=>$data->user_two->id,
                   'name'=>$data->user_two->name,
                   'avatar'=>$data->user_two->avatar,
                   'rank'=>$data->user_two->rank->rank_name,
                   'player_number'=>$data->user_two->playerid
               ]

            ];
        });
        return response()->json([
            'data' => $list,
            'type'=>'success',
            'status'=>Response::HTTP_OK
        ],Response::HTTP_OK);
    }


    public function search_friend(Request $request){
     //   return \auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'playerid' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->first(),
                'type'=>'error',
                'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {

            $check_user=User::where('playerid',$request->playerid)->first();
           if (!empty($check_user)){
               $is_exist = Friendlist::where(function ($query) use ($check_user){
                   $query->where('user_id_one','=',auth()->user()->id);
                   $query->where('user_id_two','=',$check_user->id);
               })->orWhere(function ($query) use ($check_user){
                   $query->where('user_id_one','=',$check_user->id);
                   $query->where('user_id_two','=',auth()->user()->id);
               })->first();
               if (empty($is_exist)){
                   return response()->json([
                       'user_detail' => [
                           'id'=>$check_user->id,
                           'name'=>$check_user->name,
                           'avatar'=>$check_user->avatar,
                           'rank'=>$check_user->rank->rank_name,
                           'playerid'=>$check_user->playerid
                       ],
                       'type'=>'success',
                       'status'=>Response::HTTP_OK
                   ],Response::HTTP_OK);
               }else{
                   return response()->json([
                       'message' => "User not found",
                       'type'=>'error',
                       'status'=>Response::HTTP_NOT_FOUND
                   ],Response::HTTP_OK);
               }
           }else{
               return response()->json([
                   'message' => "User not found",
                   'type'=>'error',
                   'status'=>Response::HTTP_NOT_FOUND
               ],Response::HTTP_OK);
           }


        }catch (QueryException $e){
            $error=$e->getMessage();
            return response()->json([
                'message' => $error,
                'type'=>'error',
                'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
