<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\WithdrawHistory;
use App\Models\WithdrawPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('merchant');
    }

    public function index(): View
    {
        return \view('merchant.withdraw.index');
    }

    /**
     * Load Merchant Withdraw History
     */
    public function datatable(): JsonResponse
    {
        $withdraw_histories = DB::table('withdraw_histories')->where('merchant_id', Auth::guard('merchant')->user()->id)->latest()->get();

        return DataTables::of($withdraw_histories)
            ->addIndexColumn()
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
            ->rawColumns(['bank_detail'])->make(true);
    }

    /**
     * Show Merchant Withdraw Request Form
     */
    public function withdrawRequest(): View
    {
        $payments = WithdrawPayment::all();

        return \view('merchant.withdraw.request_form', compact('payments'));
    }

    /**
     * Store Merchant Withdraw Request
     */
    public function withdrawRequestPost(Request $request): JsonResponse
    {
        if ($request->isMethod("post")){
            try {
                DB::beginTransaction();
                $auth_user = Auth::guard('merchant')->user();

                if ($request->withdraw_balance <= setting()->max_withdraw_limit && $request->withdraw_balance >= setting()->min_withdraw_amount) {
                    if ($auth_user->balance >= $request->withdraw_balance) {
                        $total_charge = (($request->withdraw_balance * setting()->balance_withdraw_charge) / 100);

                        $withdraw = new WithdrawHistory();
                        $withdraw->withdraw_balance = $request->withdraw_balance;
                        $withdraw->user_received_balance = $request->withdraw_balance - $total_charge;
                        $withdraw->charge = $total_charge;
                        $withdraw->balance_send_type = $request->balance_send_type;
                        $withdraw->merchant_id = $auth_user->id;
                        $withdraw->withdraw_payment_id = $request->payment_id ;
                        $withdraw->bank_detail = $request->account_number;

                        if ($request->balance_send_type == PAYMENT_TYPE[1]) {
                            $mobile_account_detail = [
                                'mobile_account_number' => $request->account_number,
                                'ref_number' => $request->ref_number,
                            ];
                            $withdraw->bank_detail = json_encode($mobile_account_detail);
                        }

                        if ($request->balance_send_type == PAYMENT_TYPE[2]) {
                            $bank_detail = [
                                'bank_holder_name' =>$request->bank_holder_name,
                                'bank_account_number' => $request->bank_account_number,
                                'bank_name' => $request->bank_name,
                                'bank_branch_name' => $request->bank_branch_name,
                                'bank_route_number' => $request->bank_route_number,
                                'bank_swift_code'=>$request->bank_swift_code
                            ];
                            $withdraw->bank_detail = json_encode($bank_detail);
                        }

                        if ($request->balance_send_type == PAYMENT_TYPE[3]) {
                            $paytm_detail = [
                                'code_or_number' =>$request->code_or_number,
                            ];
                            $withdraw->bank_detail = json_encode($paytm_detail);
                        }

                        if ($request->balance_send_type == PAYMENT_TYPE[4]) {
                            $gateway_detail = [
                                'online_gateway_email' =>$request->online_email,
                            ];
                            $withdraw->bank_detail = json_encode($gateway_detail);
                        }
                        $flag = $withdraw->save();

                        /*Deduct Amount If withdraw requested successfully */
                        if ($flag)
                        {
                            $auth_user->balance -= $request->withdraw_balance;
                            $auth_user->save();
                        }

                        DB::commit();
                        return response()->json([
                            'message' => "Your withdraw request has been successfully Send",
                            'type' => "success",
                            'status' => Response::HTTP_OK
                        ], Response::HTTP_OK);
                    } else {
                        return response()->json([
                            'message' => "You have insufficient balance",
                            'type' => "error",
                            'status' => Response::HTTP_OK
                        ]);
                    }
                } else {
                    return response()->json([
                        'message' => "Your withdraw balance should be between " . setting()->min_withdraw_amount . " to " . setting()->max_withdraw_limit,
                        'type' => "error",
                        'status' => Response::HTTP_OK
                    ]);
                }
            }catch (QueryException $exception){
                return \response()->json([
                    'message' => $exception->getMessage(),
                    'type' => "error",
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR
                ]);
            }
        }

    }
}
