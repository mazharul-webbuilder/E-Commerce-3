<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BalanceTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('affiliate');
    }

    /**
     * Load Data
     */
    public function datatable($userId): JsonResponse
    {
        $bTransferHistories = getEcommerceBalanceTransferHistory($userId, 'affiliate_to_user', 'user_to_affiliate');

        return DataTables::of($bTransferHistories)
            ->addIndexColumn()
            ->make(true);
    }
}
