<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BalanceTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    /**
     * Load Data
     */
    public function datatable($userId): JsonResponse
    {
        $bTransferHistories = getEcommerceBalanceTransferHistory($userId, 'seller_to_user', 'user_to_seller');

        return DataTables::of($bTransferHistories)
            ->addIndexColumn()
            ->make(true);
    }
}
