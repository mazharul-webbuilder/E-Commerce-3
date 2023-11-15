<?php

namespace App\Http\Controllers;

use App\Models\EcommerceBalanceTransfer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class EcommerceBalanceTransferHisotoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display ecommerce users balance transfer hisotry
    */
    public function index(): View
    {
        return view('webend.ecommerce.users_balance.index');
    }

    /**
     * Load datatable for admin
    */
    public function datatable(): JsonResponse
    {
        $responseData = [];

        EcommerceBalanceTransfer::cursor()->each(function ($history) use (&$responseData) {
            // Process each record and add it to $responseData
            $responseData[] = [
                'userName' => $history->user->name,
                'amount' => $history->amount,
                'type' => ucfirst(Str::replace('_', ' ', $history->type)),
                'destination' => ucfirst(Str::replace('_', ' ', $history->destination)),
            ];
        });

        return DataTables::of($responseData)->addIndexColumn()->make('true');
    }
}
