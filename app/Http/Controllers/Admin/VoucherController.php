<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\ShareHolderIncomeSource;
use App\Models\Voucher;
use App\Models\VoucherRequest;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{


    public function voucher(){
        $datas=Voucher::query()->orderBy('id','DESC')->get();
        return view('webend.voucher.index',compact('datas'));
    }

    public function create_voucher(){
        return view('webend.voucher.create');
    }

    public function create_voucher_voucher(Request $request){

        if ($request->isMethod('POST')) {
            try {
                DB::beginTransaction();
                Voucher::create([
                    'voucher_number'=>$request->voucher_number,
                    'voucher_price'=>$request->voucher_price
                ]);
                DB::commit();
                return response()->json([
                    'message' => "Successfully created",
                    'type' => 'success',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);

            } catch (QueryException $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage(),
                    'type' => 'error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit_voucher($id){
        $data=Voucher::find($id);
        return view('webend.voucher.edit',compact('data'));
    }

    public function update_voucher(Request $request){
        if ($request->isMethod('POST')) {
            try {
                DB::beginTransaction();
                $data=Voucher::find($request->id);
                $data->update([
                    'voucher_number'=>$request->voucher_number,
                    'voucher_price'=>$request->voucher_price
                ]);
                DB::commit();
                return response()->json([
                    'message' => "Successfully Updated",
                    'type' => 'success',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);

            } catch (QueryException $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage(),
                    'type' => 'error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function delete_voucher(Request $request){
        if ($request->isMethod('POST')) {
            try {
                DB::beginTransaction();
                $data=Voucher::find($request->item_id);
               $data->delete();
                DB::commit();
                return response()->json([
                    'message' => "Successfully delete",
                    'type' => 'success',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);

            } catch (QueryException $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage(),
                    'type' => 'error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function voucher_request(){
        $datas=VoucherRequest::query()->orderBy('id','DESC')->get();
        $vouchers=Voucher::where('status',0)->get();
        return view('webend.voucher.voucher_request',compact('datas','vouchers'));
    }

    public function assign_voucher(Request $request){
        if ($request->isMethod('POST')) {
            try {
                DB::beginTransaction();
                $voucher=Voucher::find($request->voucher_id);
                $data=VoucherRequest::find($request->request_id);
                $data->voucher_id=$request->voucher_id;
                $data->save();
                $voucher->status=1;
                $voucher->save();

                DB::commit();
                return response()->json([
                    'message' => "Successfully assigned",
                    'type' => 'success',
                    'status' => Response::HTTP_OK
                ], Response::HTTP_OK);

            } catch (QueryException $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage(),
                    'type' => 'error',
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }


}
