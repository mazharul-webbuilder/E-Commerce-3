<?php

namespace App\Http\Controllers\ClubOwner;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Owner;
use App\Models\Tournament;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class OwnerDashboardController extends Controller
{

    public function __construct(){
         $this->middleware('owner');
    }

    public function index(){

        return view('webend.club_owner.layouts.club_home');
    }
    public function club_member(){

        $club_owner=auth()->guard('owner')->user();
        $club_members=User::where('club_join_id',$club_owner->club_id)->get();
        return view('webend.club_owner.club_member',compact('club_members'));
    }

    public function club_info(){
        $auth_user=Auth::guard('owner')->user();
        $club=Club::find($auth_user->club_id);

        return view('webend.club_owner.club_info',compact('club'));
    }

    public function update_club_info(Request $request){
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

    public function profile(){
        $auth_user=Auth::guard('owner')->user();
        return view('webend.club_owner.profile',compact('auth_user'));
    }

    public function update_profile(Request $request){
        //dd($request->all());
        $owner=Owner::find($request->id);

        $this->validate($request,[
            'name'=>'required',
            'password'=>'nullable',
            'phone'=>'nullable',

        ]);
        if ($request->isMethod("POST")){
            try {
                DB::beginTransaction();

                if($request->hasFile('avatar')){
                    if (File::exists(public_path('/uploads/club_owner/'.$owner->avatar)))
                    {
                        File::delete(public_path('/uploads/club_owner/'.$owner->avatar));
                    }

                    $image=$request->avatar;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();
                    $image_path = public_path().'/uploads/club_owner/'.$image_name;
                    Image::make($image)->save($image_path);
                    $owner->avatar=$image_name;
                }

                if (!empty($request->password)){
                    $owner->password=bcrypt($request->password);
                }

                $owner->name=$request->name;
                $owner->phone=$request->phone;
                $owner->save();


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
}
