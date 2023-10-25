<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\WithdrawHistory;
use App\Models\WithdrawPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    /**
     * Show Seller Withdraw History
    */
    public function index(): View
    {
        return  \view('seller.withdraw.index');
    }
    /**
     * Load Seller Withdraw History
    */
    public function datatable(): JsonResponse
    {
        $withdraw_histories = DB::table('withdraw_histories')->latest()->get();

        return DataTables::of($withdraw_histories)->addIndexColumn()->rawColumns([''])->make(true);
    }

    /**
     * Show Seller Withdraw Request Form
    */
    public function withdrawRequest(): View
    {
        $payments = WithdrawPayment::all();

        return \view('seller.withdraw.request_form', compact('payments'));
    }

    /**
     * Store Seller Withdraw Request
    */
    public function withdrawRequestPost(Request $request): JsonResponse
    {
        $request->validate([
            'withdraw_balance' => 'required|numeric',
            'payment_id' => 'required',
            'balance_send_type' => 'required',
            'account_number' => 'nullable|min:11|required_with:balance_send_type,Mobile Banking',
            'ref_number' => 'nullable|string|min:1|required_with:balance_send_type,Mobile Banking',

        ]);

    }
}
