<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
           'email' => 'required|email|exists:merchants,email',
           'password' => 'nullable',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
           'image' => 'nullable|image',
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

                if($request->hasFile('image')){
                    /*Delete Existing*/
                    $original_image_path = "uploads/merchant/original/{$merchant->avatar}";
                    $resize_image_path = "uploads/merchant/resize/{$merchant->avatar}";

                    if (File::exists(public_path($original_image_path))) {
                        // Set permissions before deleting (e.g., set to 0644)
                        File::chmod(public_path($original_image_path), 0644);
                        File::chmod(public_path($resize_image_path), 0644);

                        // Delete the files
                        File::delete(public_path($original_image_path));
                        File::delete(public_path($resize_image_path));
                    }

                    /*Store and get image name*/
                    $merchant->avatar = store_2_type_image_nd_get_image_name($request, 'merchant', 200, 200);
                }
                $merchant->save();

                DB::commit();
                return response()->json([
                    'data' => "Profile Updated Successfully",
                    'type' => 'success',
                    'status'=> Response::HTTP_OK
                ]);
            }catch (QueryException $exception){
                return response()->json([
                    'data'=> $exception->getMessage(),
                    'type'=> 'error',
                    'status'=> Response::HTTP_INTERNAL_SERVER_ERROR
                ]);
            }
        }
    }

}
