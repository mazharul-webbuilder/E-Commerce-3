<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\EcommerceBalanceTransfer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BalanceTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('merchant');
    }

    /**
     * Load Data
    */
    public function datatable($userId): JsonResponse
    {
        $bTransferHistories = getEcommerceBalanceTransferHistory($userId, 'merchant_to_user', 'user_to_merchant');

        return DataTables::of($bTransferHistories)
            ->addIndexColumn()
            ->make(true);
    }
}
