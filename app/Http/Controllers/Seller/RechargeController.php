<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Recharge;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                return $data->status == 1 ? 'Approved' : 'Rejected';
            })
            ->rawColumns(['payment_method', 'created_at', 'image', 'status'])
            ->make(true);

    }
}
