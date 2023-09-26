<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Ecommerce\Stock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{



    public function index(){
        $currencies=Currency::query()->get();
        return view('webend.currency.index',compact('currencies'));
    }

    public function edit($id){
        $currency=Currency::find($id);
        return view('webend.currency.edit',compact('currency'));
    }

    public function update(Request $request){
        $request->validate([
            'country_name' => 'required',
            'currency_symbol' => 'required',
            'convert_to_bdt' => 'required',
            'convert_to_usd' => 'required',
            'convert_to_inr' => 'required',
        ]);
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();
            try{
                $stock =Currency::find($request->id);
                $stock->country_name = $request->country_name;
                $stock->currency_symbol = $request->currency_symbol;
                $stock->convert_to_bdt = $request->convert_to_bdt;
                $stock->convert_to_usd = $request->convert_to_usd;
                $stock->convert_to_inr = $request->convert_to_inr;
                $stock->save();;
                DB::commit();
                return \response()->json([
                    'message' => 'Successfully update',
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
