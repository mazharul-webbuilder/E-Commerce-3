<?php

namespace App\Http\Controllers;

use App\Models\WithdrawHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Load All withdraw page
    */
    public function index(): View
    {
        return \view('webend.ecommerce.withdraw.all-user.index');
    }

    /**
     * Load Data
     */
    public function datatable(): JsonResponse
    {
        $withdraw_lists = WithdrawHistory::all();

        $userType = null;

        return DataTables::of($withdraw_lists)
            ->addIndexColumn()
            ->addColumn('user_name', function ($withdraw) use (&$userType){
                if (isset($withdraw->user_id)) {
                    $userType = 'Normal User';
                    return $withdraw->user->name;
                } elseif (isset($withdraw->share_owner_id)) {
                    $userType = 'Share Owner';
                    return $withdraw?->share_owner->name;
                } elseif (isset($withdraw->seller_id)) {
                    $userType = 'Seller';
                    return $withdraw?->seller->name;
                } elseif (isset($withdraw->merchant_id)) {
                    $userType = 'Merchant';
                    return $withdraw->merchant->name;
                } elseif (isset($withdraw->affiliator_id)) {
                    $userType = 'Affiliator';
                    return $withdraw->affiliator->name;
                }
                return null;
            })
            ->addColumn('user_type', function () use (&$userType){
                return $userType;
            })
            ->addColumn('status', function ($withdraw) {
                $statusOptions = [
                    1 => 'Pending',
                    2 => 'Processing',
                    3 => 'Accept',
                    4 => 'Reject',
                ];
                $statusSelect = '<select class="status-select form-control" data-id="'.$withdraw->id.'" style="background: #FFE5E5;
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
                /*Get Bank Details Array Banking or Mobile Banking*/
                $banking_details = (array) json_decode($withdraw->bank_detail, true);

                switch ($withdraw->balance_send_type){
                    case "Banking":
                        return '
                            <p class="py-1">Bank Name: '.$banking_details['bank_name'].'</p>
                            <p class="py-1">Account Holder Name: '.$banking_details['bank_holder_name'].'</p>
                            <p class="py-1">Account Number: '.$banking_details['bank_account_number'].'</p>
                            <p class="py-1">Branch Name: '.$banking_details['bank_branch_name'].'</p>
                            <p class="py-1">Routing Number: '.$banking_details['bank_route_number'].'</p>
                            <p class="py-1">Swift Code: '.$banking_details['bank_swift_code'].'</p>
                        ';
                    case "Mobile Banking":
                        return '
                            <p class="py-1">Account Number: '.$banking_details['mobile_account_number'].'</p>
                            <p class="py-1">Reference: '.$banking_details['ref_number'].'</p>
                        ';
                }
            })
            ->rawColumns(['status', 'bank_detail', 'user_type'])->make(true);

    }
}
