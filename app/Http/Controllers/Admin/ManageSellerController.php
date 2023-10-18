<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recharge;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ManageSellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show History Page
    */
    public function index(): View
    {
        return \view('webend.ecommerce.seller.recharge_history');
    }

    /**
     * Load Data of Seller Recharge History
     */
    public function datatable()
    {
        $all_history = Recharge::latest('created_at')->get();

        return DataTables::of($all_history)
            ->addIndexColumn()
            ->addColumn('payment_method', function (Recharge $data) {
                return $data->payment->payment_name;
            })
            ->addColumn('created_at', function (Recharge $data){
                return date('d-m-Y', strtotime($data->created_at));
            })
            ->addColumn('image', function (Recharge $data) {
                return '<img src="'.asset('uploads/recharge_proof/resize').'/'.$data->image .'" height="50" width="80" alt="payment proof" />';
            })
            ->addColumn('status', function (Recharge $data) {
                return '<select class="block w-full mt-1 p-2 border rounded-md seller-rechareg-request"'." data-id=".$data->id.'>
                        <option value="1" '.($data->status == 1 ? 'selected' : '').' class="py-2">Pending</option>
                        <option value="2" '.($data->status == 2 ? 'selected' : '').' class="py-2">Processing</option>
                        <option value="3" '.($data->status == 3 ? 'selected' : '').' class="py-2">Approve</option>
                        <option value="4" '.($data->status == 4 ? 'selected' : '').' class="py-2">Reject</option>
                    </select>';



            })
            ->rawColumns(['payment_method', 'created_at', 'image', 'status'])
            ->make(true);

    }

    /**
     * Update Status
    */
    public function statusUpdate(Request $request)
    {
        try {
            $data = Recharge::find($request->id);
            DB::beginTransaction();
            $data->status = $request->value;
            $data->save();
            DB::commit();
            return response()->json([
                'response' => Response::HTTP_OK,
                'message' => "Status Updated Successfully",
                'type' => 'success'
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
               'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
               'message' => $exception->getMessage(),
               'type' => 'error'
            ]);
        }

    }
}
