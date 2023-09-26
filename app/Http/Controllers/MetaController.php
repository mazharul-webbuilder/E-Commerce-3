<?php

namespace App\Http\Controllers;

use App\Models\VersionUpdate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MetaController extends Controller
{


    public function privacy_policy()
    {
        return view('privacy_policy');
    }

    public function terms_condition()
    {
        return view('terms_condition');
    }

    public  function  get_system_version(){
        $data=VersionUpdate::query()->first();
        return response()->json([
            'data'=>$data,
            'type'=>'success',
            'status'=>200,
        ],Response::HTTP_OK);

    }
}
