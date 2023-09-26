<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoastingMoney;
use App\Models\Club;
use App\Models\ClubSetting;
use App\Models\Deposit;
use App\Models\Owner;
use App\Models\ShareHolderSetting;
use App\Models\ShareOwner;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use phpseclib3\Crypt\Hash;
use PHPUnit\Exception;

class ClubController extends Controller
{
    public function  index(){
        $clubs=Club::latest()->get();
        return view('webend.manage_club.index',compact('clubs'));
    }

    public function create(){
        return view('webend.manage_club.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'club_name'=>'required|unique:clubs',
            'logo'=>'required'
        ]);
        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $image_name=null;
                if($request->hasFile('logo')){
                    $image=$request->logo;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $image_path = public_path().'/uploads/club_logo/'.$image_name;
                    Image::make($image)->save($image_path);
                }

                Club::create([
                    'club_name'=>$request->club_name,
                    'logo'=>$image_name,
                ]);
                DB::commit();
                return response()->json([
                    'message'=>"Successfully added",
                    'type'=>'success',
                    'status'=>Response::HTTP_OK
                ],Response::HTTP_OK);

            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function edit($id){

        $club=Club::find($id);
        return view('webend.manage_club.edit',compact('club'));

    }
    public function update(Request $request){
        $club=Club::find($request->id);

        $this->validate($request,[
            'club_name'=>'required|unique:clubs,club_name,'.$club->id,
            'logo'=>'nullable'
        ]);
        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();

                if($request->hasFile('logo')){
                    if (File::exists(public_path('/uploads/club_logo/'.$club->logo)))
                    {
                        File::delete(public_path('/uploads/club_logo/'.$club->logo));
                    }

                    $image=$request->logo;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $image_path = public_path().'/uploads/club_logo/'.$image_name;
                    Image::make($image)->save($image_path);
                    $club->logo=$image_name;
                }

                $club->club_name=$request->club_name;
                $club->save();


                DB::commit();
                return response()->json([
                    'message'=>"Successfully updated",
                    'type'=>'success',
                    'status'=>Response::HTTP_OK
                ],Response::HTTP_OK);

            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function delete(Request $request){
        $data=Club::find($request->item_id);

        if ($data->club_owner==null){
            $data->delete();
            return response()->json([
                'message'=>"Successfully deleted",
                'type'=>'success',
                'status'=>Response::HTTP_OK
            ],Response::HTTP_OK);

        }else{
            return response()->json([
                'message'=>"This club already has owner",
                'type'=>'error',
                'status'=>Response::HTTP_BAD_REQUEST
            ],Response::HTTP_OK);
        }

    }

    public function club_setting(){
        $setting=ClubSetting::first();
        return view('webend.manage_club.club_setting',compact('setting'));

    }

    public function update_setting(Request $request){


        $this->validate($request,[
            'club_join_cost'=>'required',
            'controller_tournament_post_limit'=>'required',
            'sub_controller_tournament_post_limit'=>'required',
            'club_join_referral_commission'=>'required',
            'club_join_share_fund_commission'=>'required',
            'club_join_club_owner_commission'=>'required',
            'tournament_registration_admin_commission'=>'required',
            'tournament_registration_club_owner_commission'=>'required',
        ]);
        if ($request->isMethod('POST')){
            try {
                DB::beginTransaction();
                $setting=ClubSetting::find($request->id);
                $setting->club_join_cost=$request->club_join_cost;
                $setting->controller_tournament_post_limit=$request->controller_tournament_post_limit;
                $setting->sub_controller_tournament_post_limit=$request->sub_controller_tournament_post_limit;
                $setting->club_join_referral_commission=$request->club_join_referral_commission;
                $setting->club_join_share_fund_commission=$request->club_join_share_fund_commission;
                $setting->club_join_club_owner_commission=$request->club_join_club_owner_commission;
                $setting->tournament_registration_admin_commission=$request->tournament_registration_admin_commission;
                $setting->tournament_registration_club_owner_commission=$request->tournament_registration_club_owner_commission;
                $setting->save();
                DB::commit();
                return response()->json([
                    'message'=>'Successfully Updated',
                    'type'=>'success',
                    'status'=>Response::HTTP_OK,
                ],Response::HTTP_OK);

            }catch (QueryException $exception){
                DB::rollBack();
                $e=$exception->getMessage();
                return response()->json([
                    'message'=>$e,
                    'type'=>'error',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }


    public function club_owner(){
        $club_owners=Owner::latest()->get();
        return view('webend.manage_club.club_owner',compact('club_owners'));
    }

    public function create_new_club_owner(){
        $clubs=Club::where('status',1)->get();
        $users=User::where('club_owner',0)
            ->whereHas('rank',function ($query){
                $query->whereIn('priority',[4,5]);
            })
            ->get();
        return view('webend.manage_club.create_club_owner',compact('clubs','users'));
    }

    public function store_club_owner(Request $request){
        $this->validate($request,[
            'club_id'=>'required',
            'user_id'=>'required',
            'email'=>'required|unique:owners',
            'password'=>'required',
        ]);

        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                $user=User::find($request->user_id);

               $club_owner=new Owner();
               $club_owner->name=$user->name;
               $club_owner->email=$request->email;
               $club_owner->password=bcrypt($request->password);
               $club_owner->club_id=$request->club_id;
               $club_owner->origin_id=$request->user_id;
               $club_owner->save();

               $user->club_id=$request->club_id;
               $user->club_owner=1;
               $user->save();

               $club=Club::find($request->club_id);
               $club->status=0;
               $club->save();

                DB::commit();
                return response()->json([
                    'message'=>"Successfully added",
                    'type'=>'success',
                    'status'=>Response::HTTP_OK
                ],Response::HTTP_OK);

            }catch (QueryException $exception){
                DB::rollBack();
                return response()->json([
                    'message'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>Response::HTTP_UNPROCESSABLE_ENTITY
                ],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    public function boasting_request(){
        $datas=BoastingMoney::latest()->get();
        return view('webend.manage_club.boasting_request',compact('datas'));
    }

    public function manage_boasting(Request $request){
        $data=BoastingMoney::find($request->boasting_id);

        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();
                if ($data->status==1 || $data->status==2){

                    if ($request->status==3){
                        $owner=Owner::find($data->owner_id);
                        $owner->balance=$owner->balance+$data->boasting_dollar;
                        $owner->save();
                    }
                    $data->status=$request->status;
                    $data->save();
                    DB::commit();
                    return response()->json([
                        'message'=>"Successfully updated!",
                        'type'=>'success',
                        'status'=>Response::HTTP_OK
                    ],Response::HTTP_OK);
                }
            }catch (Exception $e){
                DB::rollBack();
                $error=$e->getMessage();
                return response()->json([
                    'message'=>$error,
                    'type'=>'warning',
                    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
