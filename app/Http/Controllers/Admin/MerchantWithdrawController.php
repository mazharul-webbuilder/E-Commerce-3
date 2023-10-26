<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MerchantWithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * View Withdraw List Of Merchant
    */
    public function index(): View
    {
        return  \view('webend.ecommerce.withdraw.merchant.index');
    }

    /**
     * Load Data
    */
    public function datatable(): JsonResponse
    {
        $withdraw_lists = DB::table('withdraw_histories')->where('merchant_id', '!=', 'null')->where('status', 1)->latest()->get();

        return DataTables::of($withdraw_lists)
            ->addIndexColumn()
            ->addColumn('status', function ($withdraw) {
                $statusOptions = [
                    1 => 'Pending',
                    2 => 'Processing',
                    3 => 'Accept',
                    4 => 'Reject',
                ];
                $statusSelect = '<select class="status-select form-control" style="background: #FFE5E5;
                                    padding: 7px;
                                    border: 1px solid transparent;
                                    border-radius: 10px;
                                    color: black;" data-id="' . $withdraw->id . '">';

                foreach ($statusOptions as $value => $label) { // $value = array_key && $label = published or unpublished
                    $selected = $withdraw->status == $value ? 'selected' : '';
                    $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                }
                $statusSelect .= '</select>';
                return $statusSelect;
            })
            ->addColumn('bank_detail', function ($withdraw){
                switch ($withdraw->balance_send_type){
                    case "Banking":
                        $banking_details = (array) json_decode($withdraw->bank_detail, true);
                        return '
                            <p class="py-1">Bank Name: '.$banking_details['bank_name'].'</p>
                            <p class="py-1">Account Holder Name: '.$banking_details['bank_holder_name'].'</p>
                            <p class="py-1">Account Number: '.$banking_details['bank_account_number'].'</p>
                            <p class="py-1">Branch Name: '.$banking_details['bank_branch_name'].'</p>
                            <p class="py-1">Routing Number: '.$banking_details['bank_route_number'].'</p>
                            <p class="py-1">Swift Code: '.$banking_details['bank_swift_code'].'</p>
                        ';


                }


            })
            ->rawColumns(['status', 'bank_detail'])->make(true);

    }
}
