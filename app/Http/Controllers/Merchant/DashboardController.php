<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DashboardController extends Controller
{

    public function __construct(){
        $this->middleware('merchant');
    }
    public function index(){
        return view('merchant.index');
    }

    /**
     * Show Merchant Profile Page
    */
    public function profile(): View
    {
        $data = Auth::guard('merchant')->user();

        return view('merchant.profile',compact('data'));
    }


    /**
     * Update Merchant Profile
    */
    public function update_profile(Request $request){
        $request->validate([
           'name' => 'required|string',
           'phone' => 'nullable|number',
           'avatar' => 'nullable|image',
        ]);
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $merchant = \auth()->guard('merchant')->user();
                $merchant->name = $request->name;
                $merchant->phone = $request->phone;

                if (!empty($request->password)){
                    $merchant->password = Hash::make($request->password);
                }

                if($request->hasFile('avatar')){

                    if (File::exists(public_path('/uploads/merchant/'.$merchant->avatar)))
                    {
                        File::delete(public_path('/uploads/merchant/'.$merchant->avatar));
                    }
                    $image=$request->avatar;
                    $image_name=strtolower(Str::random(10)).time().".".$image->getClientOriginalExtension();

                    $image_path = public_path().'/uploads/merchant/'.$image_name;

                    Image::make($image)->save($image_path);

                    $merchant->avatar=$image_name;

                }

                $merchant->save();


                DB::commit();
                return response()->json([
                    'data'=>"Successfully Deposit",
                    'type'=>'success',
                    'status'=>200
                ]);
            }catch (QueryException $exception){
                return response()->json([
                    'data'=>$exception->getMessage(),
                    'type'=>'error',
                    'status'=>500
                ]);
            }
        }
    }

}
