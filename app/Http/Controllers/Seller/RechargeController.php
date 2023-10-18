<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Payment;
use App\Models\Recharge;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\DataTables;

class RechargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    /**
     * Seller Recharge History page load
    */
    public function index(): View
    {
        return  \view('seller.recharge.index');
    }

    /**
     * Load Data of Seller Recharge History
    */
    public function datatable()
    {
        $all_history = Recharge::where('seller_id', Auth::guard('seller')->user()->id)->get();

        return DataTables::of($all_history)
            ->addIndexColumn()
            ->addColumn('payment_method', function (Recharge $data) {
                return $data->payment->payment_name;
            })
            ->addColumn('created_at', function (Recharge $data){
                return date('d-m-Y', strtotime($data->created_at));
            })
            ->addColumn('image', function (Recharge $data) {
                return '<img src="'.asset('uploads/recharge_proof/resize').'/'.$data->image .'" height="100" width="250" alt="payment proof" />';
            })
            ->addColumn('status', function (Recharge $data) {
                $status = null;
                switch ($data->status) {
                    case 1:
                        $status = "Pending";
                        break;
                    case 2:
                        $status = "Processing";
                        break;
                    case 3:
                        $status = "Approved";
                        break;
                    case 4:
                        $status = "Rejected";
                        break;
                }
                return $status;
            })
            ->rawColumns(['payment_method', 'created_at', 'image', 'status'])
            ->make(true);

    }

    /**
     * Get Recharge request Page
    */
    public function recharge()
    {
        $payments = Payment::all();

        return \view('seller.recharge.create', compact('payments'));
    }

    /**
     * Store Seller Recharge Request
    */
    public function rechargePost(Request $request)
    {
        $request->validate([
            'deposit_amount' => 'required|numeric',
            'transaction_number' => 'required|string|unique:recharges,transaction_number',
            'note' => 'nullable|string',
            'payment_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
        ], ['transaction_number.unique' => 'Already used before']);
        try {
            DB::beginTransaction();
            Recharge::create([
                'seller_id' => Auth::guard('seller')->user()->id,
                'deposit_amount' => $request->deposit_amount,
                'transaction_number' => $request->transaction_number,
                'payment_id' => $request->payment_id,
                'note' => $request->note,
                'image' => store_2_type_image_nd_get_image_name($request, 'recharge_proof', 256, 200),
            ]);
            DB::commit();
            return response()->json([
                'response' => Response::HTTP_OK,
                'type' => 'success',
                'message' => "Recharge Request Successfully Sent"
            ]);
        } catch (QueryException $exception) {
            DB::rollBack();
            return response()->json([
                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

}
