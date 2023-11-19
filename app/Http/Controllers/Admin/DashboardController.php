<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Banner;
use App\Models\Ecommerce\Slider;
use App\Models\HomeDimond;
use App\Models\HomeGame;
use App\Models\Tournament;
use App\Models\User;
use App\Models\VersionUpdate;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display Admin Dashboard
     */
    public function index(): View
    {
        $user = User::latest()->count();
        $tournament = Tournament::latest()->where('status', 1)->count();
        $banner = Banner::latest()->where('status', 1)->count();
        $slider = Slider::latest()->where('status', 1)->count();

        return view('webend.home', compact('user', 'tournament', 'banner', 'slider'));
    }


    function homegamedimomduse($game_type_id, $roomcode_id)
    {
        $user = auth()->user();

        $checkdimond = $user->paid_diamond;

        $user_dimond_use = HomeDimond::where('player_id', $user->id)
            ->where('room_code', $roomcode_id)
            ->count('dimond_usaged');

        if ($checkdimond >= 2) {
            $usedimaond = 2;
        } elseif ($checkdimond >= 1) {
            $usedimaond = 1;
        } elseif ($checkdimond >= 0) {
            $usedimaond = 0;
        }


        // $usedimaond = 2;
        // ->count('dimond_usaged');
        // $dimondtotal = $dimondusedbyuser - $user_dimond_use;



        return response()->json([
            'dimond_useable' => $usedimaond,
            'available_dimond' => $usedimaond - $user_dimond_use,
        ]);
    }

    public function system_version(){
        $data = VersionUpdate::latest()->first();

        return view('webend.system_version',compact('data'));
    }

    /**
     * Application Version Control
    */
    public function version_update(Request $request){
        $request->validate([
            'id' => ['required'],
            'version_name' => ['required', 'regex:/^[A-Za-z0-9-]+$/']
        ]);
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $data=VersionUpdate::find($request->id);
                $data->version_name=$request->version_name;
                $data->save();
                DB::commit();
                return response()->json([
                    'message'=>"Successfully updated",
                    'status'>200,
                ],200);
            }catch (QueryException $exception){
                DB::commit();
                return response()->json([
                    'data'=>$exception->getMessage(),
                    'status'>500,
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
